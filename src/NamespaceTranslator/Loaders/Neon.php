<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders;

use Nette\Neon\Neon as NetteNeon;
use Nette\SmartObject;
use Wavevision\NamespaceTranslator\DomainManager;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Resources\LocalePrefixPair;
use Wavevision\NamespaceTranslator\Resources\Messages;
use Wavevision\Utils\Arrays;

class Neon implements Loader
{

	use SmartObject;

	public const FORMAT = 'neon';

	public function load(string $resource, LocalePrefixPair $localePrefixPair): Messages
	{
		$content = @file_get_contents($resource);
		if ($content === false) {
			throw new InvalidState("Unable to read contents of '$resource'.");
		}
		$messages = NetteNeon::decode($content) ?: [];
		return new Messages($messages, $localePrefixPair->getLocale(), $localePrefixPair->getPrefix());
	}

	public function getLocalePrefixPair(string $resourceName): LocalePrefixPair
	{
		$parts = explode(DomainManager::DOMAIN_DELIMITER, $resourceName);
		return new LocalePrefixPair(Arrays::pop($parts), Arrays::pop($parts));
	}

}
