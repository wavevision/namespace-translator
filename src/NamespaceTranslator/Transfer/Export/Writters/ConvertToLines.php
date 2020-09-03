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
		$lines[] = $this->createHeader();
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

	public function createHeader(): array
	{
		return [
			self::FILE,
			self::KEY,
			...$this->locales->allLocales(),
			self::FORMAT,
		];
	}

	public function headerPosition(string $value): int
	{
		return array_search($value, $this->createHeader(), true);
	}

}
