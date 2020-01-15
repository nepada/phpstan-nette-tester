<?php
declare(strict_types = 1);

namespace NepadaTests\PHPStan\Type\NetteTester;

use Nepada\PHPStan\Type\NetteTester\AssertTypeSpecifyingExtension;
use NepadaTests\PHPStan\VariableTypeReportingRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPStan\Type\StaticMethodTypeSpecifyingExtension;

/**
 * @extends RuleTestCase<VariableTypeReportingRule>
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
        $this->analyse(
            [__DIR__ . '/Fixtures/Foo.php'],
            [
                [
                    'Variable $a is: null',
                    39,
                ],
                [
                    'Variable $u is: string',
                    42,
                ],
                [
                    'Variable $b is: true',
                    45,
                ],
                [
                    'Variable $c is: false',
                    48,
                ],
                [
                    'Variable $d is: float',
                    51,
                ],
                [
                    'Variable $e is: \'Lorem ipsum\'',
                    54,
                ],
                [
                    'Variable $item is: string',
                    58,
                ],
                [
                    'Variable $item is: false',
                    62,
                ],
                [
                    'Variable $h is: array',
                    65,
                ],
                [
                    'Variable $i is: array',
                    68,
                ],
                [
                    'Variable $j is: bool',
                    71,
                ],
                [
                    'Variable $k is: callable(): mixed',
                    74,
                ],
                [
                    'Variable $l is: float',
                    77,
                ],
                [
                    'Variable $m is: int',
                    80,
                ],
                [
                    'Variable $n is: int',
                    83,
                ],
                [
                    'Variable $o is: null',
                    86,
                ],
                [
                    'Variable $p is: object',
                    89,
                ],
                [
                    'Variable $q is: resource',
                    92,
                ],
                [
                    'Variable $r is: bool|float|int|string',
                    95,
                ],
                [
                    'Variable $s is: string',
                    98,
                ],
                [
                    'Variable $t is: NepadaTests\PHPStan\Type\NetteTester\Fixtures\Foo',
                    101,
                ],
                [
                    'Variable $x is: 1|2',
                    104,
                ],
                [
                    'Variable $x is: 2',
                    106,
                ],
                [
                    'Variable $y is: \'\'|array(\'foo\')',
                    109,
                ],
                [
                    'Variable $y is: array(\'foo\')',
                    111,
                ],
                [
                    'Variable $z is: \'\'|array(\'foo\')',
                    114,
                ],
                [
                    'Variable $z is: \'\'',
                    116,
                ],
            ]
        );
    }

}
