<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export;

use Nette\SmartObject;
use Nette\Utils\FileSystem;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\InjectParametersManager;
use Wavevision\NamespaceTranslator\Loaders\InjectManager;
use Wavevision\NamespaceTranslator\Loaders\Neon;
use Wavevision\NamespaceTranslator\Transfer\InjectLocales;
use Wavevision\Utils\Arrays;

/**
 * @DIService(generateInject=true)
 */
class ExportTranslations
{

	use SmartObject;
	use InjectParametersManager;
	use InjectLocales;
	use InjectFileSetFactory;
	use InjectManager;

	public function neon(string $directory): array
	{
		return $this->fileSetFactory->create(
			$directory,
			$this->manager->getFormatLoader(Neon::FORMAT)
		);
	}

	private function loadFlatten(string $pathname): array
	{
		if (is_file($pathname)) {
			return Arrays::flattenKeys(Neon::decode(FileSystem::read($pathname)));
		}
		return [];
	}

}
