<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders;

trait InjectManager
{

	private Manager $manager;

	/**
	 * @return static
	 */
	public function injectManager(Manager $manager)
	{
		$this->manager = $manager;
		return $this;
	}

}
