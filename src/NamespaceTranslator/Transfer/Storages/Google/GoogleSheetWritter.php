<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Storages\Google;

use Google_Service_Sheets;
use Google_Service_Sheets_BatchUpdateSpreadsheetRequest;
use Google_Service_Sheets_SheetProperties;
use Google_Service_Sheets_ValueRange;
use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use function array_column;
use function count;

/**
 * @codeCoverageIgnore
 * @DIService(generateInject=true)
 */
class GoogleSheetWritter
{

	use InjectRangeFactory;
	use InjectSheetServiceFactory;
	use SmartObject;

	/**
	 * @param array<mixed> $data
	 */
	public function write(Config $config, array $data): void
	{
		$service = $this->sheetServiceFactory->create($config);
		$this->createTabIfMissing($service, $config);
		$service->spreadsheets_values->update(
			$config->getSheetId(),
			$this->rangeFactory->create($config->getTabName(), count($data[0])),
			new Google_Service_Sheets_ValueRange(
				[
					'values' => $data,
				]
			),
			[
				'valueInputOption' => 'USER_ENTERED',
			]
		);
	}

	private function createTabIfMissing(Google_Service_Sheets $service, Config $config): void
	{
		$sheetInfo = $service->spreadsheets->get($config->getSheetId());
		$properties = array_column($sheetInfo['sheets'], 'properties');
		/** @var Google_Service_Sheets_SheetProperties $property */
		foreach ($properties as $property) {
			if ($property->getTitle() === $config->getTabName()) {
				return;
			}
		}
		$body = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest(
			[
				'requests' => [
					'addSheet' => [
						'properties' => [
							'title' => $config->getTabName(),
						],
					],
				],
			]
		);
		$service->spreadsheets->batchUpdate($config->getSheetId(), $body);
	}

}
