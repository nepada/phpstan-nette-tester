<?php
declare(strict_types = 1);

namespace NepadaTests\PHPStan\Type\NetteTester;

use Nepada\PHPStan\Type\NetteTester\AssertTypeSpecifyingExtension;
use NepadaTests\PHPStan\Rules\VariableTypeReportingRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPStan\Type\StaticMethodTypeSpecifyingExtension;

/**
 * @extends RuleTestCase<\NepadaTests\PHPStan\Rules\VariableTypeReportingRule>
 */
class AssertTypeSpecifyingExtensionTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new VariableTypeReportingRule();
    }

    /**
     * @return StaticMethodTypeSpecifyingExtension[]
     */
    protected function getStaticMethodTypeSpecifyingExtensions(): array
    {
        return [
            new AssertTypeSpecifyingExtension(),
        ];
    }

    public function testExtension(): void
    {
        $base = 37;
        $this->analyse(
            [__DIR__ . '/Fixtures/Foo.php'],
            [
                [
                    'Variable $a is: null',
                    $base,
                ],
                [
                    'Variable $u is: string',
                    $base + 3,
                ],
                [
                    'Variable $b is: true',
                    $base + 6,
                ],
                [
                    'Variable $c is: false',
                    $base + 9,
                ],
                [
                    'Variable $d is: float',
                    $base + 12,
                ],
                [
                    'Variable $e is: \'Lorem ipsum\'',
                    $base + 15,
                ],
                [
                    'Variable $item is: string',
                    $base + 19,
                ],
                [
                    'Variable $item is: false',
                    $base + 23,
                ],
                [
                    'Variable $h is: array',
                    $base + 26,
                ],
                [
                    'Variable $i is: array',
                    $base + 29,
                ],
                [
                    'Variable $j is: bool',
                    $base + 32,
                ],
                [
                    'Variable $k is: callable(): mixed',
                    $base + 35,
                ],
                [
                    'Variable $l is: float',
                    $base + 38,
                ],
                [
                    'Variable $m is: int',
                    $base + 41,
                ],
                [
                    'Variable $n is: int',
                    $base + 44,
                ],
                [
                    'Variable $o is: null',
                    $base + 47,
                ],
                [
                    'Variable $p is: object',
                    $base + 50,
                ],
                [
                    'Variable $q is: resource',
                    $base + 53,
                ],
                [
                    'Variable $r is: bool|float|int|string',
                    $base + 56,
                ],
                [
                    'Variable $s is: string',
                    $base + 59,
                ],
                [
                    'Variable $t is: NepadaTests\PHPStan\Type\NetteTester\Fixtures\Foo',
                    $base + 62,
                ],
                [
                    'Variable $x is: 1|2',
                    $base + 65,
                ],
                [
                    'Variable $x is: 2',
                    $base + 67,
                ],
                [
                    'Variable $y is: \'\'|array(\'foo\')',
                    $base + 70,
                ],
                [
                    'Variable $y is: array(\'foo\')',
                    $base + 72,
                ],
                [
                    'Variable $z is: \'\'|array(\'foo\')',
                    $base + 75,
                ],
                [
                    'Variable $z is: \'\'',
                    $base + 77,
                ],
            ]
        );
    }

}
