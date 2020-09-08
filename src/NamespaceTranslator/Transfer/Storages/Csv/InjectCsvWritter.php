<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Storages\Csv;

trait InjectCsvWritter
{

	protected CsvWritter $csvWritter;

	public function injectCsvWritter(CsvWritter $csvWritter): void
	{
		$this->csvWritter = $csvWritter;
	}

}
