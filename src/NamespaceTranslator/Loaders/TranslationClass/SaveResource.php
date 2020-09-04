<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use Nette\Utils\FileSystem;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;
use Wavevision\DIServiceAnnotation\DIService;

/**
 * @DIService(generateInject=true)
 */
class SaveResource
{

	use SmartObject;
	use InjectRewriteArray;
	use InjectNodeVisitor;

	public function save(string $resource, array $content): void
	{
		//todo pass source class
		//https://github.com/nikic/PHP-Parser
		$parser = (new ParserFactory())->create(ParserFactory::ONLY_PHP7);
		$parsedFile = $parser->parse(FileSystem::read($resource));
		$traverser = new NodeTraverser();
		$traverser->addVisitor(new NameResolver());
		$traverser->addVisitor($this->nodeVisitor->setContent($content));
		$traverser->traverse($parsedFile);
		$printer = new Standard();
		//todo update class nodes
		$x = $printer->prettyPrint($parsedFile);
		var_dump($x);
	}

}