<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer\Storages\Csv;

use Nette\SmartObject;
use org\bovigo\vfs\vfsStream;
use Wavevision\NamespaceTranslator\Transfer\Storages\Csv\InjectCsvWritter;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class CsvWritterTest extends DIContainerTestCase
{

	use SmartObject;
	use InjectCsvWritter;

	public function testWrite(): void
	{
		vfsStream::setup('r');
		$file = vfsStream::url('r/f.csv');
		$this->csvWritter->write(
			$file,
			[['one', 'two']]
		);
		$this->assertEquals(file_get_contents($file), "one,two\n");
	}

}
