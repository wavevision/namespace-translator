<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Loaders;

use phpmock\phpunit\PHPMock;
use PHPUnit\Framework\TestCase;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Loaders\TranslationClass;
use Wavevision\NamespaceTranslator\Resources\LocalePrefixPair;
use Wavevision\NamespaceTranslator\Resources\Translation;
use Wavevision\Utils\Strings;

/**
 * @covers \Wavevision\NamespaceTranslator\Loaders\TranslationClass
 */
class TranslationClassTest extends TestCase
{

	use PHPMock;

	public function testLoadThrowsInvalidStateOnClassName(): void
	{
		$file = __DIR__ . '/../App/translations/app.cs.neon';
		$translationClass = new TranslationClass();
		$this->expectExceptionObject(new InvalidState("Unable to get translation class from '$file'."));
		$translationClass->load($file, new LocalePrefixPair('cs'));
	}

	public function testLoadThrowsInvalidStateOnClassExistence(): void
	{
		$translationClass = new TranslationClass();
		$this->expectExceptionObject(new InvalidState("Translation class 'InvalidClass' does not exist."));
		$translationClass->load(__DIR__ . '/InvalidClass.php.txt', new LocalePrefixPair('cs'));
	}

	public function testLoadThrowsInvalidStateOnClassInheritance(): void
	{
		$translationClass = new TranslationClass();
		$this->expectExceptionObject(
			new InvalidState(
				"Translation class '" . InvalidClass::class . "' must implement '" . Translation::class . "'."
			)
		);
		$translationClass->load(__DIR__ . '/InvalidClass.php', new LocalePrefixPair('cs'));
	}

	public function testGetLocalePrefixPairThrowsInvalidState(): void
	{
		$this->getFunctionMock(Strings::getNamespace(TranslationClass::class), 'preg_split')
			->expects($this->once())
			->willReturn(false);
		$translationClass = new TranslationClass();
		$this->expectException(InvalidState::class);
		$translationClass->getLocalePrefixPair('');
	}

}
