<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Transfer\Export\InjectExporter;

/**
 * @codeCoverageIgnore
 * @DIService
 */
class ExportCommand extends Command
{

	use InjectExporter;

	public const NAME = 'namespace-translator:export';

	/**
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint
	 * @var string
	 */
	protected static $defaultName = self::NAME;

	protected function configure(): void
	{
		$this->setDescription('Export translation to configured storage.');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$this->exporter->export($output);
		return 0;
	}

}
