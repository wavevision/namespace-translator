<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer\Import\Readers;

use org\bovigo\vfs\vfsStream;
use Wavevision\NamespaceTranslator\Transfer\Import\Readers\InjectGoogleSheet;
use Wavevision\NamespaceTranslator\Transfer\Storages\Google\Config;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class GoogleSheetTest extends DIContainerTestCase
{

	use InjectGoogleSheet;

	public function test(): void
	{
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
		$this->assertEquals(1, 1);
	}

}
