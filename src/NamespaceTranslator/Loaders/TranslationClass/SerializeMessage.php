<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\String_;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\Utils\Arrays;
use function array_slice;
use function count;
use function preg_match_all;
use function preg_quote;
use function preg_replace;
use function sprintf;
use function str_replace;
use function trim;

/**
 * @DIService(generateInject=true)
 */
class SerializeMessage
{

	use SmartObject;
	use InjectSerializeClassConstFetch;

	private const CLASS_NAME = 'Message';

	private const FUNCTION_NAME = 'create';

	public function serialize(Expr $expr): string
	{
		/** @var StaticCall $expr */
		if (!($expr instanceof StaticCall)) {
			throw $this->serializationFailed();
		}
		$args = $expr->args;
		if (count($args) < 2) {
			throw $this->serializationFailed();
		}
		/** @var Name $class */
		$class = $expr->class;
		if ($class->parts[0] !== self::CLASS_NAME) {
			throw $this->serializationFailed();
		}
		/** @var Identifier $function */
		$function = $expr->name;
		if ($function->name !== self::FUNCTION_NAME) {
			throw $this->serializationFailed();
		}
		$message = $this->message($args[0]);
		$args = $this->args(array_slice($args, 1, count($args)));
		return sprintf($message, ...$args);
	}

	public function deserialize(string $serialized): ?Expr
	{
		$serialized = str_replace('%', '%%', $serialized);
		$regex = sprintf(
			'({%s[a-zA-Z%s]*%s[a-zA-Z_]*})',
			...Arrays::map(
				[
				SerializeClassConstFetch::C,
				SerializeClassConstFetch::D_CLASS_PART_SEPARATOR,
				SerializeClassConstFetch::D_SEPARATOR,
				],
				fn(string $c) => preg_quote($c)
			)
		);
		$matches = [];
		$result = preg_match_all($regex, $serialized, $matches);
		if (!$result) {
			return null;
		}
		/** @var string $firstArgument */
		$firstArgument = preg_replace($regex, '%s', $serialized);
		return new StaticCall(
			new Name(self::CLASS_NAME),
			new Identifier(self::FUNCTION_NAME),
			[new Arg(new String_($firstArgument)), ...$this->createArgs($matches[0])]
		);
	}

	/**
	 * @param array<mixed> $matches
	 * @return Arg[]
	 */
	private function createArgs(array $matches): array
	{
		return Arrays::map(
			$matches,
			fn(string $match) => new Arg($this->serializeClassConstFetch->deserialize(trim($match, '{}')))
		);
	}

	private function message(Arg $arg): string
	{
		$value = $arg->value;
		if ($value instanceof String_) {
			return $value->value;
		}
		throw $this->serializationFailed();
	}

	/**
	 * @param Arg[] $args
	 * @return array<string>
	 */
	private function args(array $args): array
	{
		return Arrays::map($args, fn(Arg $arg) => sprintf('{%s}', $this->arg($arg)));
	}

	private function arg(Arg $arg): string
	{
		$value = $arg->value;
		if ($value instanceof ClassConstFetch) {
			return $this->serializeClassConstFetch->serialize($value);
		}
		throw $this->serializationFailed();
	}

	private function serializationFailed(): InvalidState
	{
		$format = sprintf(
			"%s::%s('Message', ...[args])",
			self::CLASS_NAME,
			self::FUNCTION_NAME
		);
		return new InvalidState(
			"Unsupported expression found. Supported format: $format.",
		);
	}

}
