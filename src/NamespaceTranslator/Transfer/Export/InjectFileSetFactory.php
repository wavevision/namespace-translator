<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export;

trait InjectFileSetFactory
{

	protected FileSetFactory $fileSetFactory;

	public function injectFileSetFactory(FileSetFactory $fileSetFactory): void
	{
		$this->fileSetFactory = $fileSetFactory;
	}

}
