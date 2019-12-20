<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders;

use Wavevision\NamespaceTranslator\Resources\LocalePrefixPair;
use Wavevision\NamespaceTranslator\Resources\Messages;

interface Loader
{

	public function load(string $resource, LocalePrefixPair $localePrefixPair): Messages;

	public function getLocalePrefixPair(string $resourceName): LocalePrefixPair;

}
