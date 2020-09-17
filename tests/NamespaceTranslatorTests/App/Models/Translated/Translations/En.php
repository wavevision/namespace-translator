<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Models\Translated\Translations;

class En extends Translation
{

	/**
	 * @inheritDoc
	 */
	public static function define(): array
	{
		return [
			1 => 'One!',
			self::SOME_KEY => 'We want modele!',
		];
	}

}
