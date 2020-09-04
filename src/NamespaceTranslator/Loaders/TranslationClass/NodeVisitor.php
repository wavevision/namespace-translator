<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Stmt\Return_;
use PhpParser\NodeVisitorAbstract;

class NodeVisitor extends NodeVisitorAbstract
{

	use SmartObject;

	private Array_ $array;

	public function __construct(Array_ $array)
	{
		$this->array = $array;
	}

	public function leaveNode(Node $node)
	{
		/*if ($node instanceof Node\Identifier && $node->name === $this->className) {
			$this->classIdentifierNode = $node;
		}*/
		if ($node instanceof Node\Stmt\ClassMethod) {
			new Node\Stmt\ClassMethod('define', [new Return_($this->array)]);
		}
		return $node;
	}

}