<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export\Writters;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;

/**
 * @DIService(generateInject=true)
 */
class Csv
{

	use SmartObject;

	/**
	 * @param array<mixed> $lines
	 */
	public function write(string $file, array $lines): void
	{
		$fp = fopen($file, 'w');
		if ($fp === false) {
			throw new InvalidState("Unable to open file $file.");
		}
		foreach ($lines as $line) {
			fputcsv($fp, $line);
		}
		fclose($fp);
	}

}
