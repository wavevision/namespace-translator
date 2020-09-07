<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

trait InjectSaveFileAst
{

	protected SaveFileAst $saveFileAst;

	public function injectSaveFileAst(SaveFileAst $saveFileAst): void
	{
		$this->saveFileAst = $saveFileAst;
	}

}
