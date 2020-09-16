<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests;

use PHPUnit\Framework\TestCase;
use Wavevision\NamespaceTranslator\DomainManager;

class DomainManagerTest extends TestCase
{

	public function testGetNamespace(): void
	{
		$this->assertEquals(
			'Some\\Namespace\\SomeClass',
			(new DomainManager())->getNamespace('some.namespace.someClass')
		);
	}

}
