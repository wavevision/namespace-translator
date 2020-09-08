<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Storages\Google;

trait InjectGoogleSheetWritter
{

	protected GoogleSheetWritter $googleSheetWritter;

	public function injectGoogleSheetWritter(GoogleSheetWritter $googleSheetWritter): void
	{
		$this->googleSheetWritter = $googleSheetWritter;
	}

}
