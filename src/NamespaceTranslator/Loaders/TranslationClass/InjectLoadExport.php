<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

trait InjectLoadExport
{

	protected LoadExport $loadExport;

	public function injectLoadExport(LoadExport $loadExport): void
	{
		$this->loadExport = $loadExport;
	}

}
