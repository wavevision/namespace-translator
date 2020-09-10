<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\StaticClass;
use Wavevision\Utils\Arrays;

class Message
{

	use StaticClass;

	public static function create(string $value, string ...$params): string
	{
		//escape %%
		return sprintf($value, ...Arrays::map($params, fn(string $p) => "%$p%"));
	}

}
