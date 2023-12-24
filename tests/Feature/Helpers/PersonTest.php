<?php

namespace Tests\Feature\Helpers;

use App\Helpers\Person as PersonHelper;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class PersonTest extends TestCase
{
    #[DataProvider('surnameStringProvider')]
    public function testSurnameString($value): void
    {
        $this->assertEquals($value, PersonHelper::surname($value));
    }

    /**
     * @return array[]
     */
    public static function surnameStringProvider(): array
    {
        return [
            ["Ivanov"],
            ["Petrov"],
            ["Sidorov"]
        ];
    }

    public function testSurnameEmpty(): void
    {
        $this->assertEquals(__("person.surname.null"), PersonHelper::surname(""));
        $this->assertEquals(__("person.surname.null"), PersonHelper::surname(null));
    }

    #[DataProvider('oldSurnameStringProvider')]
    public function testOldSurnameString($expected, $actual): void
    {
        $this->assertEquals($expected, PersonHelper::oldSurname($actual));
    }

    /**
     * @return array[]
     */
    public static function oldSurnameStringProvider(): array
    {
        return [
            ["(Ivanov)", collect(["Ivanov"])],
            ["(Ivanov,Petrov)", collect(["Ivanov", "Petrov"])],
            ["", collect([])],
            ["", null],
        ];
    }

    #[DataProvider('nameStringProvider')]
    public function testNameString($value): void
    {
        $this->assertIsString(PersonHelper::surname($value));
        $this->assertEquals($value, PersonHelper::surname($value));
    }

    /**
     * @return array[]
     */
    public static function nameStringProvider(): array
    {
        return [
            ["Den"],
            ["Maksim"],
            ["Ivan"],
        ];
    }

    public function testNameEmpty(): void
    {
        $this->assertEquals(__("person.name.null"), PersonHelper::name(""));
        $this->assertEquals(__("person.name.null"), PersonHelper::name(null));
    }

    #[DataProvider('patronymicStringProvider')]
    public function testPatronymicString($value): void
    {
        $this->assertIsString(PersonHelper::surname($value));
        $this->assertEquals($value, PersonHelper::surname($value));
    }

    /**
     * @return array[]
     */
    public static function patronymicStringProvider(): array
    {
        return [
            ["Maksimovich"],
            ["Ivanovich"],
            ["Petrovich"]
        ];
    }

    public function testPatronymicEmpty(): void
    {
        $this->assertEquals("", PersonHelper::patronymic(""));
    }

    public function testPatronymicNull(): void
    {
        $this->assertEquals(__("person.patronymic.null"), PersonHelper::patronymic(null));
    }

    #[DataProvider('patronymicEditProvider')]
    public function testPatronymicEdit(?string $expectedParam, string $expectedReturn): void
    {
        $this->assertEquals($expectedReturn, PersonHelper::patronymicEdit($expectedParam));
    }

    /**
     * @return array[]
     */
    public static function patronymicEditProvider(): array
    {
        return [
            [null, ""],
            ["", "!"],
            ["Petrovich", "Petrovich"],
        ];
    }
}
