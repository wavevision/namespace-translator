<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Import;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\DomainManager;
use Wavevision\NamespaceTranslator\Loaders\InjectManager;
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

	public function process(string $directory, FileSet $fileSet): array
	{
		$loader = $this->manager->getFormatLoader($fileSet->getFormat());
		$resources = [];
		foreach ($this->locales->allLocales() as $locale) {
			$resource = $directory . $fileSet->getFile() . $loader->fileSuffix($locale);
			$resourceContent = $this->resourceContent($fileSet, $locale);
			if (count($resourceContent) > 0) {
				$loader->save($resource, Arrays::mergeAllRecursive($loader->load($resource), $resourceContent));
			} else {
				if (is_file($resource)) {
					unlink($resource);
				}
			}
		}
		return $resources;
	}

	private function resourceContent(FileSet $fileSet, string $locale): array
	{
		$tree = [];
		foreach ($fileSet->getTranslations() as $key => $localizedValues) {
			if (isset($localizedValues[$locale])) {
				$value = trim($localizedValues[$locale]);
				if ($value !== '') {
					Arrays::buildTree(
						explode(DomainManager::DOMAIN_DELIMITER, $key),
						$value,
						$tree
					);
				}
			}
		}
		return $tree;
	}

}