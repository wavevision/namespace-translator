<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Storages\Google;

trait InjectRangeFactory
{

	protected RangeFactory $rangeFactory;

	public function injectRangeFactory(RangeFactory $rangeFactory): void
	{
		$this->rangeFactory = $rangeFactory;
	}

}
