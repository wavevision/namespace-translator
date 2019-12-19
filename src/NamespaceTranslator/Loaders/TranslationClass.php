<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders;

use Nette\SmartObject;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Resources\Messages;
use Wavevision\NamespaceTranslator\Resources\Translation;
use Wavevision\Utils\Arrays;
use Wavevision\Utils\Tokenizer\Tokenizer;

class TranslationClass implements Loader
{

	use SmartObject;

	public const FORMAT = 'php';

	private const LOCALE_LENGTH = 2;

	private Tokenizer $tokenizer;

	public function __construct()
	{
		$this->tokenizer = new Tokenizer();
	}

	/**
	 * @inheritDoc
	 */
	public function load(string $resource): Messages
	{
		[$locale, $prefix] = $this->getLocalePrefixPair($resource);
		if (!$locale) {
			throw new InvalidState("Unable to detect locale for '$resource'.");
		}
		$result = $this->tokenizer->getStructureNameFromFile($resource, [T_CLASS]);
		if ($result === null) {
			throw new InvalidState("Unable to get translation class from '$resource'.");
		}
		$class = $result->getFullyQualifiedName();
		if (!class_exists($class)) {
			throw new InvalidState("Translation class '$class' does not exist.");
		}
		if (!is_subclass_of($class, Translation::class)) {
			throw new InvalidState(sprintf("Translation class '%s' must extend '%s'.", $class, Translation::class));
		}
		/** @var Translation $class */
		$messages = $class::define();
		return new Messages($messages, $locale, $prefix);
	}

	/**
	 * @inheritDoc
	 */
	public function getLocalePrefixPair(string $resource): array
	{
		$name = Manager::getLoaderResourceName($resource, self::FORMAT);
		$length = strlen($name);
		if ($length === self::LOCALE_LENGTH) {
			$pair = [$name, null];
		} else {
			$parts = @str_split($name, strlen($name) - self::LOCALE_LENGTH);
			if ($parts === false) {
				throw new InvalidState("Invalid locale format for '$resource'.");
			}
			$pair = array_reverse($parts);
		}
		return Arrays::map($pair, fn(?string $item): ?string => $item ? lcfirst($item) : $item);
	}

}
