<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Contributte\Translation\Translator as ContributteTranslator;
use Contributte\Translation\Wrappers\Message;
use Contributte\Translation\Wrappers\NotTranslate;
use Nette\Localization\ITranslator;
use Nette\SmartObject;

class Translator implements ITranslator
{

	use SmartObject;

	private ?string $domain;

	private ContributteTranslator $translator;

	public function __construct(ContributteTranslator $translator)
	{
		$this->domain = null;
		$this->translator = $translator;
	}

	/**
	 * @param Message|NotTranslate|string $message
	 * @param mixed ...$args
	 */
	public function translate($message, ...$args): string
	{
		if ($message instanceof NotTranslate) {
			return $message->message;
		}
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

	public function getTranslator(): ContributteTranslator
	{
		return $this->translator;
	}

	/**
	 * @param Message|string $message
	 */
	private function getPureMessage($message): string
	{
		if ($message instanceof Message) {
			return $message->message;
		}
		return $message;
	}

	/**
	 * @param Message|string $message
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
