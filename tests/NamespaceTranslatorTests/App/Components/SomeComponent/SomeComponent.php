<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Components\SomeComponent;

use Contributte\Translation\Wrappers\Message;
use Contributte\Translation\Wrappers\NotTranslate;
use Nette\Application\UI\Control;
use Wavevision\NamespaceTranslator\TranslatedComponent;

class SomeComponent extends Control
{

	use TranslatedComponent;

	public function render(): void
	{
		$this->template->no = $this->translator->translate(new NotTranslate('Bla!'));
		$this->template->count = $this->translator->translate(new Message('app.messageWithCount', 5));
		$this->template->locale = $this->translator->getTranslator()->getLocale();
		$this->template->message = $this->translator->translate('message');
		$this->template->render(__DIR__ . '/templates/default.latte');
	}

}
