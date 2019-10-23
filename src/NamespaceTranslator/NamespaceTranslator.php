<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Nette\Bridges\ApplicationLatte\Template;

trait NamespaceTranslator
{

	/**
	 * @var Translator
	 */
	protected $translator;

	/**
	 * @var TranslatorFactory
	 */
	protected $translatorFactory;

	public function injectTranslatorFactory(TranslatorFactory $translatorFactory): void
	{
		$this->translatorFactory = $translatorFactory;
		$this->translator = $this->translatorFactory->create(static::class);
	}

	private function setTemplateTranslator(Template $template): Template
	{
		$template->setParameters(['translator' => $this->translator]);
		$template->setTranslator($this->translator);
		return $template;
	}

}
