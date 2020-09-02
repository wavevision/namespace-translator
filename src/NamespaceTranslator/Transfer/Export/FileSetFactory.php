<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export;

use Nette\SmartObject;
use SplFileInfo;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\InjectParametersManager;
use Wavevision\NamespaceTranslator\Loaders\Loader;
use Wavevision\NamespaceTranslator\Transfer\InjectLocales;
use Wavevision\Utils\Finder;

/**
 * @DIService(generateInject=true)
 */
class FileSetFactory
{

	use SmartObject;
	use InjectLocales;
	use InjectParametersManager;

	public function create(string $directory, Loader $loader)
	{
		$translations = [];
		$suffix = $loader->suffix($this->locales->defaultLocale());
		foreach ($this->findDirectories($directory) as $resource) {
			$translationDirectory = $resource->getPathname();
			/** @var SplFileInfo $file */
			foreach (Finder::findFiles('*' . $suffix)->in($translationDirectory) as $file) {
				$pathname = $file->getPathname();
				//todo replace rtrim
				$basePathname = str_replace($suffix, '', $pathname);
				$translations[] = new FileSet(
					$this->fileSet($basePathname, $loader),
					str_replace($directory, '', $basePathname)
				);
			}
		}
		return $translations;
	}

	private function fileSet(string $basePathname, Loader $loader): array
	{
		$keys = [];
		foreach ($this->locales->allLocales() as $locale) {
			$fileContent = $loader->loadFlatten($basePathname . $loader->suffix($locale));
			foreach ($fileContent as $key => $value) {
				$keys[$key][$locale] = $value;
			}
		}
		return $keys;
	}

	/**
	 * @return SplFileInfo[]
	 */
	private function findDirectories(string $directory): Finder
	{
		return Finder::findDirectories(...$this->parametersManager->getDirNames())
			->from($directory);
	}

}
