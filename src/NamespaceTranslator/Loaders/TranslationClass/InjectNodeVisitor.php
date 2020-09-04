<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

trait InjectNodeVisitor
{

	protected NodeVisitor $nodeVisitor;

	public function injectNodeVisitor(NodeVisitor $nodeVisitor): void
	{
		$this->nodeVisitor = $nodeVisitor;
	}

}
