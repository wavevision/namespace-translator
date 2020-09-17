<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

trait InjectGetTranslationArray
{

	protected GetTranslationArray $getTranslationArray;

	public function injectGetTranslationArray(GetTranslationArray $getTranslationArray): void
	{
		$this->getTranslationArray = $getTranslationArray;
	}

}
