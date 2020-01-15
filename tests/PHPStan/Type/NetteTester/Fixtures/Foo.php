<?php
declare(strict_types = 1);

namespace NepadaTests\PHPStan\Type\NetteTester\Fixtures;

use Tester\Assert;

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
        $a;

        Assert::notNull($u);
        $u;

        Assert::true($b);
        $b;

        Assert::false($c);
        $c;

        Assert::nan($d);
        $d;

        Assert::same('Lorem ipsum', $e);
        $e;

        Assert::count(1, $f);
        $item = reset($f);
        $item;

        Assert::count(0, $g);
        $item = reset($g);
        $item;

        Assert::type('list', $h);
        $h;

        Assert::type('array', $i);
        $i;

        Assert::type('bool', $j);
        $j;

        Assert::type('callable', $k);
        $k;

        Assert::type('float', $l);
        $l;

        Assert::type('int', $m);
        $m;

        Assert::type('integer', $n);
        $n;

        Assert::type('null', $o);
        $o;

        Assert::type('object', $p);
        $p;

        Assert::type('resource', $q);
        $q;

        Assert::type('scalar', $r);
        $r;

        Assert::type('string', $s);
        $s;

        Assert::type(self::class, $t);
        $t;

        $x = rand(0, 1) > 0 ? 1 : 2;
        $x;
        Assert::notSame(1, $x);
        $x;

        $y = rand(0, 1) > 0 ? ['foo'] : '';
        $y;
        Assert::truthy($y);
        $y;

        $z = rand(0, 1) > 0 ? ['foo'] : '';
        $z;
        Assert::falsey($z);
        $z;
    }

}
