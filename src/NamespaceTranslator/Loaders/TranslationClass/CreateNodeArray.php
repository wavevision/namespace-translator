<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Scalar\String_;
use Wavevision\DIServiceAnnotation\DIService;

/**
 * @DIService(generateInject=true)
 */
class CreateNodeArray
{

	use SmartObject;
	use InjectSerializeClassConstFetch;

	public function process(array $content): Array_
	{
		return $this->createArray($this->items($content));
	}

	private function items(array $content): array
	{
		$items = [];
		foreach ($content as $key => $value) {
			$items[] = new ArrayItem(
				is_array($value) ? $this->createArray($this->items($content[$key])) : new String_($value),
				$this->key($key)
			);
		}
		return $items;
	}

	private function key(string $key): Expr
	{
		if ($this->serializeClassConstFetch->isSerialized($key)) {
			return $this->serializeClassConstFetch->deserialize($key);
		}
		return new String_($key);
	}

	private function createArray(array $items): Array_
	{
		return new Array_($items, ['shortArraySyntax' => Array_::KIND_SHORT]);
	}

}
