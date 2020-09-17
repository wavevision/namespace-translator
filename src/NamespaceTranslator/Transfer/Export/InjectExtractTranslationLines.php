<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export;

trait InjectExtractTranslationLines
{

	protected ExtractTranslationLines $extractTranslationLines;

	public function injectExtractTranslationLines(ExtractTranslationLines $extractTranslationLines): void
	{
		$this->extractTranslationLines = $extractTranslationLines;
	}

}
