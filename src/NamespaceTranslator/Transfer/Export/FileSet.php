<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export;

use Nette\SmartObject;

class FileSet
{

	use SmartObject;

	private array $translations;

	private string $file;

	private string $format;

	public function __construct(array $translations, string $file, string $format)
	{
		$this->translations = $translations;
		$this->file = $file;
		$this->format = $format;
	}

	public function getTranslations(): array
	{
		return $this->translations;
	}

	public function getFile(): string
	{
		return $this->file;
	}

	public function getFormat(): string
	{
		return $this->format;
	}



}
