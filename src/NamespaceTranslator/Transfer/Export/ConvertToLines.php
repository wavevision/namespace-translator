<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Transfer\InjectLocales;
use function array_search;
use function is_int;

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
	 * @return array<array<string>>
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
					$fields[] = $translation[$locale] ?? '';
				}
				$lines[] = [...$fields, $format];
			}
		}
		return $lines;
	}

	/**
	 * @return array<string>
	 */
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
		$position = array_search($value, $this->createHeader(), true);
		if (is_int($position)) {
			return $position;
		}
		throw new InvalidState("Unable to find '$value' in header.");
	}

}
