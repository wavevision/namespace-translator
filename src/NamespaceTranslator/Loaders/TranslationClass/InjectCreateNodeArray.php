<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

trait InjectCreateNodeArray
{

	protected CreateNodeArray $createNodeArray;

	public function injectCreateNodeArray(CreateNodeArray $createNodeArray): void
	{
		$this->createNodeArray = $createNodeArray;
	}

}
