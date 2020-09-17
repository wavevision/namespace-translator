<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;

class ReturnFinder extends NodeVisitorAbstract
{

	private Return_ $return;

	/**
	 * @return mixed
	 */
	public function leaveNode(Node $node)
	{
		if ($node instanceof ClassMethod) {
			if ($node->name->name !== 'define') {
				throw new InvalidState("TranslationClass must contains function 'define'.");
			}
			if (!($node->isStatic() && $node->isPublic())) {
				throw new InvalidState('Define function must be public and static.');
			}
			$stmts = $node->getStmts();
			if (isset($stmts[0]) && count($stmts) === 1) {
				/** @var Return_ $return */
				$return = $stmts[0];
				$this->return = $return;
			} else {
				throw new InvalidState('Define function must have exactly one statement.');
			}
			return NodeTraverser::STOP_TRAVERSAL;
		}
	}

	public function getReturn(): Return_
	{
		if (isset($this->return)) {
			return $this->return;
		}
		throw new InvalidState('No class method found.');
	}

}
