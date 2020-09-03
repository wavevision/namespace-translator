<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer\Export\Writters;

use Nette\SmartObject;
use Wavevision\NamespaceTranslator\Transfer\Export\FileSet;
use Wavevision\NamespaceTranslator\Transfer\Export\Translations;
use Wavevision\NamespaceTranslator\Transfer\Export\Writters\InjectConvertToLines;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class CovertToLinesTest extends DIContainerTestCase
{

	use SmartObject;
	use InjectConvertToLines;

	public function testProcess(): void
	{
		$this->assertSame(
			[
				['file (editing forbidden)', 'key (editing forbidden)', 'cs', 'en', 'format (editing forbidden)'],
				['p', 'one', 'Jedna', 'One', 'neon'],
				['p', 'two', 'Dva', null, 'neon'],
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
