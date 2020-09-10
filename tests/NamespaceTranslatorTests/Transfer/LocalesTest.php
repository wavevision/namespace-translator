<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer;

use Contributte\Translation\Translator;
use Nette\SmartObject;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Transfer\InjectLocales;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class LocalesTest extends DIContainerTestCase
{

	use SmartObject;
	use InjectLocales;

	public function testWhitelistNotSet(): void
	{
		$this->expectException(InvalidState::class);
		$this->expectExceptionMessage('Locale whitelist must be set.');
		$translator = $this->createMock(Translator::class);
		$translator->expects($this->once())->method('getLocalesWhitelist')->willReturn(null);
		$this->locales->injectTranslator($translator);
		$this->locales->optionalLocales();
	}

}