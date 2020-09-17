<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer\Import\Readers;

use org\bovigo\vfs\vfsStream;
use Wavevision\NamespaceTranslator\Transfer\Export\InjectConvertToLines;
use Wavevision\NamespaceTranslator\Transfer\Import\Readers\InjectGoogleSheet;
use Wavevision\NamespaceTranslator\Transfer\Storages\Google\Config;
use Wavevision\NamespaceTranslator\Transfer\Storages\Google\GoogleSheetReader;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class GoogleSheetTest extends DIContainerTestCase
{

	use InjectGoogleSheet;
	use InjectConvertToLines;

	public function test(): void
	{
		$this->mockGoogleSheet();
		$root = vfsStream::setup('r');
		vfsStream::copyFromFileSystem(__DIR__ . '/../../../App', $root);
		$this->googleSheet->read(
			new Config(
				__DIR__ . '/../../../../../temp/credentials.json',
				'1yyLcWaBh5OiLcouMr0xhCqu4o_xLrJKc2tIuupVW8LE',
				'test-sheet'
			),
			$root->url(),
		);
	}

	private function mockGoogleSheet(): void
	{
		$googleSheetReader = $this->createMock(GoogleSheetReader::class);
		$googleSheetReader->expects($this->once())->method('read')
			->willReturn([$this->convertToLines->createHeader()]);
		$this->googleSheet->injectGoogleSheetReader($googleSheetReader);
	}

}
