<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use Nette\Utils\FileSystem;
use PhpParser\Node;
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

	/**
	 * @return Node[]
	 */
	public function process(string $file, NodeVisitorAbstract ...$visitors): array
	{
		$parser = (new ParserFactory())->create(ParserFactory::ONLY_PHP7);
		/** @var Node\Stmt[] $parsedFile */
		$parsedFile = $parser->parse(FileSystem::read($file));
		$traverser = new NodeTraverser();
		foreach ($visitors as $visitor) {
			$traverser->addVisitor($visitor);
		}
		return $traverser->traverse($parsedFile);
	}

}
