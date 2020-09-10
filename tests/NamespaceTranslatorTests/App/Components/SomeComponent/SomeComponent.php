<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Components\SomeComponent;

use Contributte\Translation\Wrappers\Message;
use Contributte\Translation\Wrappers\NotTranslate;
use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\Template;
use Wavevision\NamespaceTranslator\TranslatedComponent;

/**
 * @property Template $template
 */
class SomeComponent extends Control
{

	use TranslatedComponent;

	public function render(): void
	{
		$this->template->setParameters(
			[
				'no' => $this->translator->translate(new NotTranslate('Bla!')),
				'count' => $this->translator->translate(new Message('app.messageWithCount', 5)),
				'locale' => $this->translator->getTranslator()->getLocale(),
				'message' => $this->translator->translate('message'),
			]
		);
		$this->template->render(__DIR__ . '/templates/default.latte');
	}

}
