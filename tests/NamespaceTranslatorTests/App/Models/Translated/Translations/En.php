<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Models\Translated\Translations;

use Nette\StaticClass;
use Wavevision\NamespaceTranslator\Resources\Translation;

class En implements Translation
{

	use StaticClass;

	/**
	 * @inheritDoc
	 */
	public static function define(): array
	{
		return [
			Cs::SOME_KEY => 'We want modele!',
		];
	}

}
