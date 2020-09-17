<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders;

use Nette\Neon\Neon as NetteNeon;
use Nette\SmartObject;
use Nette\Utils\FileSystem;
use Wavevision\NamespaceTranslator\Resources\LocalePrefixPair;

class Neon implements Loader
{

	use SmartObject;
	use InjectHelpers;

	public const FORMAT = 'neon';

	/**
	 * @inheritDoc
	 */
	public function load(string $resource): array
	{
		return NetteNeon::decode($this->helpers->readResourceContent($resource)) ?: [];
	}

	public function getLocalePrefixPair(string $resourceName): LocalePrefixPair
	{
		return $this->helpers->dotNotationLocalePrefixPair($resourceName);
	}

	public function fileSuffix(string $locale): string
	{
		return $locale . '.' . $this->getFileExtension();
	}

	/**
	 * @inheritDoc
	 */
	public function save(string $resource, array $content, ?string $referenceResource = null): void
	{
		FileSystem::write($resource, NetteNeon::encode($content, NetteNeon::BLOCK));
	}

	/**
	 * @inheritDoc
	 */
	public function loadExport(string $resource): array
	{
		return $this->load($resource);
	}

	/**
	 * @inheritDoc
	 */
	public function saveKeyValue($key, string $value, array &$content): void
	{
		$this->helpers->buildTree($key, $value, $content);
	}

	public function getFileExtension(): string
	{
		return 'neon';
	}

}
