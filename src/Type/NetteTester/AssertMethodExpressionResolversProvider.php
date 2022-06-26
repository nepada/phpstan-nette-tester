<?php
declare(strict_types = 1);

namespace Nepada\PHPStan\Type\NetteTester;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;
use PhpParser\Node\Expr\BinaryOp\Equal;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Instanceof_;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Type\Constant\ConstantStringType;

final class AssertMethodExpressionResolversProvider
{

    /**
     * @var \Closure[]|NULL
     */
    private static ?array $resolvers = null;

    /**
     * @var \Closure[]|NULL
     */
    private static ?array $typeResolvers = null;

    /**
     * @return \Closure[]
     */
    public static function getResolvers(): array
    {
        if (self::$resolvers === null) {
            self::$resolvers = [
                'null' => fn (Scope $scope, Arg $expr): Expr => new Identical(
                    $expr->value,
                    new ConstFetch(new Name('null')),
                ),
                'notNull' => fn (Scope $scope, Arg $expr): Expr => new NotIdentical(
                    $expr->value,
                    new ConstFetch(new Name('null')),
                ),
                'true' => fn (Scope $scope, Arg $expr): Expr => new Identical(
                    $expr->value,
                    new ConstFetch(new Name('true')),
                ),
                'false' => fn (Scope $scope, Arg $expr): Expr => new Identical(
                    $expr->value,
                    new ConstFetch(new Name('false')),
                ),
                'truthy' => fn (Scope $scope, Arg $expr): Expr => new Equal(
                    $expr->value,
                    new ConstFetch(new Name('true')),
                ),
                'falsey' => fn (Scope $scope, Arg $expr): Expr => new Equal(
                    $expr->value,
                    new ConstFetch(new Name('false')),
                ),
                'nan' => fn (Scope $scope, Arg $value): Expr => new BooleanAnd(
                    new FuncCall(
                        new Name('is_float'),
                        [$value],
                    ),
                    new FuncCall(
                        new Name('is_nan'),
                        [$value],
                    ),
                ),
                'same' => fn (Scope $scope, Arg $value1, Arg $value2): Expr => new Identical(
                    $value1->value,
                    $value2->value,
                ),
                'notSame' => fn (Scope $scope, Arg $value1, Arg $value2): Expr => new NotIdentical(
                    $value1->value,
                    $value2->value,
                ),
                'type' => function (Scope $scope, Arg $typeArg, Arg $valueArg): ?Expr {
                    $type = $scope->getType($typeArg->value);
                    if (! $type instanceof ConstantStringType) {
                        return null;
                    }

                    $typeValue = $type->getValue();
                    $typeResolvers = self::getTypeResolvers();
                    if (array_key_exists($typeValue, $typeResolvers)) {
                        return $typeResolvers[$typeValue]($scope, $valueArg);
                    }

                    return new Instanceof_(
                        $valueArg->value,
                        new Name($typeValue),
                    );
                },
                'count' => fn (Scope $scope, Arg $count, Arg $value): Expr => new BooleanAnd(
                    new BooleanOr(
                        new FuncCall(
                            new Name('is_array'),
                            [$value],
                        ),
                        new Instanceof_(
                            $value->value,
                            new Name(\Countable::class),
                        ),
                    ),
                    new Identical(
                        new FuncCall(
                            new Name('count'),
                            [$value],
                        ),
                        $count->value,
                    ),
                ),
            ];
        }

        return self::$resolvers;
    }

    /**
     * @return \Closure[]
     */
    private static function getTypeResolvers(): array
    {
        if (self::$typeResolvers === null) {
            self::$typeResolvers = [
                'list' => fn (Scope $scope, Arg $value): Expr => new FuncCall(
                    new Name('is_array'),
                    [$value],
                ),
                'array' => fn (Scope $scope, Arg $value): Expr => new FuncCall(
                    new Name('is_array'),
                    [$value],
                ),
                'bool' => fn (Scope $scope, Arg $value): Expr => new FuncCall(
                    new Name('is_bool'),
                    [$value],
                ),
                'callable' => fn (Scope $scope, Arg $value): Expr => new FuncCall(
                    new Name('is_callable'),
                    [$value],
                ),
                'float' => fn (Scope $scope, Arg $value): Expr => new FuncCall(
                    new Name('is_float'),
                    [$value],
                ),
                'int' => fn (Scope $scope, Arg $value): Expr => new FuncCall(
                    new Name('is_int'),
                    [$value],
                ),
                'integer' => fn (Scope $scope, Arg $value): Expr => new FuncCall(
                    new Name('is_int'),
                    [$value],
                ),
                'null' => fn (Scope $scope, Arg $value): Expr => new FuncCall(
                    new Name('is_null'),
                    [$value],
                ),
                'object' => fn (Scope $scope, Arg $value): Expr => new FuncCall(
                    new Name('is_object'),
                    [$value],
                ),
                'resource' => fn (Scope $scope, Arg $value): Expr => new FuncCall(
                    new Name('is_resource'),
                    [$value],
                ),
                'scalar' => fn (Scope $scope, Arg $value): Expr => new FuncCall(
                    new Name('is_scalar'),
                    [$value],
                ),
                'string' => fn (Scope $scope, Arg $value): Expr => new FuncCall(
                    new Name('is_string'),
                    [$value],
                ),
            ];
        }

        return self::$typeResolvers;
    }

}
