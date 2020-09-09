<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Import;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Transfer\Import\Readers\InjectCsv;
use Wavevision\NamespaceTranslator\Transfer\Import\Readers\InjectGoogleSheet;
use Wavevision\NamespaceTranslator\Transfer\InjectTransferWalker;
use Wavevision\NamespaceTranslator\Transfer\Storages\Google\Config;

/**
 * @DIService(generateInject=true)
 */
class Importer
{

	use InjectCsv;
	use InjectGoogleSheet;
	use InjectTransferWalker;
	use SmartObject;

	public function import(): void
	{
		$this->transferWalker->execute(
			function (string $directory, string $filename): void {
				$this->csv->read($filename, $directory);
			},
			function (Config $config, string $directory): void {
				$this->googleSheet->read($config, $directory);
			}
		);
	}

}
