<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Nette\Application\UI\Template;
use Wavevision\Utils\Arrays;
use Wavevision\Utils\Objects;

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
		$prop = 'translator';
		Arrays::toObject([$prop => $this->translator], $template);
		Objects::set($template, $prop, $this->translator);
		return $template;
	}

}
