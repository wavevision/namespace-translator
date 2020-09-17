<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Contributte\Translation\Translator;

trait InjectContributteTranslator
{

	private Translator $contributteTranslator;

	/**
	 * @return static
	 */
	public function injectContributteTranslator(Translator $contributteTranslator)
	{
		$this->contributteTranslator = $contributteTranslator;
		return $this;
	}

}
