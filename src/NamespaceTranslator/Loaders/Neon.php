<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders;

use Nette\Neon\Neon as NetteNeon;
use Nette\SmartObject;
use Wavevision\NamespaceTranslator\DomainManager;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Resources\Messages;

class Neon implements Loader
{

	use SmartObject;

	public const FORMAT = 'neon';

	/**
	 * @inheritDoc
	 */
	public function load(string $resource): Messages
	{
		[$locale, $prefix] = $this->getLocalePrefixPair($resource);
		if (!$locale) {
			throw new InvalidState("Unable to detect locale for '$resource'.");
		}
		$content = @file_get_contents($resource);
		if ($content === false) {
			throw new InvalidState("Unable to read contents of '$resource'.");
		}
		$messages = NetteNeon::decode($content) ?: [];
		return new Messages($messages, $locale, $prefix);
	}

	/**
	 * @inheritDoc
	 */
	public function getLocalePrefixPair(string $resource): array
	{
		$parts = explode(
			DomainManager::DOMAIN_DELIMITER,
			Manager::getLoaderResourceName($resource, self::FORMAT)
		);
		return [array_pop($parts), array_pop($parts)];
	}

}
