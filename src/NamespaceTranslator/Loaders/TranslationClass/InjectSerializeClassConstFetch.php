<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

trait InjectSerializeClassConstFetch
{

	protected SerializeClassConstFetch $serializeClassConstFetch;

	public function injectSerializeClassConstFetch(SerializeClassConstFetch $serializeClassConstFetch): void
	{
		$this->serializeClassConstFetch = $serializeClassConstFetch;
	}

}
