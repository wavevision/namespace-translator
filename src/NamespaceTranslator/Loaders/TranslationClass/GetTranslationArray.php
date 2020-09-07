<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use Nette\Utils\FileSystem;
use PhpParser\Node\Expr\Array_;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use Wavevision\DIServiceAnnotation\DIService;

/**
 * @DIService(generateInject=true)
 */
class GetTranslationArray
{

	use SmartObject;

	public function process(string $resource): Array_
	{
		$parser = (new ParserFactory())->create(ParserFactory::ONLY_PHP7);
		$parsedFile = $parser->parse(FileSystem::read($resource));
		$traverser = new NodeTraverser();
		$arrayExtractor = new ArrayExtractor();
		$traverser->addVisitor($arrayExtractor);
		$traverser->traverse($parsedFile);
		return $arrayExtractor->getArray();
	}

}