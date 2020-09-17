<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer;

trait InjectLocales
{

	protected Locales $locales;

	public function injectLocales(Locales $locales): void
	{
		$this->locales = $locales;
	}

}
