<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Contributte\Translation\Translator;
use Nette\SmartObject;
use Nette\Utils\Finder;
use ReflectionClass;
use SplFileInfo;
use Symfony\Component\Translation\MessageCatalogue;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Loaders\InjectManager;
use Wavevision\NamespaceTranslator\Loaders\Loader;
use Wavevision\Utils\Arrays;
use Wavevision\Utils\Path;

/**
 * @DIService(name="resourceManager")
 */
class ResourceManager
{

	use SmartObject;
	use InjectManager;

	private ResourceLoader $loader;

	/**
	 * @var string[]
	 */
	private array $namespaces = [];

	private ParametersManager $pm;

	/**
	 * @var MessageCatalogue[]
	 */
	private array $resources = [];

	private Translator $translator;

	public function __construct(ResourceLoader $loader, ParametersManager $pm, Translator $translator)
	{
		$this->loader = $loader;
		$this->pm = $pm;
		$this->translator = $translator;
	}

	/**
	 * @return Finder<SplFileInfo>|null
	 */
	public function findResources(string $className): ?iterable
	{
		if (!class_exists($className)) {
			throw new InvalidState("'$className' is not a valid class.");
		}
		$file = (string)(new ReflectionClass($className))->getFileName();
		$dirs = $this->getDirs($file);
		if (!Arrays::isEmpty($dirs)) {
			return Finder::findFiles(...$this->getMasks())->in(...$dirs);
		}
		return null;
	}

	public function loadResource(string $resource, string $domain): MessageCatalogue
	{
		if (!isset($this->resources[$resource])) {
			$catalogue = $this->loader->load($resource, $domain);
			$this->translator
				->getCatalogue($catalogue->getLocale())
				->addCatalogue($catalogue);
			$this->setFallback($catalogue);
			$this->resources[$resource] = $catalogue;
		}
		return $this->resources[$resource];
	}

	public function getNamespaceLoaded(string $namespace): bool
	{
		return in_array($namespace, $this->namespaces);
	}

	public function setNamespaceLoaded(string $namespace): void
	{
		$this->namespaces[] = $namespace;
	}

	/**
	 * @return string[]
	 */
	private function getDirs(string $file): array
	{
		return array_filter(
			Arrays::map(
				$this->pm->getDirNames(),
				function (string $dir) use ($file): string {
					return Path::join(dirname($file), $dir);
				}
			),
			'is_dir'
		);
	}

	/**
	 * @return string[]
	 */
	private function getMasks(): array
	{
		return array_values(
			Arrays::map($this->manager->getLoaders(), fn(Loader $loader): string => "*." . $loader->getFileExtension())
		);
	}

	private function setFallback(MessageCatalogue $catalogue): void
	{
		foreach ($this->translator->getFallbackLocales() as $fallbackLocale) {
			if ($catalogue->getLocale() !== $fallbackLocale) {
				$this->translator
					->getCatalogue($catalogue->getLocale())
					->addFallbackCatalogue($this->translator->getCatalogue($fallbackLocale));
			}
		}
	}

}
