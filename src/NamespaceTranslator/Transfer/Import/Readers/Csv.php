<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Import\Readers;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\Utils\File;

/**
 * @DIService(generateInject=true)
 */
class Csv
{

	use SmartObject;

	/**
	 * @return array<mixed>
	 */
	public function read(string $file): array
	{
		$fp = File::open($file, 'r');
		$lines = [];
		while ($line = $fp->getCsv()) {
			$lines[] = $line;
		}
		return $lines;
	}

}