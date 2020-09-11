<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Loaders\TranslationClass\Resources;

class InvalidReturn
{

	public static function define(): string
	{
		return '';
	}

}
