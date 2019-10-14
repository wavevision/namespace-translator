<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Nette\InvalidStateException;
use Nette\Neon\Neon;
use Nette\SmartObject;
use Nette\Utils\FileSystem;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\MessageCatalogue;

class ResourceLoader
{

	use SmartObject;

	/**
	 * @var ArrayLoader
	 */
	private $arrayLoader;

	public function __construct()
	{
		$this->arrayLoader = new ArrayLoader();
	}

	public function load(string $resource, string $domain): MessageCatalogue
	{
		$messages = Neon::decode(FileSystem::read($resource)) ?: [];
		[$locale, $prefix] = $this->getLocalePrefixPair($resource);
		if ($locale === null) {
			throw new InvalidStateException("Unable to detect locale for '$resource'.");
		}
		if ($prefix !== null) {
			$messages = [$prefix => $messages];
		}
		$catalogue = $this->arrayLoader->load($messages, $locale, $domain);
		$catalogue->addResource(new FileResource($resource));
		return $catalogue;
	}

	/**
	 * $resource [prefix.]<locale>.neon
	 * @param string $resource
	 * @return array<string|null>
	 */
	private function getLocalePrefixPair(string $resource): array
	{
		$suffix = DomainManager::DOMAIN_DELIMITER . ResourceManager::FORMAT;
		$parts = explode(DomainManager::DOMAIN_DELIMITER, basename($resource, $suffix));
		return [array_pop($parts), array_pop($parts)];
	}

}
