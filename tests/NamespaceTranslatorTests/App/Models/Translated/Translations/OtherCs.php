<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Models\Translated\Translations;

class OtherCs extends OtherTranslation
{

	/**
	 * @return mixed[]
	 */
	public static function define(): array
	{
		return [
			self::MESSAGE => 'This message is prefixed.',
			self::NESTED => [
				self::MESSAGE => 'This nested message is also prefixed.',
			],
		];
	}

}
