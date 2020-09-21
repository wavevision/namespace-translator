<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Nette\SmartObject;
use Nette\Utils\Finder;
use ReflectionClass;
use SplFileInfo;
use Symfony\Component\Translation\MessageCatalogue;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Loaders\InjectManager;
use Wavevision\NamespaceTranslator\Loaders\Loader;
use Wavevision\NamespaceTranslator\Transfer\InjectLocales;
use Wavevision\Utils\Arrays;
use Wavevision\Utils\Path;

/**
 * @DIService(name="resourceManager", generateInject=true)
 */
class ResourceManager
{

	use InjectContributteTranslator;
	use InjectLocales;
	use InjectManager;
	use InjectParametersManager;
	use InjectResourceLoader;
	use SmartObject;

	/**
	 * @var string[]
	 */
	private array $namespaces = [];

	/**
	 * @var MessageCatalogue[]
	 */
	private array $resources = [];

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
			$catalogue = $this->resourceLoader->load($resource, $domain);
			$this->contributteTranslator
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
				$this->parametersManager->getDirNames(),
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
		$fallbackLocales = $this->contributteTranslator->getFallbackLocales();
		if (in_array($catalogue->getLocale(), $fallbackLocales)) {
			foreach ($this->locales->locales() as $locale) {
				foreach ($fallbackLocales as $fallbackLocale) {
					if ($fallbackLocale !== $locale) {
						$this->contributteTranslator
							->getCatalogue($locale)
							->addFallbackCatalogue($this->contributteTranslator->getCatalogue($fallbackLocale));
					}
				}
			}
		}
	}

}
