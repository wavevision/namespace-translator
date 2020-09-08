<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Storages\Google;

use Nette\SmartObject;

class Sheet
{

	use SmartObject;

	private string $name;

	/**
	 * @var array<mixed>
	 */
	private array $data;

	/**
	 * @param array<mixed>
	 */
	public function __construct(string $name, array $data)
	{
		$this->name = $name;
		$this->data = $data;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getData(): array
	{
		return $this->data;
	}





}