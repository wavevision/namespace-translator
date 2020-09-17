<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Loaders\TranslationClass;

use Nette\SmartObject;
use PhpParser\Node\Expr\Array_;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Loaders\TranslationClass\InjectGetTranslationArray;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class GetTranslationArrayTest extends DIContainerTestCase
{

	use SmartObject;
	use InjectGetTranslationArray;

	public function test(): void
	{
		$this->assertInstanceOf(
			Array_::class,
			$this->getTranslationArray->process(__DIR__ . '/../../App/Models/Translated/Translations/Cs.php')
		);
	}

	public function testMissingDefine(): void
	{
		$this->exception(__DIR__ . '/Resources/InvalidName.php', "TranslationClass must contains function 'define'.");
	}

	public function testMissingFlags(): void
	{
		$this->exception(__DIR__ . '/Resources/InvalidFlags.php', "Define function must be public and static.");
	}

	public function testInvalidReturn(): void
	{
		$this->exception(__DIR__ . '/Resources/InvalidReturn.php', "Define function must return an array.");
	}

	public function testInvalidBody(): void
	{
		$this->exception(__DIR__ . '/Resources/InvalidBody.php', "Define function must have exactly one statement.");
	}

	public function testNoFunction(): void
	{
		$this->exception(__DIR__ . '/Resources/NoMethod.php', 'No class method found.');
	}

	private function exception(string $file, string $message): void
	{
		$this->expectException(InvalidState::class);
		$this->expectExceptionMessage($message);
		$this->getTranslationArray->process($file);
	}

}
