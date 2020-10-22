<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Import;

use Nette\SmartObject;
use Symfony\Component\Console\Output\OutputInterface;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Transfer\Import\Readers\InjectCsv;
use Wavevision\NamespaceTranslator\Transfer\Import\Readers\InjectGoogleSheet;
use Wavevision\NamespaceTranslator\Transfer\InjectTransferWalker;
use Wavevision\NamespaceTranslator\Transfer\Storages\Google\Config;
use function sprintf;

/**
 * @DIService(generateInject=true)
 */
class Importer
{

	use InjectCsv;
	use InjectGoogleSheet;
	use InjectTransferWalker;
	use SmartObject;

	public function import(OutputInterface $output): void
	{
		$this->transferWalker->execute(
			function (string $directory, string $filename) use ($output): void {
				$output->write("Importing translations from CSV '$filename' to directory '$directory' ...");
				$this->csv->read($filename, $directory);
				$output->writeln(' DONE');
			},
			function (Config $config, string $directory) use ($output): void {
				$output->write(
					sprintf(
						"Importing translations from GoogleSheet '%s' tab '%s' to directory '%s' ...",
						$config->getSheetId(),
						$config->getTabName(),
						$directory,
					)
				);
				$this->googleSheet->read($config, $directory);
				$output->writeln(' DONE');
			}
		);
	}

}
