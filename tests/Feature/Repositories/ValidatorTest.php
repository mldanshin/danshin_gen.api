<?php

namespace Tests\Feature\Repositories;

use App\Exceptions\DataNotFoundException;
use App\Repositories\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class ValidatorTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    #[DataProvider("checkPersonSuccessProvider")]
    public function testCheckPersonSuccess(int $id): void
    {
        Validator::checkPerson($id);
        $this->assertTrue(true);
    }

    /**
     * @return array[]
     */
    public static function checkPersonSuccessProvider(): array
    {
        return [
            [1],
            [5]
        ];
    }

    #[DataProvider("checkPersonWrongProvider")]
    public function testCheckPersonWrong(int $id): void
    {
        $this->expectException(DataNotFoundException::class);
        Validator::checkPerson($id);
    }

    /**
     * @return array[]
     */
    public static function checkPersonWrongProvider(): array
    {
        return [
            [90],
            [9999]
        ];
    }

    #[DataProvider("checkParentSuccessProvider")]
    public function testCheckParentSuccess(int $personId, ?int $parentId): void
    {
        Validator::checkParent($personId, $parentId);
        $this->assertTrue(true);
    }

    /**
     * @return array[]
     */
    public static function checkParentSuccessProvider(): array
    {
        return [
            [3, 1],
            [7, 5],
            [7, null],
        ];
    }

    #[DataProvider("checkParentWrongProvider")]
    public function testCheckParentWrong(int $personId, ?int $parentId): void
    {
        $this->expectException(DataNotFoundException::class);
        Validator::checkParent($personId, $parentId);
    }

    /**
     * @return array[]
     */
    public static function checkParentWrongProvider(): array
    {
        return [
            [1, 1],
            [1, 2],
            [1, 3],
            [90, 1]
        ];
    }
}