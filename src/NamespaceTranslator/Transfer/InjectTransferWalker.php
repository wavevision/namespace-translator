<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer;

trait InjectTransferWalker
{

	protected TransferWalker $transferWalker;

	public function injectTransferWalker(TransferWalker $transferWalker): void
	{
		$this->transferWalker = $transferWalker;
	}

}
