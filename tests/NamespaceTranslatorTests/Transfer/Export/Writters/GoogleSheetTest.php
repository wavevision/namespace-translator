<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer\Export\Writters;

use Wavevision\NamespaceTranslator\Transfer\Export\Writters\InjectGoogleSheet;
use Wavevision\NamespaceTranslator\Transfer\Storages\Google\Config;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class GoogleSheetTest extends DIContainerTestCase
{

	use InjectGoogleSheet;

	public function test(): void
	{
		$this->googleSheet->write(
			new Config(
				__DIR__ . '/../../../../../temp/credentials.json', '1yyLcWaBh5OiLcouMr0xhCqu4o_xLrJKc2tIuupVW8LE'
			),
			__DIR__ . '/../../../App',
			'test-sheet'
		);
	}

}