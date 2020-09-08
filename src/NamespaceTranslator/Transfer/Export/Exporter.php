<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Transfer\Export\Writters\InjectConvertToLines;
use Wavevision\NamespaceTranslator\Transfer\Export\Writters\InjectCsv;

/**
 * @DIService(generateInject=true)
 */
class Exporter
{

	use InjectConvertToLines;
	use InjectCsv;
	use InjectExtractTranslations;
	use SmartObject;

	public function exportCsv(string $directory, string $file): void
	{
		$translations = $this->extractTranslations->process($directory);
		$translations->sort(
			fn(FileSet $a, FileSet $b): int => $a->getFile() <=> $b->getFile()
		);
		$this->csv->write(
			$file,
			$this->convertToLines->process($translations)
		);
	}

}
