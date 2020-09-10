<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer\Export;

use Nette\SmartObject;
use Wavevision\NamespaceTranslator\Transfer\Export\ConvertToLines;
use Wavevision\NamespaceTranslator\Transfer\Export\InjectExtractTranslationLines;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class ExtractTranslationLinesTest extends DIContainerTestCase
{

	use SmartObject;
	use InjectExtractTranslationLines;

	public function test(): void
	{
		$this->assertSame(
			[
				[ConvertToLines::FILE, ConvertToLines::KEY, 'cs', 'en', ConvertToLines::FORMAT],
				['/translations/', 'message', 'Zpráva', 'Message', 'neon'],
				['/translations/', 'otherMessage', 'Další zpráva', 'Other message', 'neon'],
			],
			$this->extractTranslationLines->process(__DIR__ . '/../../App/Components/SomeComponent')
		);
	}

}