<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Nette\SmartObject;

class ParametersManager
{

	use SmartObject;

	/**
	 * @var string[]
	 */
	private $exclude;

	/**
	 * @var string
	 */
	private $exportDir;

	/**
	 * @var string[]
	 */
	private $rootDirs;

	/**
	 * @var string
	 */
	private $rootNamespace;

	/**
	 * @param string[] $exclude
	 * @param string $exportDir
	 * @param string[] $rootDirs
	 * @param string $rootNamespace
	 */
	public function __construct(array $exclude, string $exportDir, array $rootDirs, string $rootNamespace)
	{
		$this->exclude = $exclude;
		$this->exportDir = $exportDir;
		$this->rootDirs = $rootDirs;
		$this->rootNamespace = $rootNamespace;
	}

	/**
	 * @return string[]
	 */
	public function getExclude(): array
	{
		return $this->exclude;
	}

	public function getExportDir(): string
	{
		return $this->exportDir;
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

}
