<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Transfer\Import\InjectImporter;

/**
 * @codeCoverageIgnore
 * @DIService
 */
class ImportCommand extends Command
{

	use InjectImporter;

	public const NAME = 'namespace-translator:import';

	/**
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint
	 * @var string
	 */
	protected static $defaultName = self::NAME;

	protected function configure(): void
	{
		$this->setDescription('Import translations from configured storage.');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$this->importer->import($output);
		return 0;
	}

}
