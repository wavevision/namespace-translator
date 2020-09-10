<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer\Export\Writters;

use Wavevision\NamespaceTranslator\Transfer\Export\Writters\InjectGoogleSheet;
use Wavevision\NamespaceTranslator\Transfer\Storages\Google\Config;
use Wavevision\NamespaceTranslator\Transfer\Storages\Google\GoogleSheetWritter;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class GoogleSheetTest extends DIContainerTestCase
{

	use InjectGoogleSheet;

	public function test(): void
	{
		$this->mockGoogleSheet();
		$this->googleSheet->write(
			new Config(
				__DIR__ . '/../../../../../temp/credentials.json',
				'1yyLcWaBh5OiLcouMr0xhCqu4o_xLrJKc2tIuupVW8LE',
				'test-sheet'
			),
			__DIR__ . '/../../../App',
		);
	}

	private function mockGoogleSheet(): void
	{
		$writter = $this->createMock(GoogleSheetWritter::class);
		$writter->expects($this->once())->method('write');
		$this->googleSheet->injectGoogleSheetWritter($writter);
	}

}
