<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export;

trait InjectExportTranslations
{

	protected ExportTranslations $exportTranslations;

	public function injectExportTranslations(ExportTranslations $exportTranslations): void
	{
		$this->exportTranslations = $exportTranslations;
	}

}
