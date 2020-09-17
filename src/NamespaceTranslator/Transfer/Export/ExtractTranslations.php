<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Loaders\InjectManager;

/**
 * @DIService(generateInject=true)
 */
class ExtractTranslations
{

	use SmartObject;
	use InjectFileSetFactory;
	use InjectManager;

	public function process(string $directory): Translations
	{
		$translations = new Translations();
		foreach ($this->manager->getLoaders() as $format => $loader) {
			$translations->combine(
				$this->fileSetFactory->create(
					$directory,
					$loader,
					$format
				)
			);
		}
		return $translations;
	}

}
