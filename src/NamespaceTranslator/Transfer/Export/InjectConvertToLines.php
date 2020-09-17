<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export;

trait InjectConvertToLines
{

	protected ConvertToLines $convertToLines;

	public function injectConvertToLines(ConvertToLines $convertToLines): void
	{
		$this->convertToLines = $convertToLines;
	}

}
