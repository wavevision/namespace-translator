<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Import\Readers;

trait InjectCsv
{

	protected Csv $csv;

	public function injectCsv(Csv $csv): void
	{
		$this->csv = $csv;
	}

}
