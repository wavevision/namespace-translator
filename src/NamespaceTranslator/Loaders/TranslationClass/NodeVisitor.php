<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use Wavevision\DIServiceAnnotation\DIService;

/**
 * @DIService(generateInject=true)
 */
class NodeVisitor extends NodeVisitorAbstract
{

	use SmartObject;
	use InjectRewriteArray;

	private array $content;

	/**
	 * @return static
	 */
	public function setContent(array $content)
	{
		$this->content = $content;
		return $this;
	}

	public function leaveNode(Node $node)
	{
		if ($node instanceof Node\Stmt\ClassMethod) {
			/** @var Node\Stmt\Return_ $return */
			$return = $node->getStmts()[0];
			/** @var Node\Expr\Array_ $array */
			$array = $return->expr;
			$this->rewriteArray->process($array, $this->content);
		}
		return $node;
	}

}