<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export\Writters;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Transfer\Export\InjectExtractTranslationLines;
use Wavevision\NamespaceTranslator\Transfer\Storages\Csv\InjectCsvWritter;

/**
 * @DIService(generateInject=true)
 */
class Csv
{

	use InjectCsvWritter;
	use InjectExtractTranslationLines;
	use SmartObject;

	public function write(string $directory, string $file): void
	{
		$this->csvWritter->write($file, $this->extractTranslationLines->process($directory));
	}

}
