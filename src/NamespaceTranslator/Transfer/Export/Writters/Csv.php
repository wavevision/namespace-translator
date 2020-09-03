<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export\Writters;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;

/**
 * @DIService(generateInject=true)
 */
class Csv
{

	use SmartObject;

	/**
	 * @param
	 */
	public function write(string $file, array $lines): void
	{
		$fp = fopen($file, 'w');
		foreach ($lines as $line) {
			fputcsv($fp, $line);
		}
		fclose($fp);
	}

}