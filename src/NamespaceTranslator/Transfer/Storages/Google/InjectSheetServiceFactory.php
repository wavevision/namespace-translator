<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Storages\Google;

trait InjectSheetServiceFactory
{

	protected SheetServiceFactory $sheetServiceFactory;

	public function injectSheetServiceFactory(SheetServiceFactory $sheetServiceFactory): void
	{
		$this->sheetServiceFactory = $sheetServiceFactory;
	}

}
