<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Nette\Application\UI\ITemplate;
use Nette\Bridges\ApplicationLatte\Template;

trait TranslatedComponent
{

	use NamespaceTranslator;

	protected function createTemplate(): ITemplate
	{
		/** @var Template $template */
		$template = parent::createTemplate();
		$template->setParameters(['translator' => $this->translator]);
		$template->setTranslator($this->translator);
		return $template;
	}

}
