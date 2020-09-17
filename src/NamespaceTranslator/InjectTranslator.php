<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Contributte;

trait InjectTranslator
{

	private Contributte\Translation\Translator $translator;

	/**
	 * @return static
	 */
	public function injectTranslator(Contributte\Translation\Translator $translator)
	{
		$this->translator = $translator;
		return $this;
	}

}
