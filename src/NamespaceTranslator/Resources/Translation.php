<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Resources;

use Nette\StaticClass;

abstract class Translation
{

	use StaticClass;

	/**
	 * @return mixed[]
	 */
	abstract public static function define(): array;

}
