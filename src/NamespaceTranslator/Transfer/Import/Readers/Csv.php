<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Import\Readers;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Transfer\Import\InjectSaveLines;
use Wavevision\NamespaceTranslator\Transfer\Storages\Csv\InjectCsvReader;

/**
 * @DIService(generateInject=true)
 */
class Csv
{

	use InjectCsvReader;
	use InjectSaveLines;
	use SmartObject;

	public function read(string $file, string $directory): void
	{
		$this->saveLines->process($directory, $this->csvReader->read($file));
	}

}
