<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\InjectTranslator;
use Wavevision\Utils\Arrays;

/**
 * @DIService(generateInject=true)
 */
class Locales
{

	use SmartObject;
	use InjectTranslator;

	public function defaultLocale(): string
	{
		return $this->translator->getDefaultLocale();
	}

	public function optionalLocales(): array
	{
		return Arrays::filter(
			$this->translator->getLocalesWhitelist(),
			fn(string $locale): bool => $locale !== $this->defaultLocale()
		);
	}

	public function allLocales(): array
	{
		return [$this->defaultLocale(), ...$this->optionalLocales()];
	}

}
