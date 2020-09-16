<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders;

use Nette\SmartObject;
use Wavevision\NamespaceTranslator\Exceptions\InvalidArgument;

class Manager
{

	use SmartObject;

	/**
	 * @var Loader[]
	 */
	private array $loaders = [];

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

	public function getFormatLoaderByExtension(string $extension): Loader
	{
		foreach ($this->getLoaders() as $loader) {
			if ($loader->getFileExtension() === $extension) {
				return $loader;
			}
		}
		throw new InvalidArgument("No loader for extension '$extension' exists.");
	}

	/**
	 * @return Loader[]
	 */
	public function getLoaders(): array
	{
		return $this->loaders;
	}

}
