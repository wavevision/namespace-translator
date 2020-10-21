<?php declare(strict_types = 1);

namespace Wavevision\NamespaceTranslatorTests;

use Exception;
use Nette\StaticClass;
use PhpParser\Node\Expr;
use PhpParser\Node\Stmt\Expression;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;
use Wavevision\NamespaceTranslator\Exceptions\InvalidState;

class Helpers
{

	use StaticClass;

	public static function exprToString(?Expr $expr): string
	{
		if ($expr === null) {
			throw new InvalidState('Invalid state.');
		}
		return (new Standard())->prettyPrintExpr($expr);
	}

	public static function stringToExpr(string $string): Expr
	{
		$ast = (new ParserFactory())->create(ParserFactory::ONLY_PHP7)->parse(
			"<?php $string;"
		);
		if (isset($ast[0])) {
			/** @var Expression $expression */
			$expression = $ast[0];
			return $expression->expr;
		}
		throw new Exception('Invalid state.');
	}

}
