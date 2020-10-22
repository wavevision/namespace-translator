<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Contributte\Translation\Translator as ContributteTranslator;
use Contributte\Translation\Wrappers\Message;
use Contributte\Translation\Wrappers\NotTranslate;
use Nette\Localization\ITranslator;
use Nette\SmartObject;
use Wavevision\Utils\Strings;
use function is_array;

class Translator implements ITranslator
{

	use InjectContributteTranslator;
	use SmartObject;

	private ?string $domain = null;

	/**
	 * @param Message|NotTranslate|int|int[]|string|string[] $message
	 * @param mixed ...$parameters
	 */
	public function translate($message, ...$parameters): string
	{
		if ($message instanceof NotTranslate) {
			return $message->message;
		}
		if ($message instanceof Message) {
			$parameters = $message->getParameters();
			$message = $message->getMessage();
		}
		if (is_array($message)) {
			$message = Helpers::key($message);
		}
		$message = Helpers::filter($message);
		$count = $parameters[0] ?? null;
		$params = $parameters[1] ?? [];
		$domain = $parameters[2] ?? null;
		$locale = $parameters[3] ?? null;
		if ($this->messageExists($message, $locale)) {
			$domain = $this->getDomain();
		}
		if (is_array($count)) {
			$params = $count;
			$count = null;
		}
		return $this->contributteTranslator->translate($message, $count, $params, $domain, $locale);
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
		return $this->contributteTranslator;
	}

	public function classPrefixed(string $className): PrefixedTranslator
	{
		return $this->prefixed(Strings::getClassName($className, true));
	}

	public function prefixed(string ...$prefixes): PrefixedTranslator
	{
		return new PrefixedTranslator($this, Helpers::key($prefixes));
	}

	private function messageExists(string $message, ?string $locale): bool
	{
		if ($this->domain === null) {
			return false;
		}
		return $this->contributteTranslator
			->getCatalogue($locale)
			->has($message, $this->domain);
	}

}
