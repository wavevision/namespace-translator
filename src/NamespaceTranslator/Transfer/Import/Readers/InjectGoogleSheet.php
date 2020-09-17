<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Import\Readers;

trait InjectGoogleSheet
{

	protected GoogleSheet $googleSheet;

	public function injectGoogleSheet(GoogleSheet $googleSheet): void
	{
		$this->googleSheet = $googleSheet;
	}

}
