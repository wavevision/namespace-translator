<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Import;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\DomainManager;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Exceptions\MissingResource;
use Wavevision\NamespaceTranslator\Exceptions\SkipResource;
use Wavevision\NamespaceTranslator\Loaders\InjectManager;
use Wavevision\NamespaceTranslator\Loaders\Loader;
use Wavevision\NamespaceTranslator\Transfer\Export\FileSet;
use Wavevision\NamespaceTranslator\Transfer\InjectLocales;
use Wavevision\Utils\Arrays;

/**
 * @DIService(generateInject=true)
 */
class SaveFileSet
{

	use SmartObject;
	use InjectManager;
	use InjectLocales;

	/**
	 * @return array<mixed>
	 */
	public function process(string $directory, FileSet $fileSet): array
	{
		$loader = $this->manager->getFormatLoader($fileSet->getFormat());
		$resources = [];
		$defaultLocale = $this->locales->defaultLocale();
		$referenceResource = $this->saveLocale($directory, $fileSet, $defaultLocale, $loader);
		foreach ($this->locales->optionalLocales() as $locale) {
			$this->saveLocale($directory, $fileSet, $locale, $loader, $referenceResource);
		}
		return $resources;
	}

	private function saveLocale(
		string $directory,
		FileSet $fileSet,
		string $locale,
		Loader $loader,
		?string $reference = null
	): string {
		$resource = $directory . $fileSet->getFile() . $loader->fileSuffix($locale);
		$resourceContent = $this->resourceContent($fileSet, $locale);
		if (count($resourceContent) > 0) {
			$loader->save(
				$resource,
				Arrays::mergeAllRecursive($this->load($loader, $resource), $resourceContent),
				$reference
			);
		} else {
			if ($reference === null) {
				throw new InvalidState('Unable to remove default locale.');
			}
			if (is_file($resource)) {
				unlink($resource);
			}
		}
		return $resource;
	}

	/**
	 * @return array<mixed>
	 */
	private function load(Loader $loader, string $resource): array
	{
		try {
			return $loader->loadExport($resource);
		} catch (SkipResource | MissingResource $e) {
			return [];
		}
	}

	/**
	 * @return array<mixed>
	 */
	private function resourceContent(FileSet $fileSet, string $locale): array
	{
		$tree = [];
		foreach ($fileSet->getTranslations() as $key => $localizedValues) {
			if (isset($localizedValues[$locale])) {
				$value = trim($localizedValues[$locale]);
				if ($value !== '') {
					Arrays::buildTree(
						$this->explode($key),
						$value,
						$tree
					);
				}
			}
		}
		return $tree;
	}

	private function explode($key): array
	{
		return Arrays::map(
			explode(DomainManager::DOMAIN_DELIMITER, (string)$key),
			fn(string $part) => $this->part($part)
		);
	}

	/**
	 * @return int|string
	 */
	private function part(string $value)
	{
		$result = filter_var($value, FILTER_VALIDATE_INT);
		return $result === false ? $value : $result;
	}

}
