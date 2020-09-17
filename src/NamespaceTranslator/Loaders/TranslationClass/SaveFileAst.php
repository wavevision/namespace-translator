<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use Nette\Utils\FileSystem;
use PhpParser\Node;
use PhpParser\PrettyPrinter\Standard;
use Wavevision\DIServiceAnnotation\DIService;

/**
 * @DIService(generateInject=true)
 */
class SaveFileAst
{

	use SmartObject;

	/**
	 * @param Node[] $nodes
	 */
	public function process(string $file, array $nodes): void
	{
		FileSystem::write($file, (new Standard())->prettyPrintFile($nodes));
	}

}
