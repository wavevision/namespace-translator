<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export;

use Nette\SmartObject;

class FileSet
{

	use SmartObject;

	private array $translations;

	private string $file;

	public function __construct(array $translations, string $file)
	{
		$this->translations = $translations;
		$this->file = $file;
	}

	public function getTranslations(): array
	{
		return $this->translations;
	}

	public function getFile(): string
	{
		return $this->file;
	}






}
