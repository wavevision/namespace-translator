<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Storages\Google;

use Nette\SmartObject;

class Config
{

	use SmartObject;

	private string $credentials;

	private string $sheetId;

	private string $tabName;

	public function __construct(string $credentials, string $sheetId, string $tabName)
	{
		$this->credentials = $credentials;
		$this->sheetId = $sheetId;
		$this->tabName = $tabName;
	}

	public function getCredentials(): string
	{
		return $this->credentials;
	}

	public function getSheetId(): string
	{
		return $this->sheetId;
	}

	public function getTabName(): string
	{
		return $this->tabName;
	}

}
