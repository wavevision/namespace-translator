<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Storages\Google;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;
use Wavevision\NamespaceTranslator\Transfer\Export\InjectConvertToLines;
use function count;

/**
 * @codeCoverageIgnore
 * @DIService(generateInject=true)
 */
class GoogleSheetReader
{

	use SmartObject;
	use InjectSheetServiceFactory;
	use InjectRangeFactory;
	use InjectConvertToLines;

	/**
	 * @return array<mixed>
	 */
	public function read(Config $config): array
	{
		$service = $this->sheetServiceFactory->create($config);
		$result = $service->spreadsheets_values->get(
			$config->getSheetId(),
			$this->rangeFactory->create($config->getTabName(), count($this->convertToLines->createHeader()))
		);
		return $result->getValues();
	}

}
