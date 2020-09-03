<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer\Export;

use Wavevision\NamespaceTranslator\Transfer\Export\InjectExtractTranslations;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class ExportTranslationsTest extends DIContainerTestCase
{

	use InjectExtractTranslations;

	public function testProcess(): void
	{
		$this->assertSame(
			[
				[
					'key' => 'd1.d2.key',
					'cs' => '42',
					'en' => 'eng',
				],
			],
			$this->extractTranslations->process(__DIR__ . '/../../App')
		);
	}

}
