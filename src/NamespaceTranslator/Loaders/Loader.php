<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders;

use Wavevision\NamespaceTranslator\Resources\Messages;

interface Loader
{

	public function load(string $resource): Messages;

	/**
	 * @return array<string|null>
	 */
	public function getLocalePrefixPair(string $resource): array;

}
