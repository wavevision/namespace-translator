<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export;

trait InjectExtractTranslations
{

	protected ExtractTranslations $extractTranslations;

	public function injectExtractTranslations(ExtractTranslations $exportTranslations): void
	{
		$this->extractTranslations = $exportTranslations;
	}

}
