<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Presenters;

use Nette\Application\UI\Presenter;
use Nette\Bridges\ApplicationLatte\DefaultTemplate;
use Wavevision\NamespaceTranslator\TranslatedComponent;

/**
 * @property DefaultTemplate $template
 */
abstract class BasePresenter extends Presenter
{

	use TranslatedComponent;

	/**
	 * @persistent
	 */
	public string $locale;

	protected function startup(): void
	{
		parent::startup();
		$this->translator->getTranslator()->setLocale($this->locale);
	}

}
