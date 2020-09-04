<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

trait InjectSaveResource
{

	protected SaveResource $saveResource;

	public function injectSaveResource(SaveResource $saveResource): void
	{
		$this->saveResource = $saveResource;
	}

}
