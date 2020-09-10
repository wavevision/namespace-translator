<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer\Export;

use Nette\SmartObject;
use Symfony\Component\Console\Output\BufferedOutput;
use Wavevision\NamespaceTranslator\Transfer\Export\InjectExporter;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class ExporterTest extends DIContainerTestCase
{

	use SmartObject;
	use InjectExporter;

	public function test(): void
	{
		$output = new BufferedOutput();
		$this->exporter->export($output);
		$this->assertStringStartsWith('Exporting', $output->fetch());
	}

}
