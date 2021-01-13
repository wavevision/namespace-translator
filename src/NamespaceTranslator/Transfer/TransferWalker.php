<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\DI\Extension;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Transfer\Storages\Google\Config;

/**
 * @DIService(generateInject=true, params={"%transfer%"})
 */
class TransferWalker
{

	use SmartObject;

	/**
	 * @var array<mixed>|null
	 */
	private ?array $config;

	/**
	 * @param array<mixed>|null $config
	 */
	public function __construct(?array $config)
	{
		$this->config = $config;
	}

	public function execute(callable $csv, callable $google): void
	{
		if ($this->config === null) {
			throw new InvalidState("Export/Import not configured. Property 'transfer' is not set.");
		}
		foreach ($this->config as $type => $config) {
			if ($config === null) {
				continue;
			}
			if ($type === Extension::CSV) {
				foreach ($config[Extension::PARTS] as $part) {
					$csv($part[Extension::DIRECTORY], $part[Extension::FILENAME]);
				}
			}
			if ($type === Extension::GOOGLE) {
				foreach ($config[Extension::PARTS] as $part) {
					$google(
						new Config(
							$config[Extension::CREDENTIALS],
							$config[Extension::SHEET_ID],
							$part[Extension::TAB_NAME]
						),
						$part[Extension::DIRECTORY]
					);
				}
			}
		}
	}

}
