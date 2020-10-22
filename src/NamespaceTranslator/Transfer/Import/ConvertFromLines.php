<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Import;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Transfer\Export\ConvertToLines;
use Wavevision\NamespaceTranslator\Transfer\Export\FileSet;
use Wavevision\NamespaceTranslator\Transfer\Export\InjectConvertToLines;
use Wavevision\NamespaceTranslator\Transfer\Export\Translations;
use Wavevision\NamespaceTranslator\Transfer\InjectLocales;
use function array_shift;
use function implode;
use function sprintf;

/**
 * @DIService(generateInject=true)
 */
class ConvertFromLines
{

	use SmartObject;
	use InjectLocales;
	use InjectConvertToLines;

	/**
	 * @param array<mixed> $lines
	 */
	public function process(array $lines): Translations
	{
		if (!isset($lines[0])) {
			throw new InvalidState('Missing header line.');
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

	/**
	 * @param array<mixed> $lines
	 * @return array<mixed>
	 */
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

	/**
	 * @param array<string> $line
	 */
	private function lineElement(array $line, string $key): string
	{
		return $line[$this->convertToLines->headerPosition($key)];
	}

	/**
	 * @param array<string> $header
	 */
	private function formatHeader(array $header): string
	{
		return sprintf('[%s]', implode(', ', $header));
	}

}
