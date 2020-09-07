<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

trait InjectTraverseFileAst
{

	protected TraverseFileAst $traverseFileAst;

	public function injectTraverseFileAst(TraverseFileAst $traverseFileAst): void
	{
		$this->traverseFileAst = $traverseFileAst;
	}

}
