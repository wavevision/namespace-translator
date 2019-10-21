<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests;

use Wavevision\NamespaceTranslatorTests\App\Presenters\HomePresenter;
use Wavevision\NetteTests\Runners\PresenterRequest;
use Wavevision\NetteTests\TestCases\PresenterTestCase;

class TranslatedPresenterTest extends PresenterTestCase
{

	public function testDefault(): void
	{
		$this->assertEquals(
			"\nSome text\n\nSome message available in all App\Presenters.\n\nTitle: title\nText: text\nPočet: 2 ks\n",
			$this->extractTextResponseContent(
				$this->runPresenter(
					new PresenterRequest(HomePresenter::class, HomePresenter::DEFAULT_ACTION, ['locale' => 'cs'])
				)
			)
		);
	}

}
