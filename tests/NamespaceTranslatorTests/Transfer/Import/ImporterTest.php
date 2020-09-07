<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer\Import;

use Nette\SmartObject;
use Wavevision\NamespaceTranslator\Transfer\Import\InjectImporter;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class ImporterTest extends DIContainerTestCase
{

	use SmartObject;
	use InjectImporter;

	public function testImportCsv(): void
	{
		$this->importer->importCsv(__DIR__ . '/export.csv', __DIR__ . '/../../App');
		$this->assertEquals(1, 2);
	}

}
