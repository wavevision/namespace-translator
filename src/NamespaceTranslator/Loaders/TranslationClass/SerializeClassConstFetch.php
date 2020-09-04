<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use PhpParser\Node\Expr\ClassConstFetch;
use Wavevision\DIServiceAnnotation\DIService;

/**
 * @DIService(generateInject=true)
 */
class SerializeClassConstFetch
{

	use SmartObject;

	public function process(ClassConstFetch $classConstFetch): string
	{
		return 'c:' . implode('\\', $classConstFetch->class->parts) . '-' . $classConstFetch->name->name;
	}

}