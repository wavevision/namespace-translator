<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Models\Translated\Translations;

use Wavevision\NamespaceTranslator\Resources\Translation;

class Cs extends Translation
{

	public const SOME_KEY = 'someKey';

	/**
	 * @inheritDoc
	 */
	public static function define(): array
	{
		return [
			self::SOME_KEY => 'My chceme modele!',
		];
	}

}
