<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\DI;

use Nette\DI\CompilerExtension;
use Nette\DI\Extensions\InjectExtension;
use Nette\DI\Helpers;
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
	public array $defaults = [
		self::DIR_NAMES => [
			'translations',
			'Translations',
		],
		self::LOADERS => [
			Neon::FORMAT => Neon::class,
			TranslationClass::FORMAT => TranslationClass::class,
		],
	];

	private const DIR_NAMES = 'dirNames';

	private const LOADERS = 'loaders';

	private const OPTIONS = [
		self::DIR_NAMES,
		self::LOADERS,
	];

	public function loadConfiguration(): void
	{
		$config = $this->validateExtensionConfig();
		$builder = $this->getContainerBuilder();
		['services' => $services] = $this->loadFromFile(__DIR__ . '/config.neon');
		foreach ($services as $name => $service) {
			$definition = $builder
				->addDefinition($this->prefix(is_int($name) ? 's'. $name : $name))
				->setFactory($service['factory'])
				->addTag(InjectExtension::TAG_INJECT, $service['inject'] ?? false);
			if (isset($service['arguments'])) {
				foreach ($service['arguments'] as $key => $argument) {
					$definition->setArgument($key, Helpers::expand($argument, $config));
				}
			}
		}
		$manager = $builder
			->addDefinition($this->prefix('loaderManager'))
			->setFactory(Manager::class);
		foreach ($config[self::LOADERS] as $format => $factory) {
			$loader = $builder
				->addDefinition($this->prefix($format . 'Loader'))
				->setFactory($factory)
				->addTag(InjectExtension::TAG_INJECT, true);
			$manager->addSetup('addLoader', [$format, $loader]);
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
		return $config;
	}

}
