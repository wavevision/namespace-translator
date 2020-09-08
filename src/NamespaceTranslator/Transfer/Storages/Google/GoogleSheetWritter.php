<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Storages\Google;

use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_BatchUpdateSpreadsheetRequest;
use Google_Service_Sheets_SheetProperties;
use Google_Service_Sheets_ValueRange;
use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;

/**
 * @DIService(generateInject=true)
 */
class GoogleSheetWritter
{

	use SmartObject;

	public function write(Config $config, Sheet $sheet): void
	{
		$service = $this->sheets($config);
		$this->createTabIfMissing($service, $config, $sheet->getName());
		$service->spreadsheets_values->update(
			$config->getId(),
			$this->createRange($sheet),
			new Google_Service_Sheets_ValueRange(
				[
					'values' => $sheet->getData(),
				]
			),
			[
				'valueInputOption' => 'USER_ENTERED',
			]
		);
	}

	private function createRange(Sheet $sheet): string
	{
		return $sheet->getName() . '!A:' . chr(count($sheet->getData()[0]) + 65);
	}

	private function createTabIfMissing(Google_Service_Sheets $service, Config $config, string $name): void
	{
		$sheetInfo = $service->spreadsheets->get($config->getId());
		$properties = array_column($sheetInfo['sheets'], 'properties');
		/** @var Google_Service_Sheets_SheetProperties $property */
		foreach ($properties as $property) {
			if ($property->getTitle() === $name) {
				return;
			}
		}
		$body = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest(
			[
				'requests' => [
					'addSheet' => [
						'properties' => [
							'title' => $name,
						],
					],
				],
			]
		);
		$service->spreadsheets->batchUpdate($config->getId(), $body);
	}

	private function client(Config $config): Google_Client
	{
		$client = new Google_Client();
		$client->setApplicationName('flowgate');
		$client->setScopes(Google_Service_Sheets::SPREADSHEETS);
		$client->setAuthConfig($config->getCredentials());
		$client->setAccessType('offline');
		return $client;
	}

	private function sheets(Config $config): Google_Service_Sheets
	{
		return new Google_Service_Sheets($this->client($config));
	}

}
