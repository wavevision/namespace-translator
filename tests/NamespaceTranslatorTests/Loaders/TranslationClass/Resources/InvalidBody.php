<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Loaders\TranslationClass\Resources;

class InvalidBody
{

	/**
	 * @return array<mixed>
	 */
	public static function define(): array
	{
		$a = 'hello';
		return [$a => $a];
	}

}
