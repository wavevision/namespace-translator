<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Nette\Bridges\ApplicationLatte\Template;

/**
 * @property-read Template $template
 */
trait TranslatedPresenter
{

	use NamespaceTranslator;

	protected function startup(): void
	{
		parent::startup();
		$this->template->setTranslator($this->translator);
	}

}
