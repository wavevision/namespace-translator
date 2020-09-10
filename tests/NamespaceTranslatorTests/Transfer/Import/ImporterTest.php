<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer\Import;

use Nette\SmartObject;
use Symfony\Component\Console\Output\BufferedOutput;
use Wavevision\NamespaceTranslator\Transfer\Import\InjectImporter;
use Wavevision\NamespaceTranslator\Transfer\Import\Readers\Csv;
use Wavevision\NamespaceTranslator\Transfer\Import\Readers\GoogleSheet;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class ImporterTest extends DIContainerTestCase
{

	use SmartObject;
	use InjectImporter;

	public function test(): void
	{
		$output = new BufferedOutput();
		$csv = $this->createMock(Csv::class);
		$csv->expects($this->once())->method('read');
		$this->importer->injectCsv($csv);
		$google = $this->createMock(GoogleSheet::class);
		$google->expects($this->once())->method('read');
		$this->importer->injectGoogleSheet($google);
		$this->importer->import($output);
		$this->assertStringStartsWith('Importing', $output->fetch());
	}

}