<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Exceptions\SkipResource;
use Wavevision\Utils\Arrays;

/**
 * @DIService(generateInject=true)
 */
class LoadExport
{

	use SmartObject;
	use InjectGetTranslationArray;
	use InjectFlattenKeys;

	public function process(string $resource): array
	{
		return $this->flattenKeys->process($this->getTranslationArray->process($resource));
	}

}