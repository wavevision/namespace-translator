<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer\Export\Writters;

use Nette\SmartObject;
use org\bovigo\vfs\vfsStream;
use Wavevision\NamespaceTranslator\Transfer\Export\Writters\InjectCsv;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class CsvTest extends DIContainerTestCase
{

	use SmartObject;
	use InjectCsv;

	public function testExport(): void
	{
		vfsStream::setup('r');
		$exportFile = vfsStream::url('r/export.csv');
		$this->csv->write(__DIR__ . '/../../../App', $exportFile);
		$this->assertFileEquals(__DIR__ . '/export.csv', $exportFile);
	}

}
