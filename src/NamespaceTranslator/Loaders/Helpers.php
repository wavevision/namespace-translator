<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\DomainManager;
use Wavevision\NamespaceTranslator\Exceptions\MissingResource;
use Wavevision\NamespaceTranslator\Resources\LocalePrefixPair;
use Wavevision\Utils\Arrays;

/**
 * @DIService(generateInject=true)
 */
class Helpers
{

	use SmartObject;

	public function readResourceContent(string $resource): string
	{
		$content = @file_get_contents($resource);
		if ($content === false) {
			throw new MissingResource("Unable to read contents of '$resource'.");
		}
		return $content;
	}

	public function dotNotationLocalePrefixPair(string $resourceName): LocalePrefixPair
	{
		$parts = explode(DomainManager::DOMAIN_DELIMITER, $resourceName);
		return new LocalePrefixPair(Arrays::pop($parts), Arrays::pop($parts));
	}

}
