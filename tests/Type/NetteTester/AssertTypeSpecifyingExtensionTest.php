<?php
declare(strict_types = 1);

namespace NepadaTests\PHPStan\Type\NetteTester;

use PHPStan\Testing\TypeInferenceTestCase;

class AssertTypeSpecifyingExtensionTest extends TypeInferenceTestCase
{

    /**
     * @return array<string>
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/../../../extension.neon'];
    }

    /**
     * @return iterable<mixed>
     */
    public function dataFileAsserts(): iterable
    {
        yield from $this->gatherAssertTypes(__DIR__ . '/Fixtures/Foo.php');
    }

    /**
     * @dataProvider dataFileAsserts
     * @param string $assertType
     * @param string $file
     * @param mixed ...$args
     */
    public function testFileAsserts(
        string $assertType,
        string $file,
        ...$args
    ): void
    {
        $this->assertFileAsserts($assertType, $file, ...$args);
    }

}
