<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslator\Import;

use Nette\InvalidStateException;
use Nette\SmartObject;
use Wavevision\Utils\Strings;

class Import
{

	use SmartObject;

	/**
	 * @var resource
	 */
	private $file;

	/**
	 * @var string
	 */
	private $fileName;

	public function close(): void
	{
		fclose($this->file);
	}

	public function open(string $file): void
	{
		$this->fileName = $file;
		$resource = fopen($this->fileName, 'r');
		if (!$resource) {
			throw new InvalidStateException("Unable to open import file '$file'.");
		}
		$this->file = $resource;
	}

	/**
	 * @return mixed[]|null
	 */
	public function get(): ?array
	{
		$data = fgetcsv($this->file);
		if (is_array($data)) {
			return array_map([$this, 'filterData'], $data);
		}
		return null;
	}

	public function getFileName(): string
	{
		return $this->fileName;
	}

	private function filterData(string $value): ?string
	{
		$value = Strings::trim($value);
		if ($value === '') {
			return null;
		}
		return Strings::autoUtf(Strings::removeBOM($value));
	}

}
