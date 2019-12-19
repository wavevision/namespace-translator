<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Nette\Bridges\ApplicationLatte\Template;

trait NamespaceTranslator
{

	protected Translator $translator;

	protected TranslatorFactory $translatorFactory;

	public function injectTranslatorFactory(TranslatorFactory $translatorFactory): void
	{
		$this->translatorFactory = $translatorFactory;
		$this->translator = $this->translatorFactory->create(static::class);
	}

	private function setTemplateTranslator(Template $template): Template
	{
		return $template
			->setParameters(['translator' => $this->translator])
			->setTranslator($this->translator);
	}

}
