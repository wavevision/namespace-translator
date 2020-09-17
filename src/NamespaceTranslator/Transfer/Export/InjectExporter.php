<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export;

trait InjectExporter
{

	protected Exporter $exporter;

	public function injectExporter(Exporter $exporter): void
	{
		$this->exporter = $exporter;
	}

}
