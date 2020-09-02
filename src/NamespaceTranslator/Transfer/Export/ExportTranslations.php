<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export;

use Nette\Neon\Neon;
use Nette\SmartObject;
use Nette\Utils\FileSystem;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\InjectParametersManager;
use Wavevision\Utils\Arrays;
use Wavevision\Utils\Finder;

/**
 * @DIService(generateInject=true)
 */
class ExportTranslations
{

	use SmartObject;
	use InjectParametersManager;

	/**
	 * @return array<mixed>
	 */
	public function process(string $directory): array
	{
		$translations = [];
		foreach ($this->findDirectories($directory) as $resource) {
			$translationDirectory = $resource->getPathname();
			/** @var \SplFileInfo $file */
			foreach (Finder::findFiles('*cs.neon')->in($translationDirectory) as $file) {
				$pathname = $file->getPathname();
				$basePathname = str_replace('cs.neon', '', $pathname);
				$translations[] = new FileSet(
					$this->fileSet($basePathname), str_replace($directory, '', $basePathname)
				);
			}
		}
		return $translations;
	}

	private function fileSet(string $basePathname): array
	{
		$keys = [];
		foreach ($this->getLocales() as $locale) {
			$fileContent = $this->loadFlatten($basePathname . $locale . '.neon');
			foreach ($fileContent as $key => $value) {
				$keys[$key][$locale] = $value;
			}
		}
		return $keys;
	}

	private function loadFlatten(string $pathname): array
	{
		if (is_file($pathname)) {
			return Arrays::flattenKeys(Neon::decode(FileSystem::read($pathname)));
		}
		return [];
	}

	private function getDefaultLocale(): string
	{
		return 'cs';
	}

	private function getOptionalLocales(): array
	{
		return ['en'];
	}

	private function getLocales(): array
	{
		return [$this->getDefaultLocale(), ...$this->getOptionalLocales()];
	}

	/**
	 * @return \SplFileInfo[]
	 */
	private function findDirectories(string $directory): Finder
	{
		return Finder::findDirectories(...$this->parametersManager->getDirNames())
			->from($directory);
	}

}
