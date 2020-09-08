<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer\Export;

use Nette\SmartObject;
use Wavevision\NamespaceTranslator\Transfer\Export\ConvertToLines;
use Wavevision\NamespaceTranslator\Transfer\Export\FileSet;
use Wavevision\NamespaceTranslator\Transfer\Export\InjectConvertToLines;
use Wavevision\NamespaceTranslator\Transfer\Export\Translations;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class CovertToLinesTest extends DIContainerTestCase
{

	use SmartObject;
	use InjectConvertToLines;

	public function testProcess(): void
	{
		$this->assertSame(
			[
				[ConvertToLines::FILE, ConvertToLines::KEY, 'cs', 'en', ConvertToLines::FORMAT],
				['p', 'one', 'Jedna', 'One', 'neon'],
				['p', 'two', 'Dva', '', 'neon'],
			],
			$this->convertToLines->process(
				(new Translations())->add(
					new FileSet(
						[
							'one' => [
								'en' => 'One',
								'cs' => 'Jedna',
							],
							'two' => [
								'cs' => 'Dva',
							],
						],
						'p',
						'neon'
					)
				)
			)
		);
	}

}
