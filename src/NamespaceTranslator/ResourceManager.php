<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Kdyby\Translation\Translator;
use Nette\SmartObject;
use Nette\Utils\Finder;
use ReflectionClass;
use Symfony\Component\Translation\MessageCatalogue;
use Wavevision\Utils\Path;

class ResourceManager
{

	use SmartObject;

	public const DIR = 'translations';

	public const FORMAT = 'neon';

	/**
	 * @var ResourceLoader
	 */
	private $loader;

	/**
	 * @var string[]
	 */
	private $namespaces = [];

	/**
	 * @var MessageCatalogue[]
	 */
	private $resources = [];

	/**
	 * @var Translator
	 */
	private $translator;

	public function __construct(Translator $translator)
	{
		$this->loader = new ResourceLoader();
		$this->translator = $translator;
	}

	public function findResources(string $namespace): ?Finder
	{
		$reflection = new ReflectionClass($namespace);
		$dir = Path::join(dirname((string)$reflection->getFileName()), self::DIR);
		if (is_dir($dir)) {
			return Finder::findFiles('*.' . self::FORMAT)->in($dir);
		}
		return null;
	}

	public function loadResource(string $resource, string $domain): MessageCatalogue
	{
		if (!isset($this->resources[$resource])) {
			$catalogue = $this->loader->load($resource, $domain);
			$this->translator
				->getCatalogue($catalogue->getLocale())
				->addCatalogue($catalogue);
			$this->resources[$resource] = $catalogue;
		}
		return $this->resources[$resource];
	}

	public function getNamespaceLoaded(string $namespace): bool
	{
		return in_array($namespace, $this->namespaces);
	}

	public function setNamespaceLoaded(string $namespace): void
	{
		$this->namespaces[] = $namespace;
	}

}
