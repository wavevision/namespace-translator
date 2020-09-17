<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator;

trait InjectParametersManager
{

	protected ParametersManager $parametersManager;

	public function injectParametersManager(ParametersManager $parametersManager): void
	{
		$this->parametersManager = $parametersManager;
	}

}
