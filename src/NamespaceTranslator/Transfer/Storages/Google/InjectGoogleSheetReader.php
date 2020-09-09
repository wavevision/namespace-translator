<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Storages\Google;

trait InjectGoogleSheetReader
{

	protected GoogleSheetReader $googleSheetReader;

	public function injectGoogleSheetReader(GoogleSheetReader $googleSheetReader): void
	{
		$this->googleSheetReader = $googleSheetReader;
	}

}
