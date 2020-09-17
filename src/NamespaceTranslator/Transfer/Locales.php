<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
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

	/**
	 * @return array<string>
	 */
	public function optionalLocales(): array
	{
		$whitelist = $this->translator->getLocalesWhitelist();
		if ($whitelist === null) {
			throw new InvalidState('Locale whitelist must be set.');
		}
		return Arrays::filter(
			$whitelist,
			fn(string $locale): bool => $locale !== $this->defaultLocale()
		);
	}

	/**
	 * @return array<string>
	 */
	public function allLocales(): array
	{
		return [$this->defaultLocale(), ...$this->optionalLocales()];
	}

}
