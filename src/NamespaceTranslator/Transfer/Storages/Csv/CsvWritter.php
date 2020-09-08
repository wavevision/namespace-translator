<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Storages\Csv;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\Utils\File;

/**
 * @DIService(generateInject=true)
 */
class CsvWritter
{

	use SmartObject;

	/**
	 * @param array<mixed> $lines
	 */
	public function write(string $file, array $lines): void
	{
		$file = File::open($file, 'w');
		foreach ($lines as $line) {
			$file->putCsv($line);
		}
		$file->close();
	}

}
