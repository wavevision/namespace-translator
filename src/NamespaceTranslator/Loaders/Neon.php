<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders;

use Nette\Neon\Neon as NetteNeon;
use Nette\SmartObject;
use Nette\Utils\FileSystem;
use Wavevision\NamespaceTranslator\DomainManager;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Resources\LocalePrefixPair;
use Wavevision\Utils\Arrays;

class Neon implements Loader
{

	use SmartObject;

	public const FORMAT = 'neon';

	/**
	 * @return array<mixed>
	 */
	public function load(string $resource): array
	{
		$content = @file_get_contents($resource);
		if ($content === false) {
			throw new InvalidState("Unable to read contents of '$resource'.");
		}
		return NetteNeon::decode($content) ?: [];
	}

	public function getLocalePrefixPair(string $resourceName): LocalePrefixPair
	{
		$parts = explode(DomainManager::DOMAIN_DELIMITER, $resourceName);
		return new LocalePrefixPair(Arrays::pop($parts), Arrays::pop($parts));
	}

	public function fileSuffix(string $locale): string
	{
		return $locale . '.neon';
	}

	public function save(string $resource, array $content, ?string $referenceResource = null): void
	{
		FileSystem::write($resource, NetteNeon::encode($content, NetteNeon::BLOCK));
	}

	public function loadExport(string $resource): array
	{
		return $this->load($resource);
	}

}
