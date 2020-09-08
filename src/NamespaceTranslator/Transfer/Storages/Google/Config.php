<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Storages\Google;

use Nette\SmartObject;

class Config
{

	use SmartObject;

	private string $credentials;

	private string $id;

	public function __construct(string $credentials, string $id)
	{
		$this->credentials = $credentials;
		$this->id = $id;
	}

	public function getCredentials(): string
	{
		return $this->credentials;
	}

	public function getId(): string
	{
		return $this->id;
	}

}