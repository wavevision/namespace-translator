<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests;

use Wavevision\NamespaceTranslatorTests\App\Presenters\OtherPresenter;
use Wavevision\NetteTests\Runners\PresenterRequest;
use Wavevision\NetteTests\TestCases\PresenterTestCase;

class TranslatedControlTest extends PresenterTestCase
{

	public function testDefault(): void
	{
		$this->assertEquals("Titulek presenteru\ncs\nZpráva\nDalší zpráva", $this->getResponse());
		$this->assertEquals("Presenter title\nen\nMessage\nOther message", $this->getResponse('en'));
	}

	private function getResponse(string $locale = 'cs'): string
	{
		return $this->extractTextResponseContent(
			$this->runPresenter(
				new PresenterRequest(OtherPresenter::class, OtherPresenter::DEFAULT_ACTION, ['locale' => $locale])
			)
		);
	}

}
