<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export;

use Nette\SmartObject;
use Symfony\Component\Console\Output\OutputInterface;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Transfer\Export\Writters\InjectCsv;
use Wavevision\NamespaceTranslator\Transfer\Export\Writters\InjectGoogleSheet;
use Wavevision\NamespaceTranslator\Transfer\InjectTransferWalker;
use Wavevision\NamespaceTranslator\Transfer\Storages\Google\Config;

/**
 * @DIService(generateInject=true)
 */
class Exporter
{

	use InjectCsv;
	use InjectGoogleSheet;
	use InjectTransferWalker;
	use SmartObject;

	public function export(OutputInterface $output): void
	{
		$this->transferWalker->execute(
			function (string $directory, string $filename) use ($output): void {
				$output->write("Exporting translations from directory '$directory' to CSV '$filename' ...");
				$this->csv->write($directory, $filename);
				$output->writeln(" DONE");
			},
			function (Config $config, string $directory) use ($output): void {
				$output->write(
					sprintf(
						"Exporting translations from directory '%s' to GoogleSheet '%s' tab '%s' ...",
						$directory,
						$config->getSheetId(),
						$config->getTabName()
					)
				);
				$this->googleSheet->write($config, $directory);
				$output->writeln(" DONE");
			}
		);
	}

}
