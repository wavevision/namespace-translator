<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export\Writters;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Transfer\Export\InjectExtractTranslationLines;
use Wavevision\NamespaceTranslator\Transfer\Storages\Google\Config;
use Wavevision\NamespaceTranslator\Transfer\Storages\Google\InjectGoogleSheetWritter;

/**
 * @DIService(generateInject=true)
 */
class GoogleSheet
{

	use SmartObject;
	use InjectGoogleSheetWritter;
	use InjectExtractTranslationLines;

	public function write(Config $config, string $directory): void
	{
		$this->googleSheetWritter->write(
			$config,
			$this->extractTranslationLines->process($directory)
		);
	}

}
