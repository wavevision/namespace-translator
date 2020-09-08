<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Loaders\TranslationClass;

use Nette\SmartObject;
use PhpParser\Node\Expr;

class SerializeMessage
{

	use SmartObject;

	public function serialize(Expr $expr): string
	{
		return '';
	}

}
