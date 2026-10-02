<?php
declare(strict_types = 1);

namespace NepadaTests\PHPStan\Type\NetteTester;

use PHPStan\Testing\TypeInferenceTestCase;

// phpcs:disable Squiz.Commenting.FunctionComment.InvalidTypeHint -- false positive reported on testFileAsserts
class AssertTypeSpecifyingExtensionTest extends TypeInferenceTestCase
{

    /**
     * @return list<string>
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/../../../extension.neon'];
    }

    /**
     * Older PHPStan versions (< 2.2.7) do not read the parameter from the container in TypeInferenceTestCase.
     *
     * @return string[][]
     */
    protected static function getEarlyTerminatingMethodCalls(): array
    {
        /** @var string[][] $earlyTerminatingMethodCalls */
        $earlyTerminatingMethodCalls = self::getContainer()->getParameter('earlyTerminatingMethodCalls');
        return $earlyTerminatingMethodCalls;
    }

    /**
     * @return iterable<mixed>
     */
    public function dataFileAsserts(): iterable
    {
        yield from self::gatherAssertTypes(__DIR__ . '/Fixtures/Foo.php');
    }

    /**
     * @dataProvider dataFileAsserts
     */
    public function testFileAsserts(
        string $assertType,
        string $file,
        mixed ...$args,
    ): void
    {
        $this->assertFileAsserts($assertType, $file, ...$args);
    }

}
