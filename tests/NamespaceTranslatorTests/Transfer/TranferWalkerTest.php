<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer;

use PHPUnit\Framework\TestCase;
use Wavevision\NamespaceTranslator\DI\Extension;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Transfer\TransferWalker;

class TranferWalkerTest extends TestCase
{

	public function test(): void
	{
		$called = false;
		$fail = function () use (&$called): void {
			$called = true;
		};
		(new TransferWalker([Extension::GOOGLE => null, Extension::CSV => null]))->execute(
			$fail,
			$fail
		);
		$this->assertFalse($called);
	}

	public function testThrowErrorOnMissingConfiguration(): void
	{
		$this->expectException(InvalidState::class);
		$this->expectExceptionMessage("Export/Import not configured. Property 'transfer' is not set.");
		(new TransferWalker(null))->execute(
			function (): void {
			},
			function (): void {
			}
		);
	}

}
