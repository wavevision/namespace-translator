<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Models\Translated\Translations;

use Nette\StaticClass;

abstract class Translation implements \Wavevision\NamespaceTranslator\Resources\Translation
{

	use StaticClass;

	public const NAME = 'name';

	public const HELLO = 'hello';

	public const SOME_KEY = 'someKey';

	public const SUB = 'sub';

	public const NESTED = 'nested';

	public const BOOK = 'book';

}
