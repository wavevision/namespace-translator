<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use PhpParser\Node\Expr\Array_;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;

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
		$array = $returnFinder->getReturn()->expr;
		if ($array instanceof Array_) {
			return $array;
		}
		throw new InvalidState('Define function must return an array.');
	}

}
