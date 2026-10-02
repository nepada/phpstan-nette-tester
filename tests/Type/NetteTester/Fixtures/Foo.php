<?php
declare(strict_types = 1);

namespace NepadaTests\PHPStan\Type\NetteTester\Fixtures;

use Tester\Assert;
use function PHPStan\Testing\assertType;
use function rand;

class Foo
{

    /**
     * @param string[] $f
     * @param int[] $g
     * @param string|NULL $u
     */
    public function doFoo(mixed $a, mixed $b, mixed $c, mixed $d, mixed $e, array $f, array $g, mixed $h, mixed $i, mixed $j, mixed $k, mixed $l, mixed $m, mixed $n, mixed $o, mixed $p, mixed $q, mixed $r, mixed $s, mixed $t, ?string $u): void
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
        assertType('list', $h);

        Assert::type('array', $i);
        assertType('array<mixed, mixed>', $i);

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

    public function testTypeWithMultiplePossibilities(mixed $value): void
    {
        $type = rand(0, 1) > 0 ? 'int' : 'string';
        assertType("'int'|'string'", $type);
        Assert::type($type, $value);
        assertType('int|string', $value);
    }

    public function testTypeWithEmptyString(mixed $a): void
    {
        Assert::type('', $a);
        assertType('mixed', $a);
    }

    /**
     * @param array<int, mixed> $args
     */
    public function testUnpackedArguments(array $args): void
    {
        Assert::null(...$args);
        assertType('array<int, mixed>', $args);

        Assert::same(...$args);
        assertType('array<int, mixed>', $args);
    }

    /**
     * @param array<string, int> $c
     */
    public function testNamedArguments(mixed $a, mixed $b, array $c): void
    {
        Assert::null(description: 'must be null', actual: $a);
        assertType('null', $a);

        Assert::type(value: $b, type: 'int');
        assertType('int', $b);

        Assert::count(value: $c, count: 1);
        assertType('non-empty-array<string, int>', $c);
    }

    public function testUnresolvableNamedArguments(?string $description): void
    {
        Assert::null(description: $description);
        assertType('string|null', $description);
    }

    /**
     * @param array{foo?: int, bar: string} $shape
     * @param array<string, int> $array
     */
    public function testHasKey(array $shape, array $array): void
    {
        Assert::hasKey('foo', $shape);
        assertType('array{foo: int, bar: string}', $shape);

        Assert::hasKey('foo', $array, 'description is ignored');
        assertType("non-empty-array<string, int>&hasOffset('foo')", $array);
    }

    /**
     * @param array{foo?: int, bar: string} $shape
     * @param array<string, int> $array
     */
    public function testHasNotKey(array $shape, array $array): void
    {
        Assert::hasNotKey('foo', $shape);
        assertType('array{bar: string}', $shape);

        Assert::hasNotKey(actual: $array, key: 'foo');
        assertType('array<string, int>', $array);
    }

}
