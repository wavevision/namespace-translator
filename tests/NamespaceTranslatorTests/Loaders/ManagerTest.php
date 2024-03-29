<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\Loaders;

use PHPUnit\Framework\TestCase;
use Wavevision\NamespaceTranslator\Exceptions\InvalidArgument;
use Wavevision\NamespaceTranslator\Loaders\Manager;
use Wavevision\NamespaceTranslator\Loaders\Neon;

class ManagerTest extends TestCase
{

	public function testGetFormatLoaderThrowsInvalidArgument(): void
	{
		$this->expectException(InvalidArgument::class);
		(new Manager())->getFormatLoader('');
	}

	public function testGetFormatLoaderByExtensionThrowsInvalidArgument(): void
	{
		$this->expectException(InvalidArgument::class);
		(new Manager())->getFormatLoaderByExtension('');
	}

	public function testGetLoaders(): void
	{
		$manager = new Manager();
		$loaders = [Neon::FORMAT => new Neon()];
		$manager->addLoader(Neon::FORMAT, $loaders[Neon::FORMAT]);
		$this->assertEquals($loaders, $manager->getLoaders());
	}

}
