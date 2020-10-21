<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use function basename;

/**
 * @DIService(generateInject=true)
 */
class SaveResource
{

	use InjectCreateNodeArray;
	use InjectSaveFileAst;
	use InjectTraverseFileAst;
	use SmartObject;

	/**
	 * @param array<mixed> $content
	 */
	public function save(
		string $resource,
		array $content,
		string $fileExtension,
		?string $referenceResource = null
	): void {
		if ($referenceResource === null) {
			$this->resource($resource, $content, $fileExtension, $resource);
		} else {
			$this->resource($referenceResource, $content, $fileExtension, $resource);
		}
	}

	/**
	 * @param array<mixed> $content
	 */
	private function resource(string $source, array $content, string $fileExtension, string $output): void
	{
		$returnFinder = new ReturnFinder();
		$ast = $this->traverseFileAst->process(
			$source,
			new ClassNameRewritter(basename($output, '.' . $fileExtension)),
			$returnFinder
		);
		$returnFinder->getReturn()->expr = $this->createNodeArray->process($content);
		$this->saveFileAst->process($output, $ast);
	}

}
