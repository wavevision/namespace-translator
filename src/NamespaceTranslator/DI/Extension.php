<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\DI;

use Nette\DI\CompilerExtension;
use Nette\DI\Helpers;
use Nette\DI\Statement;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use ReflectionClass;
use Wavevision\NamespaceTranslator\Exceptions\InvalidArgument;
use Wavevision\NamespaceTranslator\Loaders\Loader;
use Wavevision\NamespaceTranslator\Loaders\Manager;
use Wavevision\NamespaceTranslator\Loaders\Neon;
use Wavevision\NamespaceTranslator\Loaders\TranslationClass;

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
		self::LOADERS => [Neon::FORMAT => Neon::class, TranslationClass::FORMAT => TranslationClass::class],
		self::ROOT_DIRS => ['%appDir%'],
		self::ROOT_NAMESPACE => 'App',
		self::TRANSLATION_DIR_NAMES => ['translations', 'Translations'],
	];

	private const EXCLUDE = 'exclude';

	private const LOADERS = 'loaders';

	private const ROOT_DIRS = 'rootDirs';

	private const ROOT_NAMESPACE = 'rootNamespace';

	private const TRANSLATION_DIR_NAMES = 'translationDirNames';

	private const OPTIONS = [
		self::EXCLUDE,
		self::LOADERS,
		self::ROOT_DIRS,
		self::ROOT_NAMESPACE,
		self::TRANSLATION_DIR_NAMES,
	];

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
		$builder = $this->getContainerBuilder();
		$manager = $builder
			->addDefinition($this->prefix('loaderManager'))
			->setFactory(Manager::class);
		foreach ($config[self::LOADERS] as $ext => $factory) {
			$loader = $builder
				->addDefinition($this->prefix($ext . 'Loader'))
				->setFactory($factory);
			$manager->addSetup('addLoader', [$ext, $loader]);
		}
	}

	public function getConfigSchema(): Schema
	{
		$structure = [];
		foreach (self::OPTIONS as $item) {
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
		foreach ($config[self::LOADERS] as $loader) {
			$loaderReflection = new ReflectionClass($loader);
			if (!$loaderReflection->implementsInterface(Loader::class)) {
				throw new InvalidArgument(
					sprintf("Loader '%s' must implement '%s' interface.", $loaderReflection->getName(), Loader::class)
				);
			}
		}
		foreach ($config[self::ROOT_DIRS] as $rootDir) {
			if (!is_dir(Helpers::expand($rootDir, $builder->parameters))) {
				throw new InvalidArgument("Root dir '$rootDir' does not exist.");
			}
		}
		return $config;
	}

}
