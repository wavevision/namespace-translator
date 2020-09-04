<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

trait InjectRewriteArray
{

	protected RewriteArray $rewriteArray;

	public function injectRewriteArray(RewriteArray $rewriteArray): void
	{
		$this->rewriteArray = $rewriteArray;
	}

}
