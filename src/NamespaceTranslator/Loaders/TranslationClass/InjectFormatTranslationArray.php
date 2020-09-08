<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

trait InjectFormatTranslationArray
{

	protected FormatTranslationArray $formatTranslationArray;

	public function injectFormatTranslationArray(FormatTranslationArray $formatTranslationArray): void
	{
		$this->formatTranslationArray = $formatTranslationArray;
	}

}
