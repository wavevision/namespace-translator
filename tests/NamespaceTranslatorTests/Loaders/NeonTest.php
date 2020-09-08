<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Loaders;

use PHPUnit\Framework\TestCase;
use Wavevision\NamespaceTranslator\Exceptions\MissingResource;
use Wavevision\NamespaceTranslator\Loaders\Neon;
use Wavevision\NamespaceTranslator\Resources\LocalePrefixPair;

class NeonTest extends TestCase
{

	public function testLoadThrowsInvalidState(): void
	{
		$neon = new Neon();
		$this->expectExceptionObject(new MissingResource("Unable to read contents of 'resource.cs.neon'."));
		$neon->load('resource.cs.neon', new LocalePrefixPair('cs'));
	}

}
