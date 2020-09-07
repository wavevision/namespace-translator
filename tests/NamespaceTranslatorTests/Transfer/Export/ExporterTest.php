<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer\Export;

use Nette\SmartObject;
use org\bovigo\vfs\vfsStream;
use Wavevision\NamespaceTranslator\Transfer\Export\InjectExporter;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class ExporterTest extends DIContainerTestCase
{

	use SmartObject;
	use InjectExporter;

	public function testExport(): void
	{
		vfsStream::setup('r');
		$exportFile = vfsStream::url('r/export.csv');
		$this->exporter->exportCsv(__DIR__ . '/../../App', $exportFile);
		$this->assertFileEquals(__DIR__ . '/export.csv', $exportFile);
	}

}
