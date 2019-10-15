<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wavevision\NamespaceTranslator\Import\ImportTranslations;

class ImportCommand extends Command
{

	private const FILE = 'file';

	/**
	 * @inject
	 * @var ImportTranslations
	 */
	public $importTranslations;

	protected function configure(): void
	{
		$this->setName('namespace-translator:import')
			->addArgument(self::FILE, InputArgument::OPTIONAL, 'Optional path to a specific CSV file')
			->setDescription(
				'Imports either a CSV file specified or all CSV files from default translations export directory.'
			);
	}

	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @return int|void|null
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		/** @var string|null $file */
		$file = $input->getArgument(self::FILE);
		$resources = $this->importTranslations->process(
			function (string $file, string $locale) use ($output): void {
				$output->writeln(
					sprintf('Importing <info>%s</info> locale from <comment>%s</comment>', strtoupper($locale), $file)
				);
			},
			function (array $resources) use ($output): void {
				$output->writeln(sprintf('<options=bold>Updated %d resources</>', count($resources)));
				$output->writeln('');
			},
			$file
		);
		$output->writeln(sprintf('<options=bold>Successfully imported %d resources</>', count($resources)));
	}

}
