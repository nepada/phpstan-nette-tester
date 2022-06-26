<?php
declare(strict_types = 1);

namespace Nepada\PHPStan\Type\NetteTester;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\StaticCall;
use PHPStan\Analyser\Scope;
use PHPStan\Analyser\SpecifiedTypes;
use PHPStan\Analyser\TypeSpecifier;
use PHPStan\Analyser\TypeSpecifierAwareExtension;
use PHPStan\Analyser\TypeSpecifierContext;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\StaticMethodTypeSpecifyingExtension;

class AssertTypeSpecifyingExtension implements StaticMethodTypeSpecifyingExtension, TypeSpecifierAwareExtension
{

    private TypeSpecifier $typeSpecifier;

    /**
     * @param Scope $scope
     * @param string $name
     * @param Arg[] $args
     * @return Expr|NULL
     */
    private static function createExpression(Scope $scope, string $name, array $args): ?Expr
    {
        $resolvers = AssertMethodExpressionResolversProvider::getResolvers();
        $resolver = $resolvers[$name];
        return $resolver($scope, ...$args);
    }

    public function setTypeSpecifier(TypeSpecifier $typeSpecifier): void
    {
        $this->typeSpecifier = $typeSpecifier;
    }

    public function getClass(): string
    {
        return 'Tester\Assert';
    }

    public function isStaticMethodSupported(
        MethodReflection $staticMethodReflection,
        StaticCall $node,
        TypeSpecifierContext $context
    ): bool
    {
        $methodName = $staticMethodReflection->getName();
        $resolvers = AssertMethodExpressionResolversProvider::getResolvers();

        return array_key_exists($methodName, $resolvers);
    }

    public function specifyTypes(
        MethodReflection $staticMethodReflection,
        StaticCall $node,
        Scope $scope,
        TypeSpecifierContext $context
    ): SpecifiedTypes
    {
        if ($node->isFirstClassCallable()) {
            return new SpecifiedTypes([], []);
        }

        $expression = self::createExpression($scope, $staticMethodReflection->getName(), $node->getArgs());
        if ($expression === null) {
            return new SpecifiedTypes([], []);
        }

        return $this->typeSpecifier->specifyTypesInCondition(
            $scope,
            $expression,
            TypeSpecifierContext::createTruthy(),
        );
    }

}
