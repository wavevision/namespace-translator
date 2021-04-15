<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Nette\Application\UI\Template;

trait TranslatedComponent
{

	use NamespaceTranslator;

	protected function createTemplate(): Template
	{
		return $this->setTemplateTranslator(parent::createTemplate());
	}

}
