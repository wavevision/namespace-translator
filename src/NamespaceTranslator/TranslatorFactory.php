<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Contributte\Translation\Translator as ContributteTranslator;
use Nette\SmartObject;
use SplFileInfo;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Exceptions\SkipResource;

/**
 * @DIService(name="translatorFactory")
 */
class TranslatorFactory
{

	use SmartObject;

	private DomainManager $domainManager;

	private ResourceManager $resourceManager;

	private ContributteTranslator $translator;

	/**
	 * @var Translator[]
	 */
	private array $translators = [];

	public function __construct(
		DomainManager $domainManager,
		ResourceManager $resourceManager,
		ContributteTranslator $translator
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
