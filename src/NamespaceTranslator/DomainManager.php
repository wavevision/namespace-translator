<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Nette\SmartObject;

class DomainManager
{

	use SmartObject;

	public const DOMAIN_DELIMITER = '.';

	public const NAMESPACE_DELIMITER = '\\';

	/**
	 * @var string[]
	 */
	private array $domains = [];

	public function getDomain(string $namespace): string
	{
		if (!isset($this->domains[$namespace])) {
			$namespaces = explode(self::NAMESPACE_DELIMITER, $namespace);
			if (class_exists($namespace)) {
				array_pop($namespaces);
			}
			$this->domains[$namespace] = Helpers::key(
				array_map(fn(string $part): string => $this->getDomainPart($part), $namespaces)
			);
		}
		return $this->domains[$namespace];
	}

	public function getNamespace(string $domain): string
	{
		return implode(
			self::NAMESPACE_DELIMITER,
			array_map(fn(string $part) => $this->getNamespacePart($part), explode(self::DOMAIN_DELIMITER, $domain))
		);
	}

	private function getDomainPart(string $namespace): string
	{
		return lcfirst($namespace);
	}

	private function getNamespacePart(string $domain): string
	{
		return ucfirst($domain);
	}

}
