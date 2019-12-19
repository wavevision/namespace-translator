<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Loaders;

use PHPUnit\Framework\TestCase;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Loaders\TranslationClass;
use Wavevision\NamespaceTranslator\Resources\Translation;

/**
 * @covers \Wavevision\NamespaceTranslator\Loaders\TranslationClass
 */
class TranslationClassTest extends TestCase
{

	public function testLoadThrowsInvalidStateOnLocale(): void
	{
		/** @var TranslationClass $translationClass */
		$translationClass = $this
			->getMockBuilder(TranslationClass::class)
			->setMethodsExcept(['load'])
			->getMock();
		$translationClass
			->expects($this->once())
			->method('getLocalePrefixPair')
			->willReturn(['', null]);
		$this->expectExceptionObject(new InvalidState("Unable to detect locale for ''."));
		$translationClass->load('');
	}

	public function testLoadThrowsInvalidStateOnLocaleFormat(): void
	{
		$translationClass = new TranslationClass();
		$this->expectExceptionObject(new InvalidState("Invalid locale format for 'A.php'."));
		$translationClass->load('A.php');
	}

	public function testLoadThrowsInvalidStateOnClassName(): void
	{
		$file = __DIR__ . '/../App/translations/app.cs.neon';
		$translationClass = new TranslationClass();
		$this->expectExceptionObject(new InvalidState("Unable to get translation class from '$file'."));
		$translationClass->load($file);
	}

	public function testLoadThrowsInvalidStateOnClassExistence(): void
	{
		$translationClass = new TranslationClass();
		$this->expectExceptionObject(new InvalidState("Translation class 'InvalidClass' does not exist."));
		$translationClass->load(__DIR__ . '/InvalidClass.php.txt');
	}

	public function testLoadThrowsInvalidStateOnClassInheritance(): void
	{
		$translationClass = new TranslationClass();
		$this->expectExceptionObject(
			new InvalidState(
				"Translation class '" . InvalidClass::class . "' must extend '" . Translation::class . "'."
			)
		);
		$translationClass->load(__DIR__ . '/InvalidClass.php');
	}

}
