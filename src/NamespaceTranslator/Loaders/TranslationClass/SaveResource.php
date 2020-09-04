<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use Nette\Utils\FileSystem;
use PhpParser\Lexer\Emulative;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\CloningVisitor;
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

	public function save(string $resource, array $content): void
	{
		//todo pass source class
		//https://github.com/nikic/PHP-Parser
		$lexer = new Emulative([
			'usedAttributes' => [
				'comments',
				'startLine', 'endLine',
				'startTokenPos', 'endTokenPos',
			],
		]);
		$parser = (new ParserFactory())->create(ParserFactory::ONLY_PHP7, $lexer);
		$parsedFile = $parser->parse(FileSystem::read($resource));
		$oldTokens = $lexer->getTokens();
		$traverser = new NodeTraverser();
		$traverser->addVisitor(new CloningVisitor());
		$nodeVisitor = new NodeVisitor();
		$traverser->addVisitor($nodeVisitor);
		$newStmts = $traverser->traverse($parsedFile);
		$this->rewriteArray->process($nodeVisitor->getArray(), $content);
		$printer = new Standard();
		FileSystem::write($resource, $printer->printFormatPreserving($newStmts, $parsedFile, $oldTokens));
	}

}