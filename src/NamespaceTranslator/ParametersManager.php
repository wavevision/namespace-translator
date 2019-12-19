<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Nette\SmartObject;

class ParametersManager
{

	use SmartObject;

	/**
	 * @var string[]
	 */
	private array $exclude;

	/**
	 * @var mixed[]
	 */
	private array $loaders;

	/**
	 * @var string[]
	 */
	private array $rootDirs;

	private string  $rootNamespace;

	/**
	 * @var string[]
	 */
	private array $translationDirNames;

	/**
	 * @param string[] $exclude
	 * @param mixed[] $loaders
	 * @param string[] $rootDirs
	 * @param string[] $translationDirNames
	 */
	public function __construct(
		array $exclude,
		array $loaders,
		array $rootDirs,
		string $rootNamespace,
		array $translationDirNames
	) {
		$this->exclude = $exclude;
		$this->loaders = $loaders;
		$this->rootDirs = $rootDirs;
		$this->rootNamespace = $rootNamespace;
		$this->translationDirNames = $translationDirNames;
	}

	/**
	 * @return string[]
	 */
	public function getExclude(): array
	{
		return $this->exclude;
	}

	/**
	 * @return string[]
	 */
	public function getFormats(): array
	{
		return array_keys($this->loaders);
	}

	/**
	 * @return mixed[]
	 */
	public function getLoaders(): array
	{
		return $this->loaders;
	}

	/**
	 * @return string[]
	 */
	public function getRootDirs(): array
	{
		return $this->rootDirs;
	}

	public function getRootNamespace(): string
	{
		return $this->rootNamespace;
	}

	/**
	 * @return string[]
	 */
	public function getTranslationDirNames(): array
	{
		return $this->translationDirNames;
	}

}
