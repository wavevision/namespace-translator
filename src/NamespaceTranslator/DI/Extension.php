<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\DI;

use Nette\DI\CompilerExtension;
use Nette\InvalidStateException;
use Nette\Schema\Processor;

class Extension extends CompilerExtension
{

	/**
	 * @var mixed[]
	 */
	protected $config = [
		self::EXCLUDE => [
			'config',
			'Console',
			'Entities',
			'Events',
			'Router',
			'templates',
		],
		self::EXPORT_DIR => '%tempDir%/translations-export',
		self::ROOT_DIRS => ['%appDir%'],
		self::ROOT_NAMESPACE => 'App',
	];

	private const EXCLUDE = 'exclude';

	private const EXPORT_DIR = 'exportDir';

	private const ROOT_DIRS = 'rootDirs';

	private const ROOT_NAMESPACE = 'rootNamespace';

	public function loadConfiguration(): void
	{
		$this->validateConfiguration();
		['services' => $services] = $this->loadFromFile(__DIR__ . '/config.neon');
		$this->compiler->loadDefinitionsFromConfig($services);
	}

	private function validateConfiguration(): void
	{
		$config = (new Processor())->process($this->getConfigSchema(), $this->getConfig());
		foreach ($config->{self::ROOT_DIRS} as $rootDir) {
			if (!is_dir($rootDir)) {
				throw new InvalidStateException("Root dir '$rootDir' does not exist.");
			}
		}
	}

}
