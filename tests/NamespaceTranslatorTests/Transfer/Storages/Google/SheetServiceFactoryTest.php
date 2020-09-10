<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Transfer\Storages\Google;

use Google_Service_Sheets;
use Nette\SmartObject;
use Wavevision\NamespaceTranslator\Transfer\Storages\Google\Config;
use Wavevision\NamespaceTranslator\Transfer\Storages\Google\InjectSheetServiceFactory;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;

class SheetServiceFactoryTest extends DIContainerTestCase
{

	use SmartObject;
	use InjectSheetServiceFactory;

	public function test(): void
	{
		$this->assertInstanceOf(
			Google_Service_Sheets::class,
			$this->sheetServiceFactory->create(new Config(__DIR__ . '/credentials.json', '', ''))
		);
	}

}