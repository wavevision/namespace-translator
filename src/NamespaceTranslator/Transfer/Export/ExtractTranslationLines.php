<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Export;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;

/**
 * @DIService(generateInject=true)
 */
class ExtractTranslationLines
{

	use InjectConvertToLines;
	use InjectExtractTranslations;
	use SmartObject;

	/**
	 * @return array<array<string>>
	 */
	public function process(string $directory): array
	{
		$translations = $this->extractTranslations->process($directory);
		$translations->sort(
			fn(FileSet $a, FileSet $b): int => $a->getFile() <=> $b->getFile()
		);
		return $this->convertToLines->process($translations);
	}

}
