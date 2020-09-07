<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use PhpParser\Node\Expr\Array_;
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
	use InjectTraverseFileAst;
	use InjectSaveFileAst;

	public function save(
		string $resource,
		array $content,
		string $fileExtension,
		?string $referenceResource = null
	): void {
		if ($referenceResource === null) {
			$this->resource($resource, $this->createNodeArray->process($content), $fileExtension, $resource);
		} else {
			$this->resource(
				$referenceResource,
				$this->createNodeArray->process($content),
				$fileExtension,
				$resource
			);
		}
	}

	private function resource(string $source, Array_ $content, string $fileExtension, string $output): void
	{
		$returnFinder = new ReturnFinder();
		$ast = $this->traverseFileAst->process(
			$source,
			new ClassNameRewritter(basename($output, $fileExtension)),
			$returnFinder
		);
		$returnFinder->getReturn()->expr = $content;
		$this->saveFileAst->process($output, $ast);
	}

}
