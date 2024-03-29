<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export;

use Nette\SmartObject;
use SplFileInfo;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Exceptions\MissingResource;
use Wavevision\NamespaceTranslator\Exceptions\SkipResource;
use Wavevision\NamespaceTranslator\InjectParametersManager;
use Wavevision\NamespaceTranslator\Loaders\Loader;
use Wavevision\NamespaceTranslator\Transfer\InjectLocales;
use Wavevision\Utils\Arrays;
use Wavevision\Utils\Finder;
use function str_replace;
use function strlen;
use function substr_replace;

/**
 * @DIService(generateInject=true)
 */
class FileSetFactory
{

	use SmartObject;
	use InjectLocales;
	use InjectParametersManager;

	public function create(string $directory, Loader $loader, string $format): Translations
	{
		$translations = new Translations();
		$suffix = $loader->fileSuffix($this->locales->defaultLocale());
		/** @var SplFileInfo $resource */
		foreach ($this->findDirectories($directory) as $resource) {
			$translationDirectory = $resource->getPathname();
			/** @var SplFileInfo $file */
			foreach (Finder::findFiles('*' . $suffix)->in($translationDirectory) as $file) {
				$pathname = $file->getPathname();
				$basePathname = substr_replace($pathname, '', -strlen($suffix));
				$translations->add(
					new FileSet(
						$this->fileSet($basePathname, $loader),
						str_replace($directory, '', $basePathname),
						$format
					)
				);
			}
		}
		return $translations;
	}

	/**
	 * @return array<mixed>
	 */
	private function fileSet(string $basePathname, Loader $loader): array
	{
		$keys = [];
		foreach ($this->locales->allLocales() as $locale) {
			try {
				$keyValueContent = Arrays::flattenKeys(
					$loader->loadExport($basePathname . $loader->fileSuffix($locale))
				);
				foreach ($keyValueContent as $key => $value) {
					$keys[$key][$locale] = $value;
				}
			} catch (SkipResource | MissingResource $e) {
			}
		}
		return $keys;
	}

	private function findDirectories(string $directory): Finder
	{
		return Finder::findDirectories(...$this->parametersManager->getDirNames())
			->from($directory);
	}

}
