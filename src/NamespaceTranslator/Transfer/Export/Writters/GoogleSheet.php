<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export\Writters;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Transfer\Export\InjectExtractTranslationLines;
use Wavevision\NamespaceTranslator\Transfer\Storages\Google\Config;
use Wavevision\NamespaceTranslator\Transfer\Storages\Google\InjectGoogleSheetWritter;
use Wavevision\NamespaceTranslator\Transfer\Storages\Google\Sheet;

/**
 * @DIService(generateInject=true)
 */
class GoogleSheet
{

	use SmartObject;
	use InjectGoogleSheetWritter;
	use InjectExtractTranslationLines;

	public function write(Config $config, string $directory, string $tabName): void
	{
		$this->googleSheetWritter->write(
			$config,
			new Sheet($tabName, $this->extractTranslationLines->process($directory))
		);
	}

}