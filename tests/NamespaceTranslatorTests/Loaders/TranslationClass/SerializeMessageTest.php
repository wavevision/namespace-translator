<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Loaders\TranslationClass;

use Nette\SmartObject;
use PhpParser\Node\Expr;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Loaders\TranslationClass\InjectSerializeMessage;
use Wavevision\NamespaceTranslatorTests\Helpers;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class SerializeMessageTest extends DIContainerTestCase
{

	use SmartObject;
	use InjectSerializeMessage;

	public function testSerialize(): void
	{
		$this->assertEquals(
			'Hello there {c:self-NAME}!',
			$this->serializeMessage->serialize($this->expr("Message::create('Hello there %s!', self::NAME)"))
		);
	}

	public function testSerializeInvalidArgs(): void
	{
		$this->expectException(InvalidState::class);
		$this->serializeMessage->serialize($this->expr("Message::create('Hello there %s!')"));
	}

	public function testSerializeInvalidClass(): void
	{
		$this->expectException(InvalidState::class);
		$this->serializeMessage->serialize($this->expr("Hello::create('Hello there %s!', self::NAME)"));
	}

	public function testSerializeInvalidFunction(): void
	{
		$this->expectException(InvalidState::class);
		$this->serializeMessage->serialize($this->expr("Message::there('Hello there %s!', self::NAME)"));
	}

	public function testSerializeError(): void
	{
		$this->expectException(InvalidState::class);
		$this->serializeMessage->serialize($this->expr("''.''"));
	}

	public function testSerializeMessageNotString(): void
	{
		$this->expectException(InvalidState::class);
		$this->serializeMessage->serialize($this->expr("Message::create(1, self::NAME)"));
	}

	public function testSerializeArgNotConst(): void
	{
		$this->expectException(InvalidState::class);
		$this->serializeMessage->serialize($this->expr("Message::create('test', 'asd')"));
	}

	public function testDeserialize(): void
	{
		$expr = $this->serializeMessage->deserialize('Hello % %s there {c:self-NAME} {c:A-B_X}!');
		$this->assertEquals(
			"Message::create('Hello %% %%s there %s %s!', self::NAME, A::B_X)",
			Helpers::exprToString($expr)
		);
	}

	public function testDeserializeError1(): void
	{
		$this->assertNull($this->serializeMessage->deserialize('Hello there c:self-NAME}!'));
	}

	public function testDeserializeError2(): void
	{
		$this->assertNull($this->serializeMessage->deserialize(''));
	}

	private function expr(string $expr): Expr
	{
		return Helpers::stringToExpr($expr);
	}

}
