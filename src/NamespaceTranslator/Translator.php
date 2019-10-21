<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Kdyby\Translation\ITranslator;
use Kdyby\Translation\Phrase;
use Kdyby\Translation\Translator as KdybyTranslator;
use Nette\SmartObject;

class Translator implements ITranslator
{

	use SmartObject;

	/**
	 * @var string|null
	 */
	private $domain;

	/**
	 * @var KdybyTranslator
	 */
	private $translator;

	public function __construct(KdybyTranslator $translator)
	{
		$this->translator = $translator;
	}

	/**
	 * @param Phrase|string $message
	 * @param mixed ...$args
	 * @return string
	 */
	public function translate($message, ...$args): string
	{
		$count = $args[0] ?? null;
		$parameters = $args[1] ?? [];
		$domain = $args[2] ?? null;
		$locale = $args[3] ?? null;
		if ($this->messageExists($message, $locale)) {
			$domain = $this->getDomain();
		}
		if (is_array($count)) {
			$parameters = $count;
			$count = null;
		}
		return $this->translator->translate($message, $count, $parameters, $domain, $locale);
	}

	public function getDomain(): ?string
	{
		return $this->domain;
	}

	public function setDomain(?string $domain): self
	{
		$this->domain = $domain;
		return $this;
	}

	public function getTranslator(): KdybyTranslator
	{
		return $this->translator;
	}

	/**
	 * @param Phrase|string $message
	 * @return string
	 */
	private function getPureMessage($message): string
	{
		if ($message instanceof Phrase) {
			return $message->message;
		}
		return $message;
	}

	/**
	 * @param Phrase|string $message
	 * @param string|null $locale
	 * @return bool
	 */
	private function messageExists($message, ?string $locale): bool
	{
		if ($this->domain === null) {
			return false;
		}
		return $this->translator
			->getCatalogue($locale)
			->has($this->getPureMessage($message), $this->domain);
	}

}
