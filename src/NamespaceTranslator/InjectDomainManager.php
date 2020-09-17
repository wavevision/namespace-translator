<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator;

trait InjectDomainManager
{

	protected DomainManager $domainManager;

	public function injectDomainManager(DomainManager $domainManager): void
	{
		$this->domainManager = $domainManager;
	}

}
