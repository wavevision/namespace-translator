<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests;

use Contributte\Translation\Translator;
use PHPUnit\Framework\TestCase;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\ParametersManager;
use Wavevision\NamespaceTranslator\ResourceLoader;
use Wavevision\NamespaceTranslator\ResourceManager;

class ResourceManagerTest extends TestCase
{

	public function testFindResourcesThrowsInvalidState(): void
	{
		$this->expectException(InvalidState::class);
		(new ResourceManager(
			$this->createMock(ResourceLoader::class),
			$this->createMock(ParametersManager::class),
			$this->createMock(Translator::class)
		))->findResources('');
	}

}
