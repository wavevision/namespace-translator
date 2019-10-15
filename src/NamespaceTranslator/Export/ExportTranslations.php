<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Export;

use Nette\SmartObject;
use SplFileInfo;
use Wavevision\NamespaceTranslator\DomainManager;
use Wavevision\NamespaceTranslator\ResourceLoader;

class ExportTranslations
{

	use SmartObject;

	/**
	 * @var DomainManager
	 */
	private $domainManager;

	/**
	 * @var ExportManager
	 */
	private $exportManager;

	/**
	 * @var ResourceLoader
	 */
	private $resourceLoader;

	public function __construct(
		DomainManager $domainManager,
		ExportManager $exportManager
	) {
		$this->domainManager = $domainManager;
		$this->exportManager = $exportManager;
		$this->resourceLoader = new ResourceLoader();
	}

	/**
	 * @param callable $onFileStart
	 * @param callable $onFileEnd
	 * @return string[]
	 */
	public function process(callable $onFileStart, callable $onFileEnd): array
	{
		$files = [];
		$export = new Export();
		foreach ($this->exportManager->getLocales() as $locale) {
			$onFileStart($locale);
			$file = $this->exportManager->getExportFile($locale);
			$export->open($file);
			$export->put($this->exportManager->getHeader($locale));
			$this->exportLocale($export, $locale);
			$export->close();
			$files[] = $file;
			$onFileEnd($file);
		}
		return $files;
	}

	private function exportLocale(Export $export, string $locale): void
	{
		/** @var SplFileInfo $resource */
		foreach ($this->exportManager->findResources() as $resource) {
			$domain = $this->domainManager->getDomain(
				$this->exportManager->getResourceNamespace($resource->getPathname())
			);
			$defaultCatalogue = $this->resourceLoader->load($resource->getPathname(), $domain);
			$localeCatalogue = null;
			$localeResource = $this->exportManager->getLocaleResource($resource->getPathname(), $locale);
			if (is_file($localeResource)) {
				$localeCatalogue = $this->resourceLoader->load($localeResource, $domain);
			}
			$this->exportMessages(
				$export,
				$domain,
				$defaultCatalogue->all(),
				$localeCatalogue ? $localeCatalogue->all() : []
			);
		}
	}

	/**
	 * @param Export $export
	 * @param string $domain
	 * @param mixed[] $defaultMessages
	 * @param mixed[] $localeMessages
	 */
	private function exportMessages(
		Export $export,
		string $domain,
		array $defaultMessages,
		array $localeMessages
	): void {
		foreach ($defaultMessages[$domain] as $key => $message) {
			$localeMessage = $localeMessages[$domain] ?? [];
			$export->put(
				[
					$domain . DomainManager::DOMAIN_DELIMITER . $key,
					$message,
					$localeMessage[$key] ?? null,
				]
			);
		}
	}

}
