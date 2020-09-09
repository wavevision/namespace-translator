<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Import\Readers;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Transfer\Import\InjectSaveLines;
use Wavevision\NamespaceTranslator\Transfer\Storages\Google\Config;
use Wavevision\NamespaceTranslator\Transfer\Storages\Google\InjectGoogleSheetReader;

/**
 * @DIService(generateInject=true)
 */
class GoogleSheet
{

	use InjectGoogleSheetReader;
	use InjectSaveLines;
	use SmartObject;

	public function read(Config $config, string $directory): void
	{
		$this->saveLines->process($directory, $this->googleSheetReader->read($config));
	}

}
