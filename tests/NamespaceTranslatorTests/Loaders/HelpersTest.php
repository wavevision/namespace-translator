<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Loaders;

use Wavevision\NamespaceTranslator\Exceptions\MissingResource;
use Wavevision\NamespaceTranslator\Loaders\InjectHelpers;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class HelpersTest extends DIContainerTestCase
{

	use InjectHelpers;

	public function testMissingResource(): void
	{
		$this->expectExceptionObject(new MissingResource("Unable to read contents of 'resource.cs.neon'."));
		$this->helpers->readResourceContent('resource.cs.neon');
	}

}
