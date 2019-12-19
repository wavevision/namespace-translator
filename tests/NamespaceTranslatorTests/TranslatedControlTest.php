<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests;

use Wavevision\NamespaceTranslatorTests\App\Presenters\OtherPresenter;
use Wavevision\NetteTests\Runners\PresenterRequest;
use Wavevision\NetteTests\TestCases\PresenterTestCase;

class TranslatedControlTest extends PresenterTestCase
{

	public function testDefault(): void
	{
		$this->assertEquals(
			"Titulek presenteru\nBla!\nCelkem 5 kusů\ncs\nZpráva\nDalší zpráva\nundefinedMessage\n",
			$this->getResponse()
		);
		$this->assertEquals(
			"Presenter title\nBla!\nCelkem 5 kusů\nen\nMessage\nOther message\nundefinedMessage\n",
			$this->getResponse(OtherPresenter::DEFAULT_ACTION, 'en')
		);
	}

	public function testNext(): void
	{
		$this->assertEquals("Some text\nSome text", $this->getResponse('next'));
	}

	private function getResponse(string $action = OtherPresenter::DEFAULT_ACTION, string $locale = 'cs'): string
	{
		return $this->extractTextResponseContent(
			$this->runPresenter(
				new PresenterRequest(OtherPresenter::class, $action, ['locale' => $locale])
			)
		);
	}

}
