<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Models\Translated;

trait InjectOther
{

	protected Other $other;

	public function injectOther(Other $other): void
	{
		$this->other = $other;
	}

}
