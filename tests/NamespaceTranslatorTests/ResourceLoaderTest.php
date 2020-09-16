<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests;

use PHPUnit\Framework\TestCase;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Loaders\Manager;
use Wavevision\NamespaceTranslator\ResourceLoader;

class ResourceLoaderTest extends TestCase
{

	public function testGetResourceFormatThrowsInvalidState(): void
	{
		$this->expectException(InvalidState::class);
		(new ResourceLoader(new Manager()))->load('', '');
	}

}
