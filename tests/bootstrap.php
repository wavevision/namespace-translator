<?php declare (strict_types = 1);

use Nette\Configurator;
use Wavevision\NetteTests\Configuration;

require __DIR__ . '/../vendor/autoload.php';
Configuration::setup(
	function (): Configurator {
		$configurator = new Configurator();
		$appDir = __DIR__ . '/NamespaceTranslatorTests/App';
		$tempDir = __DIR__ . '/../temp';
		$configurator->addConfig($appDir . '/config.neon')
			->addParameters(['appDir' => $appDir, 'wwwDir' => $tempDir])
			->setTempDirectory($tempDir);
		return $configurator;
	}
);
