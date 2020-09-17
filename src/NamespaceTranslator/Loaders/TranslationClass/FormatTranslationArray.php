<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;

/**
 * @DIService(generateInject=true)
 */
class FormatTranslationArray
{

	use InjectSerializeClassConstFetch;
	use InjectSerializeMessage;
	use SmartObject;

	/**
	 * @return array<mixed>
	 */
	public function process(Array_ $array): array
	{
		$output = [];
		/** @var ArrayItem $item */
		foreach ($array->items as $item) {
			$output[$this->key($item)] = $this->value($item);
		}
		return $output;
	}

	/**
	 * @return array<mixed>|string
	 */
	private function value(ArrayItem $item)
	{
		$value = $item->value;
		if ($value instanceof String_) {
			return $value->value;
		} elseif ($value instanceof Array_) {
			return $this->process($value);
		} else {
			return $this->serializeMessage->serialize($value);
		}
	}

	/**
	 * @return int|string
	 */
	private function key(ArrayItem $item)
	{
		$key = $item->key;
		if ($key instanceof LNumber) {
			return $key->value;
		}
		if ($key instanceof String_) {
			return $key->value;
		}
		if ($key instanceof ClassConstFetch) {
			return $this->serializeClassConstFetch->serialize($key);
		}
		throw new InvalidState('Key should be integer, string or class constant.');
	}

}
