<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Loaders\TranslationClass;

use Nette\SmartObject;
use PhpParser\Node\Expr\Array_;
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
			$this->formatTranslationArray->process($this->expr("['one' => 'two']"))
		);
	}

	public function testError(): void
	{
		$this->expectException(InvalidState::class);
		$this->expectExceptionMessage('Key should be');
		$this->formatTranslationArray->process($this->expr("['o'. 'one' => 'two']"));
	}

	private function expr(string $string): Array_
	{
		/** @var Array_ $array */
		$array = Helpers::stringToExpr($string);
		return $array;
	}

}
