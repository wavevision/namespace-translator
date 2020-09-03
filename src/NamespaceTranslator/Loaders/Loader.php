<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders;

use Wavevision\NamespaceTranslator\Resources\LocalePrefixPair;

interface Loader
{

	/**
	 * @return array<mixed>
	 */
	public function load(string $resource): array;

	public function getLocalePrefixPair(string $resourceName): LocalePrefixPair;

	public function fileSuffix(string $locale): string;

}
