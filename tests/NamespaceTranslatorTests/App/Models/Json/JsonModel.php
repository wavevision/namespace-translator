<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Models\Json;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\NamespaceTranslator;

/**
 * @DIService(generateInject=true)
 */
class JsonModel
{

	use SmartObject;
	use NamespaceTranslator;

	public function nonPrefix(): string
	{
		return $this->translator->translate('jsonMessage');
	}

	public function nested(): string
	{
		return $this->translator->translate('nested1.nested2');
	}

}
