<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Models\Translated\Translations;

use Nette\SmartObject;

class PrefixedCs extends Translation
{

	public static function define(): array
	{
		return [
			'book' => 'The Tale of Scrotie McBoogerballs'
		];
	}

}