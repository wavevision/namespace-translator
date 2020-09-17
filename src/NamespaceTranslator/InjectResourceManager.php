<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator;

trait InjectResourceManager
{

	protected ResourceManager $resourceManager;

	public function injectResourceManager(ResourceManager $resourceManager): void
	{
		$this->resourceManager = $resourceManager;
	}

}
