<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer\Import;

use Nette\SmartObject;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;
use Wavevision\NamespaceTranslator\Transfer\Import\InjectConvertFromLines;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class ConvertFromLinesTest extends DIContainerTestCase
{

	use SmartObject;
	use InjectConvertFromLines;

	public function testMissingHeader(): void
	{
		$this->expectException(InvalidState::class);
		$this->expectExceptionMessage('Missing header line.');
		$this->convertFromLines->process([]);
	}

	public function testCorruptedHeader(): void
	{
		$this->expectException(InvalidState::class);
		$this->expectExceptionMessage('Header is corrupted');
		$this->convertFromLines->process([[]]);
	}

}