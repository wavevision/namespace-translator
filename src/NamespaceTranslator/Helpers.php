<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Nette\StaticClass;

class Helpers
{

	use StaticClass;

	/**
	 * @param mixed $message
	 */
	public static function filter($message): string
	{
		return (string)$message;
	}

	/**
	 * @param int[]|string[] $keys
	 */
	public static function key(array $keys): string
	{
		return implode(DomainManager::DOMAIN_DELIMITER, $keys);
	}

}
