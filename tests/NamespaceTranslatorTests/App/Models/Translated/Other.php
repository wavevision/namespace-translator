<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Models\Translated;

use Contributte\Translation\Wrappers\Message;
use Nette\SmartObject;
use Wavevision\NamespaceTranslator\NamespaceTranslator;
use Wavevision\NamespaceTranslatorTests\App\Models\Translated\Translations\OtherTranslation;

class Other
{

	use NamespaceTranslator;
	use SmartObject;

	public function processClassPrefixed(): string
	{
		return $this->translator
			->classPrefixed(self::class)
			->translate(new Message(OtherTranslation::MESSAGE));
	}

	public function processNestedPrefixed(): string
	{
		return $this->translator
			->classPrefixed(self::class)
			->translate([OtherTranslation::NESTED, OtherTranslation::MESSAGE]);
	}

	public function processPrefixed(): string
	{
		return $this->translator
			->prefixed('unknown')
			->translate('message');
	}

}
