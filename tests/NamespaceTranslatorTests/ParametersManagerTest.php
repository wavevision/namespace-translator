<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests;

use PHPUnit\Framework\TestCase;
use Wavevision\NamespaceTranslator\ParametersManager;

class ParametersManagerTest extends TestCase
{

	public function testParameters(): void
	{
		$pm = new ParametersManager([''], ['']);
		$this->assertEquals([''], $pm->getLoaders());
	}

}
