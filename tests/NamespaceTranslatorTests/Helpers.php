<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests;

use Nette\StaticClass;
use PhpParser\Node\Expr;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;

class Helpers
{

	use StaticClass;

	public static function exprToString(Expr $expr): string
	{
		return (new Standard())->prettyPrintExpr($expr);
	}

	public static function stringToExpr(string $string): Expr
	{
		$ast = (new ParserFactory())->create(ParserFactory::ONLY_PHP7)->parse(
			"<?php $string;"
		);
		return $ast[0]->expr;
	}

}