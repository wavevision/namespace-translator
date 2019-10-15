<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Import;

use Nette\FileNotFoundException;
use Nette\InvalidStateException;
use Nette\Neon\Encoder;
use Nette\Neon\Neon;
use Nette\SmartObject;
use Nette\Utils\FileSystem;
use Nette\Utils\Finder;
use SplFileInfo;
use Wavevision\NamespaceTranslator\DomainManager;
use Wavevision\NamespaceTranslator\Export\ExportManager;
use Wavevision\Utils\Arrays;

class ImportTranslations
{

	use SmartObject;

	/**
	 * @var Encoder
	 */
	private $encoder;

	/**
	 * @var ExportManager
	 */
	private $exportManager;

	/**
	 * @var ImportManager
	 */
	private $importManager;

	public function __construct(
		ExportManager $exportManager,
		ImportManager $importManager
	) {
		$this->encoder = new Encoder();
		$this->exportManager = $exportManager;
		$this->importManager = $importManager;
	}

	/**
	 * @param callable $onFileStart
	 * @param callable $onFileEnd
	 * @param string|null $file
	 * @return string[]
	 */
	public function process(callable $onFileStart, callable $onFileEnd, ?string $file = null): array
	{
		$import = new Import();
		if ($file) {
			if (!is_file($file)) {
				throw new FileNotFoundException("File '$file' does not exist!");
			}
			$locale = $this->openFile($import, $file);
			$onFileStart($file, $locale);
			$resources = $this->importCsv($import, $locale);
			$onFileEnd($resources);
			$this->importManager->invalidateCache();
			return $resources;
		}
		$dir = $this->importManager->getImportDir();
		$resources = [];
		$files = Finder::findFiles('*.csv')->in($dir);
		if ($files->count() === 0) {
			throw new InvalidStateException("No files to import from '$dir'.");
		}
		/** @var SplFileInfo $resource */
		foreach ($files as $resource) {
			$locale = $this->openFile($import, $resource->getPathname());
			$onFileStart($resource->getPathname(), $locale);
			$updated = $this->importCsv($import, $locale);
			$resources = array_merge($resources, $updated);
			$onFileEnd($updated);
		}
		$this->importManager->invalidateCache();
		return $resources;
	}

	public function openFile(Import $import, string $file): string
	{
		$import->open($file);
		[, , $locale] = $import->get();
		if (!in_array($locale, $this->exportManager->getLocales())) {
			throw new InvalidStateException("Invalid locale '$locale'.");
		}
		return $locale;
	}

	/**
	 * @param Import $import
	 * @param string $locale
	 * @return string[]
	 */
	private function importCsv(Import $import, string $locale): array
	{
		$resources = [];
		while ($line = $import->get()) {
			[$key, , $message] = $line;
			[$resource, $key] = $this->importManager->getResourceKeyPair($key, $locale);
			if (!isset($resources[$resource])) {
				$resources[$resource] = [];
			}
			$content = Arrays::buildTree(
				explode(DomainManager::DOMAIN_DELIMITER, $key),
				$this->filterMessage($message)
			);
			$resources[$resource] = Arrays::mergeAllRecursive($resources[$resource], $content);
		}
		foreach ($resources as $resource => $contents) {
			if (is_file($resource)) {
				$contents = Arrays::mergeAllRecursive(Neon::decode(FileSystem::read($resource)), $contents);
			}
			FileSystem::write($resource, $this->encoder->encode($contents));
		}
		$import->close();
		return array_keys($resources);
	}

	private function filterMessage(string $message): ?string
	{
		if (trim($message) === '') {
			return null;
		}
		return $message;
	}

}
