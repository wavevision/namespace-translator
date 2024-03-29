<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Nette\SmartObject;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\MessageCatalogue;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Loaders\InjectManager;
use Wavevision\NamespaceTranslator\Resources\Messages;
use function basename;
use function pathinfo;

/**
 * @DIService(name="resourceLoader", generateInject=true)
 */
class ResourceLoader
{

	use SmartObject;
	use InjectManager;

	private ArrayLoader $arrayLoader;

	public function __construct()
	{
		$this->arrayLoader = new ArrayLoader();
	}

	public function load(string $resource, string $domain): MessageCatalogue
	{
		$format = $this->getResourceFormat($resource);
		$loader = $this->manager->getFormatLoaderByExtension($format);
		$localePrefixPair = $loader->getLocalePrefixPair($this->getResourceName($resource, $format));
		$messages = new Messages(
			$loader->load($resource),
			$localePrefixPair->getLocale(),
			$localePrefixPair->getPrefix()
		);
		$catalogue = $this->arrayLoader->load($messages->getMessages(), $messages->getLocale(), $domain);
		$catalogue->addResource(new FileResource($resource));
		return $catalogue;
	}

	private function getResourceFormat(string $resource): string
	{
		$info = pathinfo($resource);
		if (isset($info['extension'])) {
			return $info['extension'];
		}
		throw new InvalidState("Unable to detect format for '$resource'.");
	}

	private function getResourceName(string $resource, string $format): string
	{
		$suffix = DomainManager::DOMAIN_DELIMITER . $format;
		return basename($resource, $suffix);
	}

}
