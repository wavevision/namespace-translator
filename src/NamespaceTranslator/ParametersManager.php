<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;

/**
 * @DIService(name="parametersManager", params={"%dirNames%", "%loaders%"})
 */
class ParametersManager
{

	use SmartObject;

	/**
	 * @var string[]
	 */
	private array $dirNames;

	/**
	 * @var string[]
	 */
	private array $loaders;

	/**
	 * @param string[] $dirNames
	 * @param string[] $loaders
	 */
	public function __construct(
		array $dirNames,
		array $loaders
	) {
		$this->dirNames = $dirNames;
		$this->loaders = $loaders;
	}

	/**
	 * @return string[]
	 */
	public function getDirNames(): array
	{
		return $this->dirNames;
	}

	/**
	 * @return string[]
	 */
	public function getFormats(): array
	{
		return array_keys($this->loaders);
	}

	/**
	 * @return string[]
	 */
	public function getLoaders(): array
	{
		return $this->loaders;
	}

}
