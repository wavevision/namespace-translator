<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders;

use Nette\SmartObject;
use Wavevision\NamespaceTranslator\DomainManager;
use Wavevision\NamespaceTranslator\Exceptions\InvalidArgument;

class Manager
{

	use SmartObject;

	/**
	 * @var Loader[]
	 */
	private $loaders = [];

	public function addLoader(string $format, Loader $loader): self
	{
		$this->loaders[$format] = $loader;
		return $this;
	}

	public function getFormatLoader(string $format): Loader
	{
		if (isset($this->loaders[$format])) {
			return $this->loaders[$format];
		}
		throw new InvalidArgument("No loader for '$format' format exists.");
	}

	/**
	 * @return Loader[]
	 */
	public function getLoaders(): array
	{
		return $this->loaders;
	}

	public static function getLoaderResourceName(string $resource, string $format): string
	{
		$suffix = DomainManager::DOMAIN_DELIMITER . $format;
		return basename($resource, $suffix);
	}

}
