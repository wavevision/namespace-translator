<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer\Import\Readers;

use Nette\SmartObject;
use org\bovigo\vfs\vfsStream;
use Wavevision\NamespaceTranslator\Transfer\Import\Readers\InjectCsv;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;
use Wavevision\Utils\Path;

class CsvTest extends DIContainerTestCase
{

	use SmartObject;
	use InjectCsv;

	public function testRead(): void
	{
		$root = vfsStream::setup('r');
		vfsStream::copyFromFileSystem(__DIR__ . '/../../../App', $root);
		$this->csv->read(__DIR__ . '/export.csv', $root->url());
		$phpFiles = ['Cs', 'En', 'PrefixedCs', 'PrefixedEn', 'OneCs'];
		foreach ($phpFiles as $file) {
			$this->translated($file);
		}
		$jsonFiles = ['cs', 'en'];
		foreach ($jsonFiles as $file) {
			$this->json($file);
		}
	}

	private function checkFile(string $expected, string $actual): void
	{
		$this->assertFileEquals(
			$expected,
			vfsStream::url($actual)
		);
	}

	private function translated(string $file): void
	{
		$this->checkFile(
			Path::join(__DIR__, 'expected', 'Translated', $file . '.expected'),
			Path::join('r/Models/Translated/Translations', $file . '.php'),
		);
	}

	private function json(string $file): void
	{
		$this->checkFile(
			Path::join(__DIR__, 'expected', 'Json', $file . '.json'),
			Path::join('r/Models/Json/translations', $file . '.json'),
		);
	}

}
