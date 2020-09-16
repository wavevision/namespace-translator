<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders;

trait InjectHelpers
{

	protected Helpers $helpers;

	public function injectHelpers(Helpers $helpers): void
	{
		$this->helpers = $helpers;
	}

}
