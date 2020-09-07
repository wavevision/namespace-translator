<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;

class ClassNameRewritter extends NodeVisitorAbstract
{

	use SmartObject;

	private string $newClassName;

	public function __construct(string $newClassName)
	{
		$this->newClassName = $newClassName;
	}

	public function enterNode(Node $node)
	{
		if ($node instanceof Node\Stmt\Class_) {
			$node->name = new Node\Identifier($this->newClassName);
			return NodeTraverser::STOP_TRAVERSAL;
		}
	}

}
