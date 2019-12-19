<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Loaders;

use PHPUnit\Framework\TestCase;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Loaders\Neon;

class NeonTest extends TestCase
{

	public function testLoadThrowsInvalidStateOnLocale(): void
	{
		$neon = new Neon();
		$this->expectExceptionObject(new InvalidState("Unable to detect locale for ''."));
		$neon->load('');
	}

	public function testLoadThrowsInvalidStateOnContent(): void
	{
		$neon = new Neon();
		$this->expectExceptionObject(new InvalidState("Unable to read contents of 'resource.cs.neon'."));
		$neon->load('resource.cs.neon');
	}

}
