<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Import\Readers;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Transfer\Import\InjectConvertFromLines;
use Wavevision\NamespaceTranslator\Transfer\Import\InjectSaveFileSet;
use Wavevision\NamespaceTranslator\Transfer\Storages\Csv\InjectCsvReader;

/**
 * @DIService(generateInject=true)
 */
class Csv
{

	use InjectConvertFromLines;
	use InjectCsvReader;
	use InjectSaveFileSet;
	use SmartObject;

	public function read(string $file, string $directory): void
	{
		$translations = $this->convertFromLines->process($this->csvReader->read($file));
		foreach ($translations->getFileSets() as $fileSet) {
			$this->saveFileSet->process($directory, $fileSet);
		}
	}

}
