<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use function explode;
use function implode;
use function strlen;
use function strpos;
use function substr;

/**
 * @DIService(generateInject=true)
 */
class SerializeClassConstFetch
{

	use SmartObject;

	public const C = 'c:';

	public const D_CLASS_PART_SEPARATOR = '\\';

	public const D_SEPARATOR = '-';

	public function serialize(ClassConstFetch $classConstFetch): string
	{
		return self::C . implode(
			self::D_CLASS_PART_SEPARATOR,
			$this->parts($classConstFetch),
		) . self::D_SEPARATOR . $this->name($classConstFetch);
	}

	public function isSerialized(string $string): bool
	{
		return strpos($string, self::C) === 0;
	}

	public function deserialize(string $string): ClassConstFetch
	{
		$string = substr($string, strlen(self::C), strlen($string));
		[$class, $name] = explode(self::D_SEPARATOR, $string);
		return new ClassConstFetch(new Name(explode(self::D_CLASS_PART_SEPARATOR, $class)), new Identifier($name));
	}

	/**
	 * @return array<string>
	 */
	private function parts(ClassConstFetch $classConstFetch): array
	{
		$class = $classConstFetch->class;
		if ($class instanceof Name) {
			return $class->parts;
		}
		throw $this->unsupported();
	}

	private function name(ClassConstFetch $classConstFetch): string
	{
		$name = $classConstFetch->name;
		if ($name instanceof Identifier) {
			return $name->name;
		}
		throw $this->unsupported();
	}

	private function unsupported(): InvalidState
	{
		return new InvalidState('Unsupported const format. Allowed format is self::NAME or Class::NAME.');
	}

}
