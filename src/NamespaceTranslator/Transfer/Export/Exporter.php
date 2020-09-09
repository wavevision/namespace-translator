<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\DI\Extension;
use Wavevision\NamespaceTranslator\Transfer\Export\Writters\InjectCsv;
use Wavevision\NamespaceTranslator\Transfer\Export\Writters\InjectGoogleSheet;
use Wavevision\NamespaceTranslator\Transfer\Storages\Google\Config;

/**
 * @DIService(generateInject=true, params={"%export%"})
 */
class Exporter
{

	use InjectCsv;
	use InjectGoogleSheet;
	use SmartObject;

	/**
	 * @var array<mixed>
	 */
	private array $export;

	/**
	 * @param array<mixed> $export
	 */
	public function __construct(array $export)
	{
		$this->export = $export;
	}

	public function export(): void
	{
		foreach ($this->export as $type => $config) {
			switch ($type) {
				case Extension::CSV:
					foreach ($config[Extension::PARTS] as $part) {
						$this->csv->write($part[Extension::DIRECTORY], $part[Extension::FILENAME]);
					}
					break;
				case Extension::GOOGLE:
					foreach ($config[Extension::PARTS] as $part) {
						$this->googleSheet->write(
							new Config(
								$config[Extension::CREDENTIALS],
								$config[Extension::SHEET_ID],
								$part[Extension::TAB_NAME]
							),
							$part[Extension::DIRECTORY],
						);
					}
					break;
			}
		}
	}

}
