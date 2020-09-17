<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Models\Translated\Translations;

class PrefixedCs extends Translation
{

	/**
	 * @return array<mixed>
	 */
	public static function define(): array
	{
		return [
			'test' => '123',
			'one' => [
				'two' => [
					'nested' => 'nested',
				],
				'one' => 'asd',
			],
			self::BOOK => 'The Tale of Scrotie McBoogerballs',
		];
	}

}
