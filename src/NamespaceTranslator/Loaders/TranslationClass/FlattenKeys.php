<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Scalar\String_;
use Wavevision\DIServiceAnnotation\DIService;

/**
 * @DIService(generateInject=true)
 */
class FlattenKeys
{

	use SmartObject;
	use InjectSerializeClassConstFetch;

	public function process(Array_ $array): array
	{
		$output = [];
		/** @var ArrayItem $item */
		foreach ($array->items as $item) {
			$key = $this->key($item);
			if ($item->value instanceof String_) {
				$output[$key] = $item->value->value;
			}
			if ($item->value instanceof Array_) {
				$output[$key] = $this->process($item->value);
			}
		}
		return $output;
	}

	private function key(ArrayItem $item)
	{
		$key = $item->key;
		if ($key instanceof String_) {
			return $key->value;
		}
		if ($key instanceof ClassConstFetch) {
			return $this->serializeClassConstFetch->serialize($key);
		}
		throw new \Exception();
	}

}
