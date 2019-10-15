<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Export;

use Nette\InvalidStateException;
use Nette\SmartObject;

class Export
{

	use SmartObject;

	/**
	 * @var resource
	 */
	private $file;

	public function close(): void
	{
		fclose($this->file);
	}

	public function open(string $file): void
	{
		$resource = fopen($file, 'w');
		if (!$resource) {
			throw new InvalidStateException("Unable to open export file '$file'.");
		}
		$this->file = $resource;
	}

	/**
	 * @param mixed[] $fields
	 */
	public function put(array $fields): void
	{
		fputcsv($this->file, $fields);
	}

}
