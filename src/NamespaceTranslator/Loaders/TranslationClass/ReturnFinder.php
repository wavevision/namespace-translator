<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;

class ReturnFinder extends NodeVisitorAbstract
{

	private Return_ $return;

	/**
	 * @return mixed
	 */
	public function leaveNode(Node $node)
	{
		if ($node instanceof ClassMethod) {
			$stmts = $node->getStmts();
			if (isset($stmts[0])) {
				/** @var Return_ $return */
				$return = $stmts[0];
				$this->return = $return;
			}
			return NodeTraverser::STOP_TRAVERSAL;
		}
	}

	public function getReturn(): Return_
	{
		return $this->return;
	}

}
