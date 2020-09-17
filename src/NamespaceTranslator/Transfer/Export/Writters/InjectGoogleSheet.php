<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export\Writters;

trait InjectGoogleSheet
{

	protected GoogleSheet $googleSheet;

	public function injectGoogleSheet(GoogleSheet $googleSheet): void
	{
		$this->googleSheet = $googleSheet;
	}

}
