<?php
declare(strict_types = 1);

namespace NepadaTests\PHPStan\Type\NetteTester\Fixtures;

use Tester\Assert;
use function PHPStan\Testing\assertType;
use function rand;

class Foo
{

    /**
     * @param mixed $a
     * @param mixed $b
     * @param mixed $c
     * @param mixed $d
     * @param mixed $e
     * @param string[] $f
     * @param int[] $g
     * @param mixed $h
     * @param mixed $i
     * @param mixed $j
     * @param mixed $k
     * @param mixed $l
     * @param mixed $m
     * @param mixed $n
     * @param mixed $o
     * @param mixed $p
     * @param mixed $q
     * @param mixed $r
     * @param mixed $s
     * @param mixed $t
     * @param string|NULL $u
     */
    public function doFoo($a, $b, $c, $d, $e, array $f, array $g, $h, $i, $j, $k, $l, $m, $n, $o, $p, $q, $r, $s, $t, ?string $u): void
    {
        Assert::null($a);
        assertType('null', $a);

        Assert::notNull($u);
        assertType('string', $u);

        Assert::true($b);
        assertType('true', $b);

        Assert::false($c);
        assertType('false', $c);

        Assert::nan($d);
        assertType('float', $d);

        Assert::same('Lorem ipsum', $e);
        assertType("'Lorem ipsum'", $e);

        Assert::count(1, $f);
        $item = reset($f);
        assertType('string', $item);

        Assert::count(0, $g);
        $item = reset($g);
        assertType('false', $item);

        Assert::type('list', $h);
        assertType('array', $h);

        Assert::type('array', $i);
        assertType('array', $i);

        Assert::type('bool', $j);
        assertType('bool', $j);

        Assert::type('callable', $k);
        assertType('callable(): mixed', $k);

        Assert::type('float', $l);
        assertType('float', $l);

        Assert::type('int', $m);
        assertType('int', $m);

        Assert::type('integer', $n);
        assertType('int', $n);

        Assert::type('null', $o);
        assertType('null', $o);

        Assert::type('object', $p);
        assertType('object', $p);

        Assert::type('resource', $q);
        assertType('resource', $q);

        Assert::type('scalar', $r);
        assertType('bool|float|int|string', $r);

        Assert::type('string', $s);
        assertType('string', $s);

        Assert::type(self::class, $t);
        assertType(self::class, $t);

        $x = rand(0, 1) > 0 ? 1 : 2;
        assertType('1|2', $x);
        Assert::notSame(1, $x);
        assertType('2', $x);

        $y = rand(0, 1) > 0 ? ['foo'] : '';
        assertType("''|array{'foo'}", $y);
        Assert::truthy($y);
        assertType("array{'foo'}", $y);

        $z = rand(0, 1) > 0 ? ['foo'] : '';
        assertType("''|array{'foo'}", $z);
        Assert::falsey($z);
        assertType("''", $z);
    }

    /**
     * @param mixed $value
     */
    public function testTypeWithMultiplePossibilities($value): void
    {
        $type = rand(0, 1) > 0 ? 'int' : 'string';
        assertType("'int'|'string'", $type);
        Assert::type($type, $value);
        assertType('int|string', $value);
    }

}
