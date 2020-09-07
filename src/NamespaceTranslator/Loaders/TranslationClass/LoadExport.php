<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;

/**
 * @DIService(generateInject=true)
 */
class LoadExport
{

	use SmartObject;
	use InjectGetTranslationArray;
	use InjectFlattenKeys;

	/**
	 * @return array<mixed>
	 */
	public function process(string $resource): array
	{
		return $this->flattenKeys->process($this->getTranslationArray->process($resource));
	}

}
