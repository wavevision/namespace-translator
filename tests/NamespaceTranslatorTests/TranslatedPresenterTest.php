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
			"\nSome text\n\nApp\Presenters.\n\nVítejte\nYou are here!\n2 ks\nMy chceme modele!\nZanořené\n",
			$this->extractTextResponseContent(
				$this->runPresenter(
					new PresenterRequest(HomePresenter::class, HomePresenter::DEFAULT_ACTION, ['locale' => 'cs'])
				)
			)
		);
	}

	public function testDefaultEn(): void
	{
		$this->assertEquals(
			"\nSome text\n\nApp\Presenters.\n\nVítejte\nYou are here!\n2 ks\nWe want modele!\nZanořené\n",
			$this->extractTextResponseContent(
				$this->runPresenter(
					new PresenterRequest(HomePresenter::class, HomePresenter::DEFAULT_ACTION, ['locale' => 'en'])
				)
			)
		);
	}

}
