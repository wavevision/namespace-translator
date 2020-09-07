<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer\Import;

use Nette\SmartObject;
use org\bovigo\vfs\vfsStream;
use Wavevision\NamespaceTranslator\Transfer\Import\InjectImporter;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;
use Wavevision\Utils\Path;

class ImporterTest extends DIContainerTestCase
{

	use SmartObject;
	use InjectImporter;

	public function testImportCsv(): void
	{
		$root = vfsStream::setup('r');
		vfsStream::copyFromFileSystem(__DIR__ . '/../../App', $root);
		$this->importer->importCsv(__DIR__ . '/export.csv', $root->url());
		$files = ['Cs', 'En', 'PrefixedCs', 'PrefixedEn', 'OneCs'];
		foreach ($files as $file) {
			$this->checkFile($file);
		}
	}

	private function checkFile(string $file): void
	{
		$this->assertFileEquals(
			Path::join(__DIR__, 'expected', $file . '.expected'),
			vfsStream::url(Path::join('r/Models/Translated/Translations', $file . '.php'))
		);
	}

}
