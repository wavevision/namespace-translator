<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;
use Wavevision\DIServiceAnnotation\DIService;
use function is_array;
use function is_int;

/**
 * @DIService(generateInject=true)
 */
class CreateNodeArray
{

	use InjectSerializeClassConstFetch;
	use InjectSerializeMessage;
	use SmartObject;

	/**
	 * @param array<mixed> $content
	 */
	public function process(array $content): Array_
	{
		return $this->createArray($this->items($content));
	}

	/**
	 * @param array<mixed> $content
	 * @return ArrayItem[]
	 */
	private function items(array $content): array
	{
		$items = [];
		foreach ($content as $key => $value) {
			$items[] = new ArrayItem(
				is_array($value) ? $this->createArray($this->items($content[$key])) : $this->value($value),
				$this->key($key)
			);
		}
		return $items;
	}

	/**
	 * @param int|string $key
	 */
	private function key($key): Expr
	{
		if (is_int($key)) {
			return new LNumber($key);
		}
		if ($this->serializeClassConstFetch->isSerialized($key)) {
			return $this->serializeClassConstFetch->deserialize($key);
		}
		return new String_($key);
	}

	private function value(string $value): Expr
	{
		$deserialized = $this->serializeMessage->deserialize($value);
		if ($deserialized) {
			return $deserialized;
		}
		return new String_($value);
	}

	/**
	 * @param ArrayItem[] $items
	 */
	private function createArray(array $items): Array_
	{
		return new Array_($items, ['shortArraySyntax' => Array_::KIND_SHORT]);
	}

}
