<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Import;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Transfer\Import\Readers\InjectConvertFromLines;
use Wavevision\NamespaceTranslator\Transfer\Import\Readers\InjectCsv;

/**
 * @DIService(generateInject=true)
 */
class Importer
{

	use SmartObject;
	use InjectCsv;
	use InjectConvertFromLines;
	use InjectSaveFileSet;

	public function importCsv(string $file, string $directory): void
	{
		$translations = $this->convertFromLines->process($this->csv->read($file));
		foreach ($translations->getFileSets() as $fileSet) {
			$this->saveFileSet->process($directory, $fileSet);
		}
	}

}
