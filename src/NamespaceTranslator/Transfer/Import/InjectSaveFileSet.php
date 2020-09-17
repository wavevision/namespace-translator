<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Import;

trait InjectSaveFileSet
{

	protected SaveFileSet $saveFileSet;

	public function injectSaveFileSet(SaveFileSet $saveFileSet): void
	{
		$this->saveFileSet = $saveFileSet;
	}

}
