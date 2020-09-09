<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Import;

trait InjectImporter
{

	protected Importer $importer;

	public function injectImporter(Importer $importer): void
	{
		$this->importer = $importer;
	}

}
