<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Presenters;

use Nette\Application\UI\Presenter;
use Wavevision\NamespaceTranslator\TranslatedComponent;

abstract class BasePresenter extends Presenter
{

	use TranslatedComponent;

	/**
	 * @persistent
	 * @var string
	 */
	public $locale;

	protected function startup(): void
	{
		parent::startup();
		$this->translator->getTranslator()->setLocale($this->locale);
	}

}
