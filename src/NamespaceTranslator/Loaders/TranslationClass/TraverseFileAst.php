<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use Nette\Utils\FileSystem;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\ParserFactory;
use Wavevision\DIServiceAnnotation\DIService;

/**
 * @DIService(generateInject=true)
 */
class TraverseFileAst
{

	use SmartObject;

	public function process(string $file, NodeVisitorAbstract ...$visitors): array
	{
		$parser = (new ParserFactory())->create(ParserFactory::ONLY_PHP7);
		$parsedFile = $parser->parse(FileSystem::read($file));
		$traverser = new NodeTraverser();
		foreach ($visitors as $visitor) {
			$traverser->addVisitor($visitor);
		}
		$traverser->traverse($parsedFile);
		return $parsedFile;
	}

}