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
	 * @param array<mixed> $data
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

	/**
	 * @return array<mixed>
	 */
	public function getData(): array
	{
		return $this->data;
	}





}
