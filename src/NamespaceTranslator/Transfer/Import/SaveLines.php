<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Import;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;

/**
 * @DIService(generateInject=true)
 */
class SaveLines
{

	use InjectConvertFromLines;
	use InjectSaveFileSet;
	use SmartObject;

	/**
	 * @param array<mixed> $lines
	 */
	public function process(string $directory, array $lines): void
	{
		$translations = $this->convertFromLines->process($lines);
		foreach ($translations->getFileSets() as $fileSet) {
			$this->saveFileSet->process($directory, $fileSet);
		}
	}

}
