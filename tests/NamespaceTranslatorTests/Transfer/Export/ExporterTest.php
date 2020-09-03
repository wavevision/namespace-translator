<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer\Export;

use Nette\SmartObject;
use Wavevision\NamespaceTranslator\Transfer\Export\InjectExporter;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class ExporterTest extends DIContainerTestCase
{

	use SmartObject;
	use InjectExporter;

	public function testExport(): void
	{
		$export = __DIR__ . '/export.csv';
		@unlink($export);
		$this->exporter->export(__DIR__ . '/../../App', $export);
		$this->assertFileExists($export);
	}

}