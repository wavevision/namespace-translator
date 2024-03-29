<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Models\Translated;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\NamespaceTranslator;
use Wavevision\NamespaceTranslatorTests\App\Models\Translated\Translations\Cs;

/**
 * @DIService(generateInject=true)
 */
class Model
{

	use SmartObject;
	use NamespaceTranslator;

	public function process(): string
	{
		return $this->translator->translate(Cs::SOME_KEY);
	}

	public function processInteger(): string
	{
		return $this->translator->translate(1);
	}

	public function processNested(): string
	{
		return $this->translator->translate([Cs::SUB, Cs::NESTED]);
	}

}
