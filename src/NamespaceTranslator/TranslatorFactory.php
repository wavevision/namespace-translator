<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Nette\SmartObject;
use SplFileInfo;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Exceptions\SkipResource;

/**
 * @DIService(name="translatorFactory")
 */
class TranslatorFactory
{

	use InjectContributteTranslator;
	use InjectDomainManager;
	use InjectResourceManager;
	use SmartObject;

	/**
	 * @var Translator[]
	 */
	private array $translators = [];

	public function create(string $namespace): Translator
	{
		$domain = $this->domainManager->getDomain($namespace);
		$translator = $this->translators[$domain] ?? (new Translator())
				->injectContributteTranslator($this->contributteTranslator);
		if (!$this->resourceManager->getNamespaceLoaded($namespace)) {
			if ($resources = $this->resourceManager->findResources($namespace)) {
				/** @var SplFileInfo $resource */
				foreach ($resources as $resource) {
					try {
						$this->resourceManager->loadResource($resource->getPathname(), $domain);
					} catch (SkipResource $e) {
					}
				}
				$this->resourceManager->setNamespaceLoaded($namespace);
				$this->translators[$domain] = $translator->setDomain($domain);
			}
		}
		return $translator;
	}

}
