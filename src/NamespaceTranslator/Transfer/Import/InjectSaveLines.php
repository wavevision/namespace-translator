<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Import;

trait InjectSaveLines
{

	protected SaveLines $saveLines;

	public function injectSaveLines(SaveLines $saveLines): void
	{
		$this->saveLines = $saveLines;
	}

}
