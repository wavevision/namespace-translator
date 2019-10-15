<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Kdyby\Translation\Translator as KdybyTranslator;
use Nette\SmartObject;
use SplFileInfo;

class TranslatorFactory
{

	use SmartObject;

	/**
	 * @var DomainManager
	 */
	private $domainManager;

	/**
	 * @var ResourceManager
	 */
	private $resourceManager;

	/**
	 * @var KdybyTranslator
	 */
	private $translator;

	/**
	 * @var Translator[]
	 */
	private $translators = [];

	public function __construct(
		DomainManager $domainManager,
		ResourceManager $resourceManager,
		KdybyTranslator $translator
	) {
		$this->domainManager = $domainManager;
		$this->translator = $translator;
		$this->resourceManager = $resourceManager;
	}

	public function create(string $namespace): Translator
	{
		$domain = $this->domainManager->getDomain($namespace);
		$translator = $this->translators[$domain] ?? new Translator($this->translator);
		if (!$this->resourceManager->getNamespaceLoaded($namespace)) {
			if ($resources = $this->resourceManager->findResources($namespace)) {
				/** @var SplFileInfo $resource */
				foreach ($resources as $resource) {
					$this->resourceManager->loadResource($resource->getPathname(), $domain);
				}
				$this->resourceManager->setNamespaceLoaded($namespace);
				$this->translators[$domain] = $translator->setDomain($domain);
			}
		}
		return $translator;
	}

}
