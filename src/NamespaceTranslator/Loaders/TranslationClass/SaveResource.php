<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use Nette\Utils\FileSystem;
use PhpParser\Node\Expr\Array_;
use PhpParser\NodeTraverser;
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
	use InjectGetTranslationArray;
	use InjectCreateNodeArray;

	public function save(string $resource, array $content, ?string $referenceResource = null): void
	{
		print_r($content);
		if ($referenceResource === null) {
			$this->resource($resource, $this->createNodeArray->process($content), $resource);
		} else {
			$this->resource(
				$referenceResource,
				$this->createNodeArray->process($content),
				$resource
			);
		}
	}

	private function resource(string $source, Array_ $content, string $output): void
	{
		//https://github.com/nikic/PHP-Parser
		/*$lexer = new Emulative(
			[
				'usedAttributes' => [
					'comments',
					'startLine', 'endLine',
					'startTokenPos', 'endTokenPos',
				],
			]
		);*/
		$parser = (new ParserFactory())->create(ParserFactory::ONLY_PHP7/*, $lexer*/);
		$parsedFile = $parser->parse(FileSystem::read($source));
		/*$oldTokens = $lexer->getTokens();*/
		$traverser = new NodeTraverser();
		//$traverser->addVisitor(new CloningVisitor());
		$nodeVisitor = new NodeVisitor($content);
		/*$nodeVisitor->setClassName($this->getClassFromResource($source));*/
		$traverser->addVisitor($nodeVisitor);
		$newStmts = $traverser->traverse($parsedFile);
	//	$nodeVisitor->getClassIdentifierNode()->name = $this->getClassFromResource($output);
		$printer = new Standard();
		//FileSystem::write($filename, $printer->printFormatPreserving($newStmts, $parsedFile, $oldTokens));
		FileSystem::write($output, $printer->prettyPrintFile($newStmts));
	}

	private function getClassFromResource(string $resource): string
	{
		$parts = explode('\\', $resource);
		return end($parts);
	}

}