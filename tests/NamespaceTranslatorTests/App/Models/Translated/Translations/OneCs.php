<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Models\Translated\Translations;

use Wavevision\NamespaceTranslator\Loaders\TranslationClass\Message;

class OneCs extends Translation
{

	/**
	 * @inheritDoc
	 */
	public static function define(): array
	{
		return [
			self::HELLO => Message::create('Ahoj %s!', self::NAME),
		];
	}

}
