<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Loaders\TranslationClass;

use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Name;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Loaders\TranslationClass\InjectSerializeClassConstFetch;
use Wavevision\NamespaceTranslatorTests\Helpers;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class SerializeClassContFetchTest extends DIContainerTestCase
{

	use InjectSerializeClassConstFetch;

	public function test(): void
	{
		$this->assertEquals(
			'c:self-TEST',
			$this->serializeClassConstFetch->serialize($this->classConstFetch('self::TEST'))
		);
	}

	public function testUnsupported1(): void
	{
		$this->expectException(InvalidState::class);
		$this->expectExceptionMessage('Unsupported const format.');
		$this->serializeClassConstFetch->serialize($this->classConstFetch('$class::TEST'));
	}

	public function testUnsupported2(): void
	{
		$this->expectException(InvalidState::class);
		$this->expectExceptionMessage('Unsupported const format.');
		$this->serializeClassConstFetch->serialize(new ClassConstFetch(new Name('name'), 1));
	}

	private function classConstFetch(string $string): ClassConstFetch
	{
		return Helpers::stringToExpr($string);
	}

}
