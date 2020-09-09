<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer\Storages\Google;

use Nette\SmartObject;
use Wavevision\NamespaceTranslator\Transfer\Storages\Google\InjectRangeFactory;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class RangeFactoryTest extends DIContainerTestCase
{

	use SmartObject;
	use InjectRangeFactory;

	public function test(): void
	{
		$this->check('A:A', 1);
		$this->check('A:B', 2);
		$this->check('A:C', 3);
		$this->check('A:Z', 26);
		$this->check('A:AA', 27);
		$this->check('A:AB', 28);
		$this->check('A:BA', 53);
	}

	private function check(string $expected, int $count): void
	{
		$this->assertEquals("tab!$expected", $this->rangeFactory->create('tab', $count));
	}

}
