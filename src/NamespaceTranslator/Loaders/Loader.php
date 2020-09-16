<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders;

use Wavevision\NamespaceTranslator\Resources\LocalePrefixPair;

interface Loader
{

	/**
	 * @return array<mixed>
	 */
	public function load(string $resource): array;

	/**
	 * @return array<mixed>
	 */
	public function loadExport(string $resource): array;

	public function getLocalePrefixPair(string $resourceName): LocalePrefixPair;

	public function fileSuffix(string $locale): string;

	/**
	 * @param array<mixed> $content
	 */
	public function save(string $resource, array $content, ?string $referenceResource = null): void;

	/**
	 * @param int|string $key
	 * @param array<mixed> $content
	 */
	public function saveKeyValue($key, string $value, array &$content): void;

}
