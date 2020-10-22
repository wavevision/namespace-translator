<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\DomainManager;
use Wavevision\NamespaceTranslator\Exceptions\MissingResource;
use Wavevision\NamespaceTranslator\Resources\LocalePrefixPair;
use Wavevision\Utils\Arrays;
use function explode;
use function file_get_contents;
use function filter_var;
use const FILTER_VALIDATE_INT;

/**
 * @DIService(generateInject=true)
 */
class Helpers
{

	use SmartObject;

	public function readResourceContent(string $resource): string
	{
		$content = @file_get_contents($resource);
		if ($content === false) {
			throw new MissingResource("Unable to read contents of '$resource'.");
		}
		return $content;
	}

	public function dotNotationLocalePrefixPair(string $resourceName): LocalePrefixPair
	{
		$parts = explode(DomainManager::DOMAIN_DELIMITER, $resourceName);
		return new LocalePrefixPair(Arrays::pop($parts), Arrays::pop($parts));
	}

	/**
	 * @param int|string $key
	 * @param array<mixed> $content
	 */
	public function buildTree($key, string $value, array &$content): void
	{
		Arrays::buildTree(
			$this->explode($key),
			$value,
			$content
		);
	}

	/**
	 * @param int|string $key
	 * @return array<int|string>
	 */
	private function explode($key): array
	{
		return Arrays::map(
			explode(DomainManager::DOMAIN_DELIMITER, (string)$key),
			fn(string $part) => $this->part($part)
		);
	}

	/**
	 * @return int|string
	 */
	private function part(string $value)
	{
		$result = filter_var($value, FILTER_VALIDATE_INT);
		return $result === false ? $value : $result;
	}

}
