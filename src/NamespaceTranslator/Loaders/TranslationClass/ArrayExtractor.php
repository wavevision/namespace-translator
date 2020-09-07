<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use PhpParser\NodeVisitorAbstract;

class ArrayExtractor extends NodeVisitorAbstract
{

	private Array_ $array;

	public function leaveNode(Node $node): void
	{
		if ($node instanceof ClassMethod) {
			/** @var Return_ $return */
			$return = $node->getStmts()[0];
			/** @var Array_ $array */
			$array = $return->expr;
			$this->array = $array;
		}
	}

	public function getArray(): Array_
	{
		return $this->array;
	}

}
