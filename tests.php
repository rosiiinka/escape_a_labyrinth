<?php

require_once __DIR__ . '/labyrinth.php';

class Tests
{
    /**
     * Runs all tests.
     *
     * @return void
     */
    public function runAllTests(): void
    {
        echo "Running Labyrinth Tests...\n\n";

        $this->providedTestCaseOneTest();
        $this->providedTestCaseTwoTest();
        $this->allPassableFourByFourMapTest();
        $this->allPassableTwoByTwoMapTest();
        $this->removeWallSimpleMapTest();
        $this->removeWallHardMapTest();
        $this->noWallRemovalSimpleMapTest();
        $this->noWallRemovalHardMapTest();
        $this->emptyMapTest();
        $this->nonEqualRowsLengthMapTest();
        $this->endCellWallMapTest();
        $this->startCellWallMapTest();
        $this->singleRowMapTest();
        $this->singleColumnMapTest();
        $this->stringElementMapTest();
        $this->invalidNumberElementMapTest();

        echo "\n All DONE \n";
    }


    /**
     * @param string $testName
     * @param array $map
     * @param int|null $expected
     * @return void
     */
    public function assertTest(string $testName, array $map, ?int $expected): void
    {
        try {
            $actual = solution($map);

            if ($expected === null) {
                // We expected an error/exception, but none was thrown
                echo "[FAIL] $testName => Expected an exception, but got $actual\n";
                return;
            }

            // Compare $actual to $expected
            if ($actual === $expected) {
                echo "[PASS] $testName => Expected: $expected, Got: $actual\n";
            } else {
                echo "[FAIL] $testName => Expected: $expected, Got: $actual\n";
            }
        } catch (\Throwable $e) {
            if ($expected === null) {
                // We expected an exception, so we PASS
                echo "[PASS] $testName => Expected exception was thrown: " . $e->getMessage() . "\n";
            } else {
                // We did not expect an exception, so we FAIL
                echo "[ERROR] $testName => Unexpected exception: " . $e->getMessage() . "\n";
            }
        }
    }

    //
    // ----- VALID MAP TESTS -----
    //

    /**
     * @return void
     */
    public function providedTestCaseOneTest(): void
    {
        $map = [
            [0, 0, 0, 0, 0, 0],
            [1, 1, 1, 1, 1, 0],
            [0, 0, 0, 0, 0, 0],
            [0, 1, 1, 1, 1, 1],
            [0, 1, 1, 1, 1, 1],
            [0, 0, 0, 0, 0, 0]
        ];
        $this->assertTest("Test1 provided in task", $map, 11);
    }

    /**
     * @return void
     */
    public function providedTestCaseTwoTest(): void
    {
        $map = [
            [0, 1, 1, 0],
            [0, 0, 0, 1],
            [1, 1, 0, 0],
            [1, 1, 1, 0]
        ];
        $this->assertTest("Test2 provided in task", $map, 7);
    }

    /**
     * @return void
     */
    public function allPassableFourByFourMapTest(): void
    {
        $map = [
            [0, 0, 0, 0],
            [0, 0, 0, 0],
            [0, 0, 0, 0],
            [0, 0, 0, 0],
        ];
        $this->assertTest("Test3 - all passable four by four map no walls", $map, 7);
    }

    /**
     * @return void
     */
    public function allPassableTwoByTwoMapTest(): void
    {
        $map = [
            [0, 0],
            [0, 0],
        ];
        $this->assertTest("Test4 - all passable two by two map no walls", $map, 3);
    }

    /**
     * @return void
     */
    public function removeWallSimpleMapTest(): void
    {
        $map = [
            [0, 1, 1],
            [1, 0, 0],
            [1, 0, 0],
        ];
        $this->assertTest("Test5 - remove wall simple map", $map, 5);
    }

    /**
     * @return void
     */
    public function removeWallHardMapTest(): void
    {
        $map = [
            [0, 0, 1, 0, 0, 1, 0, 0],
            [0, 1, 1, 0, 0, 1, 0, 0],
            [0, 0, 0, 1, 0, 1, 0, 0],
            [1, 1, 0, 1, 0, 1, 0, 0],
            [0, 0, 0, 0, 0, 1, 0, 0],
            [0, 0, 0, 0, 0, 1, 0, 0],
            [0, 0, 0, 0, 0, 1, 0, 0],
            [0, 0, 0, 0, 0, 1, 0, 0],
        ];
        $this->assertTest("Test5 - remove wall hard map ", $map, 15);
    }

    /**
     * @return void
     */
    public function noWallRemovalSimpleMapTest(): void
    {
        $map = [
            [0, 0, 0],
            [0, 1, 0],
            [0, 0, 0],
        ];
        $this->assertTest("Test6 - no wall removal simple map", $map, 5);
    }

    /**
     * @return void
     */
    public function noWallRemovalHardMapTest(): void
    {
        $map = [
            [0, 0, 1, 0, 0],
            [0, 1, 1, 0, 0],
            [0, 0, 0, 1, 0],
            [1, 1, 0, 1, 0],
            [0, 0, 0, 0, 0],
        ];
        $this->assertTest("Test7 - no wall removal hard map", $map, 9);
    }

    //
    // ----- INVALID MAP TESTS -----
    //

    /**
     * @return void
     */
    public function emptyMapTest(): void
    {
        $map = [];
        $this->assertTest("Test8 - empty map", $map, null);
    }

    /**
     * @return void
     */
    public function nonEqualRowsLengthMapTest(): void
    {
        $map = [
            [0, 0, 1],
            [0, 0], // shorter row
        ];
        $this->assertTest("Test9 - non-equal rows length map", $map, null);
    }

    /**
     * @return void
     */
    function endCellWallMapTest(): void
    {
        $map = [
            [0, 0],
            [0, 1],
        ];
        $this->assertTest("Test10 - end cell wall map", $map, null);
    }

    /**
     * @return void
     */
    function startCellWallMapTest(): void
    {
        $map = [
            [1, 0],
            [0, 0],
        ];
        $this->assertTest("Test11 - start cell wall map", $map, null);
    }

    /**
     * @return void
     */
    function singleRowMapTest(): void
    {
        $map = [
            [0, 0, 0, 0],
        ];
        $this->assertTest("Test12 - single row map", $map, null);
    }

    /**
     * @return void
     */
    function singleColumnMapTest(): void
    {
        $map = [
            [0],
            [0],
            [0],
        ];
        $this->assertTest("Test13 -  single column map", $map, null);
    }

    /**
     * @return void
     */
    function stringElementMapTest(): void
    {
        $map = [
            [0, 1, 0],
            [0, 'X', 0], // invalid element
            [0, 0, 0],
        ];
        $this->assertTest("Test14 - map with string element", $map, null);
    }

    /**
     * @return void
     */
    function invalidNumberElementMapTest(): void
    {
        $map = [
            [0, 1, 0],
            [0, 5, 0], // invalid element
            [0, 0, 0],
        ];
        $this->assertTest("Test15 - map with invalid number element", $map, null);
    }

}

// Run tests
$test = new Tests();
$test->runAllTests();

