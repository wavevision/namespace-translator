<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;

/**
 * @DIService(generateInject=true, name="parametersManager", params={"%dirNames%"})
 */
class ParametersManager
{

	use SmartObject;

	/**
	 * @var string[]
	 */
	private array $dirNames;

	/**
	 * @param string[] $dirNames
	 */
	public function __construct(array $dirNames)
	{
		$this->dirNames = $dirNames;
	}

	/**
	 * @return string[]
	 */
	public function getDirNames(): array
	{
		return $this->dirNames;
	}

}
