<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Import\Readers;

trait InjectConvertFromLines
{

	protected ConvertFromLines $convertFromLines;

	public function injectConvertFromLines(ConvertFromLines $convertFromLines): void
	{
		$this->convertFromLines = $convertFromLines;
	}

}
