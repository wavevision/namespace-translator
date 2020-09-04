<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use PhpParser\ConstExprEvaluator;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Scalar\String_;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;

/**
 * @DIService(generateInject=true)
 */
class RewriteArray
{

	use SmartObject;

	public function process(Array_ $array, array $content): void
	{
		/** @var ArrayItem $item */
		foreach ($array->items as $item) {
			$key = $this->key($item);
			$objectValue = $item->value;
			if ($objectValue instanceof String_) {
				$objectValue->value = $content[$key];
			}
			if ($objectValue instanceof Array_) {
				$this->process($objectValue, $content[$key]);
			}
		}
	}

	private function key(ArrayItem $item): string
	{
		ConstExprEvaluator::class;
		$keyObject = $item->key;
		if ($keyObject instanceof String_) {
			return $keyObject->value;
		}
		if ($keyObject instanceof ClassConstFetch) {
			var_dump($keyObject);
			$evaluator = new ConstExprEvaluator();
			$x = $evaluator->evaluateDirectly($keyObject);
		}
		throw new InvalidState();
	}

	private function value(ArrayItem $item): String_
	{
		$objectValue = $item->value;
		if ($objectValue instanceof String_) {
			return $objectValue;
		}
		throw new InvalidState();
	}

}