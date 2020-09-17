<?php declare (strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests\App\Router;

use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;
use Nette\StaticClass;

final class RouterFactory
{

	use StaticClass;

	/**
	 * @return RouteList<Route>
	 */
	public static function createRouter(): RouteList
	{
		$router = new RouteList();
		$router->addRoute('<presenter>/<action>', 'Home:default');
		return $router;
	}

}
