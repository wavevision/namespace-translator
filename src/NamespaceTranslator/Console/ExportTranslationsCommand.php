<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wavevision\NamespaceTranslator\Export\ExportTranslations;

class ExportTranslationsCommand extends Command
{

	/**
	 * @inject
	 * @var ExportTranslations
	 */
	public $exportTranslations;

	protected function configure(): void
	{
		$this->setName('namespace-translator:export-translations')
			->setDescription('Exports translation resources to CSV files based on locale.');
	}

	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @return int|void|null
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$files = $this->exportTranslations->process(
			function (string $locale) use ($output): void {
				$output->writeln(sprintf('Exporting <info>%s</info> locale', strtoupper($locale)));
			},
			function (string $file) use ($output): void {
				$output->writeln(sprintf('Export located at <comment>%s</comment>', $file));
				$output->writeln('');
			}
		);
		$output->writeln(sprintf('<options=bold>Successfully exported %d files</>', count($files)));
	}

}
