<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

trait InjectSerializeMessage
{

	protected SerializeMessage $serializeMessage;

	public function injectSerializeMessage(SerializeMessage $serializeMessage): void
	{
		$this->serializeMessage = $serializeMessage;
	}

}
