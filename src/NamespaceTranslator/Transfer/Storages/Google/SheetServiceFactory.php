<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Storages\Google;

use Google_Client;
use Google_Service_Sheets;
use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;

/**
 * @DIService(generateInject=true)
 */
class SheetServiceFactory
{

	use SmartObject;

	public function create(Config $config): Google_Service_Sheets
	{
		return new Google_Service_Sheets($this->client($config));
	}

	private function client(Config $config): Google_Client
	{
		$client = new Google_Client();
		$client->setApplicationName('42');
		$client->setScopes(Google_Service_Sheets::SPREADSHEETS);
		$client->setAuthConfig($config->getCredentials());
		$client->setAccessType('offline');
		return $client;
	}

}
