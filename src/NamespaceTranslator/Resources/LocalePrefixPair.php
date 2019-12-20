<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Resources;

use Nette\SmartObject;
use Wavevision\Utils\Strings;

final class LocalePrefixPair
{

	use SmartObject;

	private string $locale;

	private ?string $prefix;

	public function __construct(string $locale, ?string $prefix = null)
	{
		$this->locale = Strings::lower($locale);
		$this->prefix = $prefix ? Strings::firstLower($prefix) : null;
	}

	public function getLocale(): string
	{
		return $this->locale;
	}

	public function getPrefix(): ?string
	{
		return $this->prefix;
	}

}
