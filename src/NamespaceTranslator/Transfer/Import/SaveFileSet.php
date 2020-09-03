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

	public function process(string $directory, FileSet $fileSet): void
	{
		$loader = $this->manager->getFormatLoader($fileSet->getFormat());
		foreach ($this->locales->allLocales() as $locale) {
			$resource = $directory . $fileSet->getFile() . $loader->fileSuffix($locale);
			var_dump($resource);
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
			if (count($tree) > 0) {
				var_dump($tree);
			}
		}
	}

}