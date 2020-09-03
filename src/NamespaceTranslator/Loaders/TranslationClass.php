<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders;

use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\Printer;
use Nette\SmartObject;
use ReflectionClass;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Exceptions\SkipResource;
use Wavevision\NamespaceTranslator\Resources\LocalePrefixPair;
use Wavevision\NamespaceTranslator\Resources\Translation;
use Wavevision\NamespaceTranslator\Transfer\InjectLocales;
use Wavevision\Utils\Arrays;
use Wavevision\Utils\Tokenizer\Tokenizer;
use Wavevision\Utils\Tokenizer\TokenizeResult;

class TranslationClass implements Loader
{

	use SmartObject;
	use InjectLocales;

	public const FORMAT = 'php';

	private Tokenizer $tokenizer;

	public function __construct()
	{
		$this->tokenizer = new Tokenizer();
	}

	/**
	 * @return array<mixed>
	 */
	public function load(string $resource): array
	{
		$result = $this->tokenizerResult($resource);
		$class = $result->getFullyQualifiedName();
		if (!class_exists($class)) {
			throw new InvalidState("Translation class '$class' does not exist.");
		}
		if (!in_array(Translation::class, class_implements($class))) {
			throw new InvalidState(sprintf("Translation class '%s' must implement '%s'.", $class, Translation::class));
		}
		if ((new ReflectionClass($class))->isAbstract()) {
			throw new SkipResource();
		}
		/** @var Translation $class */
		return $class::define();
	}

	/**
	 * @inheritDoc
	 */
	public function getLocalePrefixPair(string $resourceName): LocalePrefixPair
	{
		$parts = preg_split('/(?=[A-Z])/', $resourceName);
		if ($parts === false) {
			throw new InvalidState("Invalid resource name '$resourceName'.");
		}
		return new LocalePrefixPair(Arrays::pop($parts), Arrays::implode($parts, ''));
	}

	public function fileSuffix(string $locale): string
	{
		return ucfirst($locale) . '.php';
	}

	public function save(string $resource, array $content): void
	{
		$result = $this->tokenizerResult($resource);
		//todo parse existing file to nette generator, that rewrite
		$file = new PhpFile();
		$file->setStrictTypes(true);
		$namespace = $file->addNamespace($result->getNamespace());
		$class = $namespace->addClass($result->getName());
		$class->addImplement(Translation::class);
		$define = $class->addMethod('define');
		$define
			->setStatic(true)
			->setReturnType('array')
			->setBody('return ' . var_export($content, true) . ';');
		$c = (new Printer())->printFile($file);
		var_dump($c);
	}
	
	private function tokenizerResult(string $resource): TokenizeResult
	{
		if (!is_file($resource)) {
			throw new InvalidState("Unable to read file '$resource'.");
		}
		$result = $this->tokenizer->getStructureNameFromFile($resource, [T_CLASS]);
		if ($result === null) {
			throw new InvalidState("Unable to get translation class from '$resource'.");
		}
		return $result;
	}

}
