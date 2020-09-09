<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Nette\StaticClass;

class Helpers
{

	use StaticClass;

	/**
	 * @param string [] $keys
	 */
	public static function key(array $keys): string
	{
		return implode(DomainManager::DOMAIN_DELIMITER, $keys);
	}

}
