<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer\Export;

use Wavevision\NamespaceTranslator\Transfer\Export\FileSet;
use Wavevision\NamespaceTranslator\Transfer\Export\InjectExtractTranslations;
use Wavevision\NamespaceTranslator\Transfer\Export\Translations;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class ExportTranslationsTest extends DIContainerTestCase
{

	use InjectExtractTranslations;

	public function testProcess(): void
	{
		$this->assertEquals(
			(new Translations())->add(
				new FileSet(
					[
						'message' => [
							'cs' => 'Zpráva',
							'en' => 'Message',
						],
						'otherMessage' => [
							'cs' => 'Další zpráva',
							'en' => 'Other message',
						],
					],
					'/translations/',
					'neon'
				)
			),
			$this->extractTranslations->process(__DIR__ . '/../../App/Components/SomeComponent')
		);
	}

}
