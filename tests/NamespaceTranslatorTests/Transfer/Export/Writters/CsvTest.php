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

	public function testWrite(): void
	{
		vfsStream::setup('r');
		$file = vfsStream::url('r/f.csv');
		$this->csv->write(
			$file,
			[['one', 'two']]
		);
		$this->assertEquals(file_get_contents($file), "one,two\n");
	}

}