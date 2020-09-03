<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export\Writters;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Transfer\Export\FileSet;
use Wavevision\NamespaceTranslator\Transfer\Export\Translations;
use Wavevision\NamespaceTranslator\Transfer\InjectLocales;

/**
 * @DIService(generateInject=true)
 */
class ConvertToLines
{

	use SmartObject;
	use InjectLocales;

	public const FILE = FileSet::FILE;

	public const KEY = 'key';

	public const FORMAT = FileSet::FORMAT;

	/**
	 * @return array<mixed>
	 */
	public function process(Translations $translations): array
	{
		$lines[] = [
			$this->lock(self::FILE),
			$this->lock(self::KEY),
			...$this->locales->allLocales(),
			$this->lock(self::FORMAT),
		];
		$defaultLocale = $this->locales->defaultLocale();
		$optionalLocales = $this->locales->optionalLocales();
		foreach ($translations->getFileSets() as $fileSet) {
			$path = $fileSet->getFile();
			$format = $fileSet->getFormat();
			foreach ($fileSet->getTranslations() as $key => $translation) {
				$fields = [$path, $key, $translation[$defaultLocale]];
				foreach ($optionalLocales as $locale) {
					$fields[] = $translation[$locale] ?? null;
				}
				$lines[] = [...$fields, $format];
			}
		}
		return $lines;
	}

	private function lock(string $key): string
	{
		return sprintf("%s (editing forbidden)", $key);
	}

}
