<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use PhpParser\Node\Expr\Array_;
use Wavevision\DIServiceAnnotation\DIService;

/**
 * @DIService(generateInject=true)
 */
class GetTranslationArray
{

	use SmartObject;
	use InjectTraverseFileAst;

	public function process(string $resource): Array_
	{
		$returnFinder = new ReturnFinder();
		$this->traverseFileAst->process($resource, $returnFinder);
		/** @var Array_ $array */
		$array = $returnFinder->getReturn()->expr;
		return $array;
	}

}
