<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\String_;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\Utils\Arrays;

/**
 * @DIService(generateInject=true)
 */
class SerializeMessage
{

	use SmartObject;
	use InjectSerializeClassConstFetch;
	
	public function serialize(Expr $expr): string
	{
		if (!($expr instanceof StaticCall)) {
			throw new InvalidState('Token StaticCall expected.');
		}
		$args = $expr->args;
		$message = $this->message($expr->args[0]);
		$args = $this->args(array_slice($args, 1, count($args)));
		return sprintf($message, ...$args);
	}

	public function deserialize(string $serialized): Expr
	{
		$regex = sprintf(
			'({%s[a-zA-Z%s]*%s[a-zA-Z]*})',
			...Arrays::map(
			[SerializeClassConstFetch::C, SerializeClassConstFetch::D_CLASS_PART_SEPARATOR, SerializeClassConstFetch::D_SEPARATOR],
			fn(string $c) => preg_quote($c)
		)
		);
		$firstArgument = preg_replace($regex, '%s', $serialized);
		return new StaticCall(
			new Name('Message'),
			new Name('create'),
			[new Arg(new String_($firstArgument)), ...$this->createArgs($serialized, $regex)]
		);
	}

	private function createArgs(string $serialized, string $regex): array
	{
		$matches = [];
		preg_match_all($regex, $serialized, $matches);
		return Arrays::map(
			$matches[0],
			fn(string $match) => new Arg($this->serializeClassConstFetch->deserialize(trim($match, '{}')))
		);
	}

	private function message(Arg $arg): string
	{
		$value = $arg->value;
		if ($value instanceof String_) {
			return $value->value;
		}
		throw new InvalidState('Failed to parse');
	}

	/**
	 * @param Arg[] $args
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
		throw new InvalidState('Arg should be ClassConstFetch');
	}

}
