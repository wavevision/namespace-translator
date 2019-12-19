<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Resources;

use Nette\SmartObject;

class Messages
{

	use SmartObject;

	private string $locale;

	/**
	 * @var mixed[]
	 */
	private array $messages;

	private ?string $prefix;

	/**
	 * @param mixed[] $messages
	 */
	public function __construct(array $messages, string $locale, ?string $prefix = null)
	{
		$this->locale = $locale;
		$this->prefix = $prefix;
		if ($this->getPrefix() !== null) {
			$this->messages = [$this->prefix => $messages];
		} else {
			$this->messages = $messages;
		}
	}

	public function getLocale(): string
	{
		return $this->locale;
	}

	/**
	 * @return mixed[]
	 */
	public function getMessages(): array
	{
		return $this->messages;
	}

	public function getPrefix(): ?string
	{
		return $this->prefix;
	}

}
