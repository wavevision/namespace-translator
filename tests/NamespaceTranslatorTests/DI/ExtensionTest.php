<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\DI;

use PHPUnit\Framework\TestCase;
use Wavevision\NamespaceTranslator\DI\Extension;
use Wavevision\NamespaceTranslator\Exceptions\InvalidArgument;

class ExtensionTest extends TestCase
{

	public function testValidationThrowsInvalidArgument(): void
	{
		$extension = new Extension();
		$extension->setConfig(['loaders' => ['loader' => self::class]]);
		$this->expectException(InvalidArgument::class);
		$extension->loadConfiguration();
	}

}
