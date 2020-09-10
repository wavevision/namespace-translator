<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Loaders\TranslationClass;

use Nette\SmartObject;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Loaders\TranslationClass\InjectFormatTranslationArray;
use Wavevision\NamespaceTranslatorTests\Helpers;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class FormatTranslationArrayTest extends DIContainerTestCase
{

	use SmartObject;
	use InjectFormatTranslationArray;

	public function test(): void
	{
		$this->assertEquals(
			['one' => 'two'],
			$this->formatTranslationArray->process(Helpers::stringToExpr("['one' => 'two']"))
		);
	}

	public function testError(): void
	{
		$this->expectException(InvalidState::class);
		$this->expectExceptionMessage('Key should be');
		$this->formatTranslationArray->process(Helpers::stringToExpr("['o'. 'one' => 'two']"));
	}

}