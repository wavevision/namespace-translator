<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Components\OtherComponent;

use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\Template;
use Wavevision\NamespaceTranslator\TranslatedComponent;

/**
 * @property Template $template
 */
class OtherComponent extends Control
{

	use TranslatedComponent;

	public function render(): void
	{
		$this->template->render(__DIR__ . '/templates/default.latte');
	}

}
