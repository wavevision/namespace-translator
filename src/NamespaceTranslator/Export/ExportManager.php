<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Export;

use Kdyby\Translation\Translator;
use Nette\SmartObject;
use Nette\Utils\FileSystem;
use Nette\Utils\Finder;
use Wavevision\NamespaceTranslator\DomainManager;
use Wavevision\NamespaceTranslator\ParametersManager;
use Wavevision\NamespaceTranslator\ResourceManager;
use Wavevision\Utils\Path;

class ExportManager
{

	use SmartObject;

	private const KEY = 'key';

	/**
	 * @var ParametersManager
	 */
	private $pm;

	/**
	 * @var Translator
	 */
	private $translator;

	public function __construct(ParametersManager $pm, Translator $translator)
	{
		$this->pm = $pm;
		$this->translator = $translator;
	}

	public function getDefaultFileName(): string
	{
		return $this->getDefaultLocale() . DomainManager::DOMAIN_DELIMITER . ResourceManager::FORMAT;
	}

	public function findResources(): Finder
	{
		$files = '*' . $this->getDefaultFileName();
		return Finder::findFiles(Path::join(ResourceManager::DIR, $files))
			->from(...$this->pm->getRootDirs())
			->exclude(...$this->pm->getExclude());
	}

	public function getDefaultLocale(): string
	{
		return $this->translator->getDefaultLocale();
	}

	public function getExportDir(): string
	{
		$dir = $this->pm->getExportDir();
		if (!is_dir($dir)) {
			FileSystem::createDir($dir);
		}
		return $dir;
	}

	public function getExportFile(string $locale): string
	{
		return Path::join($this->getExportDir(), "$locale.csv");
	}

	/**
	 * @param string $locale
	 * @return string[]
	 */
	public function getHeader(string $locale): array
	{
		return [self::KEY, $this->getDefaultLocale(), $locale];
	}

	public function getLocaleResource(string $resourcePath, string $locale): string
	{
		return str_replace(
			$this->getDefaultFileName(),
			$locale . DomainManager::DOMAIN_DELIMITER . ResourceManager::FORMAT,
			$resourcePath
		);
	}

	/**
	 * @return string[]
	 */
	public function getLocales(): array
	{
		return array_filter(
			$this->translator->getAvailableLocales(),
			function (string $locale): bool {
				return $locale !== $this->getDefaultLocale();
			}
		);
	}

	public function getResourceNamespace(string $resourcePath): string
	{
		$root = dirname(str_replace($this->pm->getRootDirs(), $this->pm->getRootNamespace(), $resourcePath));
		$namespace = str_replace(Path::DELIMITER, DomainManager::NAMESPACE_DELIMITER, $root);
		return rtrim(str_replace(ResourceManager::DIR, '', $namespace), DomainManager::NAMESPACE_DELIMITER);
	}

}
