<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

trait InjectFlattenKeys
{

	protected FlattenKeys $flattenKeys;

	public function injectFlattenKeys(FlattenKeys $flattenKeys): void
	{
		$this->flattenKeys = $flattenKeys;
	}

}
