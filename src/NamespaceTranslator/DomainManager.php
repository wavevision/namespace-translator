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
	private $domains = [];

	public function getDomain(string $namespace): string
	{
		if (!isset($this->domains[$namespace])) {
			$namespaces = explode(self::NAMESPACE_DELIMITER, $namespace);
			if (class_exists($namespace)) {
				array_pop($namespaces);
			}
			$this->domains[$namespace] = implode(
				self::DOMAIN_DELIMITER,
				array_map([$this, 'getDomainPart'], $namespaces)
			);
		}
		return $this->domains[$namespace];
	}

	public function getNamespace(string $domain): string
	{
		return implode(
			self::NAMESPACE_DELIMITER,
			array_map([$this, 'getNamespacePart'], explode(self::DOMAIN_DELIMITER, $domain))
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
