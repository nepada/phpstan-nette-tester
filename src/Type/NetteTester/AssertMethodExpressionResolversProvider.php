<?php
declare(strict_types = 1);

namespace Nepada\PHPStan\Type\NetteTester;

use PHPStan\Analyser\Scope;
use PHPStan\Type\Constant\ConstantStringType;
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

final class AssertMethodExpressionResolversProvider
{

    /** @var \Closure[]\NULL */
    private static $resolvers;

    /** @var \Closure[]|NULL */
    private static $typeResolvers;

    /**
     * @return \Closure[]
     */
    public static function getResolvers(): array
    {
        if (self::$resolvers === null) {
            self::$resolvers = [
                'null' => function (Scope $scope, Arg $expr): Expr {
                    return new Identical(
                        $expr->value,
                        new ConstFetch(new Name('null'))
                    );
                },
                'notNull' => function (Scope $scope, Arg $expr): Expr {
                    return new NotIdentical(
                        $expr->value,
                        new ConstFetch(new Name('null'))
                    );
                },
                'true' => function (Scope $scope, Arg $expr): Expr {
                    return new Identical(
                        $expr->value,
                        new ConstFetch(new Name('true'))
                    );
                },
                'false' => function (Scope $scope, Arg $expr): Expr {
                    return new Identical(
                        $expr->value,
                        new ConstFetch(new Name('false'))
                    );
                },
                'truthy' => function (Scope $scope, Arg $expr): Expr {
                    return new Equal(
                        $expr->value,
                        new ConstFetch(new Name('true'))
                    );
                },
                'falsey' => function (Scope $scope, Arg $expr): Expr {
                    return new Equal(
                        $expr->value,
                        new ConstFetch(new Name('false'))
                    );
                },
                'nan' => function (Scope $scope, Arg $value): Expr {
                    return new BooleanAnd(
                        new FuncCall(
                            new Name('is_float'),
                            [$value]
                        ),
                        new FuncCall(
                            new Name('is_nan'),
                            [$value]
                        )
                    );
                },
                'same' => function (Scope $scope, Arg $value1, Arg $value2): Expr {
                    return new Identical(
                        $value1->value,
                        $value2->value
                    );
                },
                'notSame' => function (Scope $scope, Arg $value1, Arg $value2): Expr {
                    return new NotIdentical(
                        $value1->value,
                        $value2->value
                    );
                },
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
                        new Name($typeValue)
                    );
                },
                'count' => function (Scope $scope, Arg $count, Arg $value): Expr {
                    return new BooleanAnd(
                        new BooleanOr(
                            new FuncCall(
                                new Name('is_array'),
                                [$value]
                            ),
                            new Instanceof_(
                                $value->value,
                                new Name(\Countable::class)
                            )
                        ),
                        new Identical(
                            new FuncCall(
                                new Name('count'),
                                [$value]
                            ),
                            $count->value
                        )
                    );
                },
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
                'list' => function (Scope $scope, Arg $value): Expr {
                    return new FuncCall(
                        new Name('is_array'),
                        [$value]
                    );
                },
                'array' => function (Scope $scope, Arg $value): Expr {
                    return new FuncCall(
                        new Name('is_array'),
                        [$value]
                    );
                },
                'bool' => function (Scope $scope, Arg $value): Expr {
                    return new FuncCall(
                        new Name('is_bool'),
                        [$value]
                    );
                },
                'callable' => function (Scope $scope, Arg $value): Expr {
                    return new FuncCall(
                        new Name('is_callable'),
                        [$value]
                    );
                },
                'float' => function (Scope $scope, Arg $value): Expr {
                    return new FuncCall(
                        new Name('is_float'),
                        [$value]
                    );
                },
                'int' => function (Scope $scope, Arg $value): Expr {
                    return new FuncCall(
                        new Name('is_int'),
                        [$value]
                    );
                },
                'integer' => function (Scope $scope, Arg $value): Expr {
                    return new FuncCall(
                        new Name('is_int'),
                        [$value]
                    );
                },
                'null' => function (Scope $scope, Arg $value): Expr {
                    return new FuncCall(
                        new Name('is_null'),
                        [$value]
                    );
                },
                'object' => function (Scope $scope, Arg $value): Expr {
                    return new FuncCall(
                        new Name('is_object'),
                        [$value]
                    );
                },
                'resource' => function (Scope $scope, Arg $value): Expr {
                    return new FuncCall(
                        new Name('is_resource'),
                        [$value]
                    );
                },
                'scalar' => function (Scope $scope, Arg $value): Expr {
                    return new FuncCall(
                        new Name('is_scalar'),
                        [$value]
                    );
                },
                'string' => function (Scope $scope, Arg $value): Expr {
                    return new FuncCall(
                        new Name('is_string'),
                        [$value]
                    );
                },
            ];
        }

        return self::$typeResolvers;
    }

}
