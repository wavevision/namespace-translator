<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\NodeVisitorAbstract;

class NodeVisitor extends NodeVisitorAbstract
{

	use SmartObject;

	private Array_ $array;

	public function getArray(): Array_
	{
		return $this->array;
	}

	public function leaveNode(Node $node)
	{
		if ($node instanceof Node\Stmt\ClassMethod) {
			/** @var Node\Stmt\Return_ $return */
			$return = $node->getStmts()[0];
			/** @var Node\Expr\Array_ $array */
			$array = $return->expr;
			$this->array = $array;
		}
		return $node;
	}

}