<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Storages\Csv;

trait InjectCsvReader
{

	protected CsvReader $csvReader;

	public function injectCsvReader(CsvReader $csvReader): void
	{
		$this->csvReader = $csvReader;
	}

}
