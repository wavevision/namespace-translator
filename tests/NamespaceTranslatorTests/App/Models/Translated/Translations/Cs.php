<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Models\Translated\Translations;

use Nette\StaticClass;
use Wavevision\NamespaceTranslator\Resources\Translation;

class Cs implements Translation
{

	use StaticClass;

	public const SOME_KEY = 'someKey';

	public const SUB = 'sub';

	public const NESTED = 'nested';

	/**
	 * @inheritDoc
	 */
	public static function define(): array
	{
		return [
			self::SOME_KEY => 'My chceme modele!',
			self::SUB => [
				self::NESTED => 'Nested',
			],
		];
	}

}
