<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Loaders\TranslationClass;

use PHPUnit\Framework\TestCase;
use Wavevision\NamespaceTranslatorTests\App\Models\Translated\Translations\Cs;
use Wavevision\NamespaceTranslatorTests\App\Models\Translated\Translations\OneCs;

class MessageTest extends TestCase
{

	public function test(): void
	{
		$this->assertEquals('Ahoj %name%!', OneCs::define()[Cs::HELLO]);
	}

}
