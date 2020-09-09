<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Models\Translated\Translations;

use Nette\StaticClass;
use Wavevision\NamespaceTranslator\Resources\Translation;

abstract class OtherTranslation implements Translation
{

	use StaticClass;

	public const MESSAGE = 'message';

	public const NESTED = 'nested';

}
