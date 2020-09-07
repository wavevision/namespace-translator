<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export;

use Nette\SmartObject;
use Wavevision\Utils\Arrays;

class Translations
{

	use SmartObject;

	/**
	 * @var FileSet[]
	 */
	private array $fileSets = [];

	/**
	 * @param FileSet[] $fileSets
	 */
	public function __construct(array $fileSets = [])
	{
		$this->fileSets = $fileSets;
	}

	public function add(FileSet $fileSet): self
	{
		$this->fileSets[] = $fileSet;
		return $this;
	}

	public function combine(Translations $translations): self
	{
		$this->fileSets = Arrays::appendAll($this->fileSets, $translations->fileSets);
		return $this;
	}

	/**
	 * @return FileSet[]
	 */
	public function getFileSets(): array
	{
		return $this->fileSets;
	}

}
