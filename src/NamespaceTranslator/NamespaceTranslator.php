<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator;

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

}
