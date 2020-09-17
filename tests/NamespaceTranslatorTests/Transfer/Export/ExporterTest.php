<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer\Export;

use Nette\SmartObject;
use Symfony\Component\Console\Output\BufferedOutput;
use Wavevision\NamespaceTranslator\Transfer\Export\InjectExporter;
use Wavevision\NamespaceTranslator\Transfer\Export\Writters\Csv;
use Wavevision\NamespaceTranslator\Transfer\Export\Writters\GoogleSheet;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class ExporterTest extends DIContainerTestCase
{

	use SmartObject;
	use InjectExporter;

	public function test(): void
	{
		$output = new BufferedOutput();
		$csv = $this->createMock(Csv::class);
		$csv->expects($this->once())->method('write');
		$this->exporter->injectCsv($csv);
		$google = $this->createMock(GoogleSheet::class);
		$google->expects($this->once())->method('write');
		$this->exporter->injectGoogleSheet($google);
		$this->exporter->export($output);
		$this->assertStringStartsWith('Exporting', $output->fetch());
	}

}
