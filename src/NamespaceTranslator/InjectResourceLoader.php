<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator;

trait InjectResourceLoader
{

	protected ResourceLoader $resourceLoader;

	public function injectResourceLoader(ResourceLoader $resourceLoader): void
	{
		$this->resourceLoader = $resourceLoader;
	}

}
