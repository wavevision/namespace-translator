<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Import\Readers;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Transfer\Export\FileSet;
use Wavevision\NamespaceTranslator\Transfer\Export\Translations;
use Wavevision\NamespaceTranslator\Transfer\Export\Writters\ConvertToLines;
use Wavevision\NamespaceTranslator\Transfer\Export\Writters\InjectConvertToLines;
use Wavevision\NamespaceTranslator\Transfer\InjectLocales;

/**
 * @DIService(generateInject=true)
 */
class ConvertFromLines
{

	use SmartObject;
	use InjectConvertToLines;
	use InjectLocales;

	public function process(array $lines): Translations
	{
		if (!isset($lines[0])) {
			throw new InvalidState('Missing header line');
		}
		$header = $lines[0];
		$originalHeader = $this->convertToLines->createHeader();
		if ($header !== $originalHeader) {
			throw new InvalidState(
				sprintf(
					'Header is corrupted. Actual: %s, expected: %s',
					$this->formatHeader($header),
					$this->formatHeader($originalHeader)
				)
			);
		}
		array_shift($lines);
		return new Translations($this->getFileSets($lines));
	}

	private function getFileSets(array $lines): array
	{
		$fileSets = [];
		foreach ($lines as $line) {
			$file = $this->lineElement($line, ConvertToLines::FILE);
			$key = $this->lineElement($line, ConvertToLines::KEY);
			$format = $this->lineElement($line, ConvertToLines::FORMAT);
			if (!isset($fileSets[$file])) {
				$fileSets[$file] = new FileSet([], $file, $format);
			}
			$translations = [];
			foreach ($this->locales->allLocales() as $locale) {
				$translations[$locale] = $this->lineElement($line, $locale);
			}
			$fileSets[$file]->addTranslation($key, $translations);
		}
		return $fileSets;
	}

	private function lineElement(array $line, string $key): string
	{
		return $line[$this->convertToLines->headerPosition($key)];
	}

	private function formatHeader(array $header): string
	{
		return sprintf('[%s]', implode(', ', $header));
	}

}