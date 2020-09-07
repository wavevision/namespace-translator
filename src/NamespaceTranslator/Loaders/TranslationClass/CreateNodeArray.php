<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Expression;
use PhpParser\ParserFactory;
use ReflectionClass;
use Wavevision\DIServiceAnnotation\DIService;

/**
 * @DIService(generateInject=true)
 */
class CreateNodeArray
{

	use SmartObject;
	use InjectSerializeClassConstFetch;

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

	private function key(string $key): Expr
	{
		if ($this->serializeClassConstFetch->isSerialized($key)) {
			return $this->serializeClassConstFetch->deserialize($key);
		}
		return new String_($key);
	}

	/**
	 * @return mixed
	 */
	private function value(string $value)
	{
		if (strpos($value, (new ReflectionClass(Message::class))->getShortName() . '::') === 0) {
			//todo better
			$stmts = (new ParserFactory())->create(ParserFactory::ONLY_PHP7)->parse('<?php ' . $value . ';');
			if (isset($stmts[0])) {
				$stmt = $stmts[0];
				if ($stmt instanceof Expression) {
					return $stmt->expr;
				}
			}
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
