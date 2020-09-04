<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Loaders\TranslationClass;

use Nette\SmartObject;
use PhpParser\PrettyPrinter\Standard;
use Wavevision\NamespaceTranslator\Loaders\TranslationClass\InjectCreateNodeArray;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class CreateNodeArrayTest extends DIContainerTestCase
{

	use SmartObject;
	use InjectCreateNodeArray;

	public function testProcess(): void
	{
		$printer = new Standard();
		$ast = $this->createNodeArray->process(['a' => 'b', 'c:self-TEST' => ['a' => 'a']]);
		$this->assertEquals("array('a' => 'b', self::TEST => array('a' => 'a'))", $printer->prettyPrint([$ast]));
	}

}