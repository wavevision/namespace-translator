<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests;

use PHPUnit\Framework\TestCase;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\ResourceManager;

class ResourceManagerTest extends TestCase
{

	public function testFindResourcesThrowsInvalidState(): void
	{
		$this->expectException(InvalidState::class);
		(new ResourceManager())->findResources('');
	}

}
