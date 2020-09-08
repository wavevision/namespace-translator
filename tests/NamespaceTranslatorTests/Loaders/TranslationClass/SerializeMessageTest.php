<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Loaders\TranslationClass;

use Nette\SmartObject;
use PhpParser\Node\Expr;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;
use Wavevision\NamespaceTranslator\Loaders\TranslationClass\InjectSerializeMessage;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class SerializeMessageTest extends DIContainerTestCase
{

	use SmartObject;
	use InjectSerializeMessage;

	public function testSerialize(): void
	{
		$this->assertEquals('Hello there {c:self-NAME}!', $this->serializeMessage->serialize($this->expr()));
	}


	public function testDeserialize(): void
	{
		$expr = $this->serializeMessage->deserialize('Hello there {c:self-NAME} {c:A-B}!');
		$this->assertEquals("Message::create('Hello there %s %s!', self::NAME, A::B)", (new Standard())->prettyPrintExpr($expr));
	}

	private function expr(): Expr
	{
		$ast = (new ParserFactory())->create(ParserFactory::ONLY_PHP7)->parse(
			"<?php Message::create('Hello there %s!', self::NAME);"
		);
		return $ast[0]->expr;
	}

}