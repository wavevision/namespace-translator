<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslator\Transfer\Storages\Google;

use Nette\SmartObject;
use Wavevision\DIServiceAnnotation\DIService;

/**
 * @DIService(generateInject=true)
 */
class RangeFactory
{

	use SmartObject;

	private const BASE = 26;

	public function create(string $tabName, int $count): string
	{
		return $tabName . '!A:' . $this->coordinate($count - 1);
	}

	private function coordinate(int $count): string
	{
		$c = '';
		do {
			$mod = ($count % self::BASE);
			$c = $this->convert($mod) . $c;
			$count = (int)($count / self::BASE) - 1;
		} while ($count >= 0);
		return $c;
	}

	private function convert(int $i): string
	{
		return chr($i + 65);
	}

}
