<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\DI;

use Nette\DI\CompilerExtension;
use Nette\DI\Helpers;
use Nette\DI\Statement;
use Nette\InvalidStateException;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

class Extension extends CompilerExtension
{

	/**
	 * @var mixed[]
	 */
	public $defaults = [
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
		$config = $this->validateExtensionConfig();
		['services' => $services] = $this->loadFromFile(__DIR__ . '/config.neon');
		foreach ($services as $service) {
			if ($service instanceof Statement) {
				foreach ($service->arguments as $key => $argument) {
					$service->arguments[$key] = Helpers::expand($argument, $config);
				}
			}
		}
		$this->compiler->loadDefinitionsFromConfig($services);
	}

	public function getConfigSchema(): Schema
	{
		$structure = [];
		foreach ([self::EXCLUDE, self::EXPORT_DIR, self::ROOT_DIRS, self::ROOT_NAMESPACE] as $item) {
			$structure[$item] = Expect::type(gettype($this->defaults[$item]))->default($this->defaults[$item]);
		}
		return Expect::structure($structure)->castTo('array');
	}

	/**
	 * @return mixed[]
	 */
	private function validateExtensionConfig(): array
	{
		$builder = $this->getContainerBuilder();
		/** @var mixed[] $config */
		$config = $this->getConfig();
		foreach ($config[self::ROOT_DIRS] as $rootDir) {
			if (!is_dir(Helpers::expand($rootDir, $builder->parameters))) {
				throw new InvalidStateException("Root dir '$rootDir' does not exist.");
			}
		}
		return $config;
	}

}
