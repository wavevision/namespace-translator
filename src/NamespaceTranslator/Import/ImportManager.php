<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Import;

use Kdyby\Translation\CatalogueCompiler;
use Nette\InvalidStateException;
use Nette\SmartObject;
use Wavevision\NamespaceTranslator\DomainManager;
use Wavevision\NamespaceTranslator\Export\ExportManager;
use Wavevision\NamespaceTranslator\ParametersManager;
use Wavevision\NamespaceTranslator\ResourceManager;
use Wavevision\Utils\Path;

class ImportManager
{

	use SmartObject;

	/**
	 * @var CatalogueCompiler
	 */
	private $catalogueCompiler;

	/**
	 * @var DomainManager
	 */
	private $domainManager;

	/**
	 * @var ExportManager
	 */
	private $exportManager;

	/**
	 * @var ParametersManager
	 */
	private $pm;

	public function __construct(
		CatalogueCompiler $catalogueCompiler,
		DomainManager $domainManager,
		ExportManager $exportManager,
		ParametersManager $pm
	) {
		$this->catalogueCompiler = $catalogueCompiler;
		$this->domainManager = $domainManager;
		$this->exportManager = $exportManager;
		$this->pm = $pm;
	}

	public function getImportDir(): string
	{
		$dir = $this->pm->getExportDir();
		if (!is_dir($dir)) {
			throw new InvalidStateException("Import directory '$dir' is missing.");
		}
		return $dir;
	}

	/**
	 * @param string $key
	 * @param string $locale
	 * @return string[]
	 */
	public function getResourceKeyPair(string $key, string $locale): array
	{
		$dir = '';
		$namespace = $this->domainManager->getNamespace($key);
		foreach ($this->pm->getRootDirs() as $rootDir) {
			if ($resourceDir = $this->findResourceDir($namespace, $rootDir)) {
				$dir = Path::join($resourceDir, ResourceManager::DIR);
			}
		}
		if (!is_dir($dir)) {
			throw new InvalidStateException("Translations directory '$dir' does not exist.'");
		}
		$file = Path::join(
			$dir,
			$this->exportManager->getDefaultLocale() . DomainManager::DOMAIN_DELIMITER . ResourceManager::FORMAT
		);
		$key = ltrim(
			str_replace($this->domainManager->getDomain($this->exportManager->getResourceNamespace($dir)), '', $key),
			DomainManager::DOMAIN_DELIMITER
		);
		$prefix = explode(DomainManager::DOMAIN_DELIMITER, $key)[0] ?? '';
		$prefixedFile = Path::join(dirname($file), $prefix . DomainManager::DOMAIN_DELIMITER . basename($file));
		if (is_file($prefixedFile)) {
			return [
				$this->exportManager->getLocaleResource($prefixedFile, $locale),
				str_replace($prefix . DomainManager::DOMAIN_DELIMITER, '', $key),
			];
		}
		return [$this->exportManager->getLocaleResource($file, $locale), $key];
	}

	public function invalidateCache(): void
	{
		$this->catalogueCompiler->invalidateCache();
	}

	private function findResourceDir(string $namespace, string $rootDir): ?string
	{
		/** @var string $path */
		$path = str_replace(
			[$this->pm->getRootNamespace(), DomainManager::NAMESPACE_DELIMITER],
			[$rootDir, Path::DELIMITER],
			$namespace
		);
		do {
			$delimiter = strrpos($path, Path::DELIMITER);
			if (!$delimiter) {
				continue;
			}
			$path = substr($path, 0, $delimiter);
		} while ($path !== $rootDir && !is_dir($path));
		return $path === $rootDir ? null : $path;
	}

}
