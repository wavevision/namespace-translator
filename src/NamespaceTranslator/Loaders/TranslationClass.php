<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders;

use Nette\SmartObject;
use ReflectionClass;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Exceptions\SkipResource;
use Wavevision\NamespaceTranslator\Resources\LocalePrefixPair;
use Wavevision\NamespaceTranslator\Resources\Messages;
use Wavevision\NamespaceTranslator\Resources\Translation;
use Wavevision\Utils\Arrays;
use Wavevision\Utils\Tokenizer\Tokenizer;

class TranslationClass implements Loader
{

	use SmartObject;

	public const FORMAT = 'php';

	private Tokenizer $tokenizer;

	public function __construct()
	{
		$this->tokenizer = new Tokenizer();
	}

	public function load(string $resource, LocalePrefixPair $localePrefixPair): Messages
	{
		$result = $this->tokenizer->getStructureNameFromFile($resource, [T_CLASS]);
		if ($result === null) {
			throw new InvalidState("Unable to get translation class from '$resource'.");
		}
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
		$messages = $class::define();
		return new Messages($messages, $localePrefixPair->getLocale(), $localePrefixPair->getPrefix());
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

}
