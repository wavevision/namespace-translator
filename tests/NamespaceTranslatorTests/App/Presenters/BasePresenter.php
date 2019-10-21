<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Presenters;

use Nette\Application\UI\Presenter;
use Wavevision\NamespaceTranslator\NamespaceTranslator;

abstract class BasePresenter extends Presenter
{

	use NamespaceTranslator;

	/**
	 * @persistent
	 * @var string
	 */
	public $locale;

	protected function startup(): void
	{
		parent::startup();
		$this->translator->getTranslator()->setLocale($this->locale);
		$this->template->setTranslator($this->translator);
	}

}
