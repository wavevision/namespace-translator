<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders;

use Nette\SmartObject;
use Nette\Utils\FileSystem;
use Nette\Utils\Json as NetteJson;
use Wavevision\NamespaceTranslator\Resources\LocalePrefixPair;
use Wavevision\Utils\Json as WavevisionJson;

class FlatJson implements Loader
{

	use SmartObject;
	use InjectHelpers;

	public const FORMAT = 'flatJson';

	/**
	 * @inheritDoc
	 */
	public function load(string $resource): array
	{
		return NetteJson::decode($this->helpers->readResourceContent($resource), NetteJson::FORCE_ARRAY) ?: [];
	}

	/**
	 * @inheritDoc
	 */
	public function loadExport(string $resource): array
	{
		return $this->load($resource);
	}

	public function getLocalePrefixPair(string $resourceName): LocalePrefixPair
	{
		return $this->helpers->dotNotationLocalePrefixPair($resourceName);
	}

	public function fileSuffix(string $locale): string
	{
		return $locale . '.' . $this->getFileExtension();
	}

	public function getFileExtension(): string
	{
		return 'json';
	}

	/**
	 * @inheritDoc
	 */
	public function save(string $resource, array $content, ?string $referenceResource = null): void
	{
		/** @var string $encodedJson */
		$encodedJson = WavevisionJson::encodePretty($content, WavevisionJson::INDENT_JS);
		FileSystem::write($resource, $encodedJson);
	}

	/**
	 * @inheritDoc
	 */
	public function saveKeyValue($key, string $value, array &$content): void
	{
		$content[$key] = $value;
	}

}
