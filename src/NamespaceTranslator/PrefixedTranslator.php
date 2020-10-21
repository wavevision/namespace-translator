<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator;

use Contributte\Translation\Wrappers\Message;
use Contributte\Translation\Wrappers\NotTranslate;
use Nette\Localization\ITranslator;
use Nette\SmartObject;
use function is_array;
use function is_int;
use function is_string;

class PrefixedTranslator implements ITranslator
{

	use SmartObject;

	private Translator $translator;

	private string $prefix;

	public function __construct(Translator $translator, string $prefix)
	{
		$this->translator = $translator;
		$this->prefix = $prefix;
	}

	/**
	 * @param Message|NotTranslate|int|int[]|string|string[] $message
	 * @param mixed ...$parameters
	 */
	public function translate($message, ...$parameters): string
	{
		if ($message instanceof Message) {
			$message->setMessage(Helpers::key([$this->prefix, $message->getMessage()]));
		}
		if (is_array($message)) {
			$message = [$this->prefix, ...$message];
		}
		if (is_int($message) || is_string($message)) {
			$message = Helpers::key([$this->prefix, $message]);
		}
		return $this->translator->translate($message, ...$parameters);
	}

}
