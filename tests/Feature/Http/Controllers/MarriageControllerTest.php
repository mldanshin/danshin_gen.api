<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class MarriageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testRoleAll200(): void
    {
        $expected = fn (AssertableJson $json) =>
            $json->where(1, "partner")
                ->where(2, "boyfriend")
                ->where(3, "girlfriend")
                ->where(4, "husband")
                ->where(5, "wife");

        $response = $this->getJson(route("marriage.roles.all"), $this->getHeaderAdminToken());
        $response->assertStatus(200)->assertJson($expected);
    }

    public function testRoleAll401(): void
    {
        $response = $this->getJson(route("marriage.roles.all"));
        $response->assertStatus(401);
    }

    public function testRoleAll403(): void
    {
        $response = $this->getJson(route("marriage.roles.all"), $this->getHeaderUserToken());
        $response->assertStatus(403);
    }

    #[DataProvider('roleByGender200Provider')]
    public function testRoleByGender200(string $gender, callable $expected): void
    {
        $response = $this->getJson(
            route("marriage.roles.gender", ["gender" => $gender]),
            $this->getHeaderAdminToken()
        );
        $response->assertStatus(200)->assertJson($expected);
    }

    /**
     * @return array[]
     */
    public static function roleByGender200Provider(): array
    {
        return [
            [
                "1",
                fn (AssertableJson $json) =>
                    $json->where(1, "partner")
                        ->where(2, "boyfriend")
                        ->where(3, "girlfriend")
                        ->where(4, "husband")
                        ->where(5, "wife")
            ],
            [
                "2",
                fn (AssertableJson $json) =>
                    $json->where(1, "partner")
                        ->where(2, "boyfriend")
                        ->where(4, "husband")
            ],
            [
                "3",
                fn (AssertableJson $json) =>
                    $json->where(1, "partner")
                        ->where(3, "girlfriend")
                        ->where(5, "wife")
            ]
        ];
    }

    #[DataProvider('roleByGender404Provider')]
    public function testRoleByGender404(string $gender): void
    {
        $response = $this->getJson(
            route("marriage.roles.gender", ["gender" => $gender]),
            $this->getHeaderAdminToken()
        );
        $response->assertStatus(404);
    }

    /**
     * @return array[]
     */
    public static function roleByGender404Provider(): array
    {
        return [
            ["56"],
            ["fake"]
        ];
    }

    public function testRoleByGender401(): void
    {
        $response = $this->getJson(route("marriage.roles.gender", ["gender" => "1"]));
        $response->assertStatus(401);
    }

    public function testRoleByGender403(): void
    {
        $response = $this->getJson(
            route("marriage.roles.gender", ["gender" => "1"]),
            $this->getHeaderUserToken()
        );
        $response->assertStatus(403);
    }

    #[DataProvider('possible200Provider')]
    public function testPossible200(array $request, callable $expected): void
    {
        $response = $this->getJson(
            route("marriage.possible", $request),
            $this->getHeaderAdminToken()
        );
        $response->assertStatus(200)->assertJson($expected);
    }

    /**
     * @return array[]
     */
    public static function possible200Provider(): array
    {
        return [
            [
                [
                    "person_id" => 2,
                    "birth_date" => "1909-09-04",
                    "role_id" => "2",
                    "parents" => [

                    ]
                ],
                fn (AssertableJson $json) =>
                    $json->has(10)
                        ->has('0', fn ($json) =>    
                            $json->where('id', 19)
                                ->where('surname', null)
                                ->where('oldSurname', null)
                                ->where('name', null)
                                ->where('patronymic', "Petrovich")
                        )
                        ->has('1', fn ($json) =>    
                            $json->where('id', 7)
                                ->where('surname', "Danshin")
                                ->where('oldSurname', null)
                                ->where('name', "Denis")
                                ->where('patronymic', "Maksimovich")
                            )
                        ->has('2', fn ($json) =>    
                            $json->where('id', 8)
                                ->where('surname', "Danshin")
                                ->where('oldSurname', null)
                                ->where('name', "Egor")
                                ->where('patronymic', "Leonidovich")
                            )
                        ->has('3', fn ($json) =>    
                            $json->where('id', 5)
                                ->where('surname', "Danshin")
                                ->where('oldSurname.0', "Fake")
                                ->where('oldSurname.1', "AFake")
                                ->where('name', "Maxim")
                                ->where('patronymic', "Leonidovich")
                            )
                        ->has('9', fn ($json) =>    
                            $json->where('id', 10)
                                ->where('surname', "Solovyov")
                                ->where('oldSurname', null)
                                ->where('name', "Igor")
                                ->where('patronymic', "Ivanovich")
                            )
            ],
            [
                [
                    "person_id" => 1,
                    "birth_date" => "1905-10-11",
                    "role_id" => "3",
                    "parents" => [

                    ]
                ],
                fn (AssertableJson $json) =>
                    $json->has(12)
                        ->has('0', fn ($json) =>    
                            $json->where('id', 20)
                                ->where('surname', null)
                                ->where('oldSurname', null)
                                ->where('name', null)
                                ->where('patronymic', null)
                        )
                        ->has('1', fn ($json) =>    
                            $json->where('id', 21)
                                ->where('surname', null)
                                ->where('oldSurname', null)
                                ->where('name', "Inna")
                                ->where('patronymic', null)
                        )
                        ->has('2', fn ($json) =>    
                            $json->where('id', 6)
                                ->where('surname', "Burkina")
                                ->where('oldSurname', null)
                                ->where('name', "Natalia")
                                ->where('patronymic', "Vladimirovna")
                        )
                        ->has('11', fn ($json) =>    
                            $json->where('id', 11)
                                ->where('surname', "Solovyova")
                                ->where('oldSurname', null)
                                ->where('name', "Olga")
                                ->where('patronymic', "Igorevna")
                        )
                        ->etc()
            ],
            [
                [
                    "person_id" => 22,
                    "birth_date" => null,
                    "role_id" => "1",
                    "parents" => [

                    ]
                ],
                fn (AssertableJson $json) =>
                    $json->has(21)
                        ->has('0', fn ($json) =>    
                            $json->where('id', 20)
                                ->where('surname', null)
                                ->where('oldSurname', null)
                                ->where('name', null)
                                ->where('patronymic', null)
                        )
                        ->has('1', fn ($json) =>    
                            $json->where('id', 19)
                                ->where('surname', null)
                                ->where('oldSurname', null)
                                ->where('name', null)
                                ->where('patronymic', "Petrovich")
                        )
                        ->has('2', fn ($json) =>    
                            $json->where('id', 21)
                                ->where('surname', null)
                                ->where('oldSurname', null)
                                ->where('name', "Inna")
                                ->where('patronymic', null)
                        )
                        ->has('3', fn ($json) =>    
                            $json->where('id', 6)
                                ->where('surname', "Burkina")
                                ->where('oldSurname', null)
                                ->where('name', "Natalia")
                                ->where('patronymic', "Vladimirovna")
                        )
                        ->has('4', fn ($json) =>    
                            $json->where('id', 7)
                                ->where('surname', "Danshin")
                                ->where('oldSurname', null)
                                ->where('name', "Denis")
                                ->where('patronymic', "Maksimovich")
                            )
                        ->has('10', fn ($json) =>    
                            $json->where('id', 4)
                                ->where('surname', "Danshina")
                                ->where('oldSurname.0', "Pluta")
                                ->where('name', "Tatyana")
                                ->where('patronymic', "Ivanovna")
                            )
                        ->has('18', fn ($json) =>    
                            $json->where('id', 12)
                                ->where('surname', "Solovyov")
                                ->where('oldSurname', null)
                                ->where('name', "Oleg")
                                ->where('patronymic', "Igorevich")
                            )
                        ->has('19', fn ($json) =>    
                            $json->where('id', 9)
                                ->where('surname', "Solovyova")
                                ->where('oldSurname.0', "Danshin")
                                ->where('name', "Oksana")
                                ->where('patronymic', "Leonidovna")
                            )
                        ->has('20', fn ($json) =>    
                            $json->where('id', 11)
                                ->where('surname', "Solovyova")
                                ->where('oldSurname', null)
                                ->where('name', "Olga")
                                ->where('patronymic', "Igorevna")
                            ) 
                        ->etc()
            ],
            [
                [
                    "birth_date" => "2023-01-01",
                    "role_id" => "3",
                    "parents" => [
                        [
                            "person" => 22
                        ],
                        [
                            "person" => 6
                        ],
                        [
                            "person" => 9
                        ]
                    ]
                ],
                fn (AssertableJson $json) =>
                    $json->has(7)
                        ->has('0', fn ($json) =>    
                            $json->where('id', 20)
                                ->where('surname', null)
                                ->where('oldSurname', null)
                                ->where('name', null)
                                ->where('patronymic', null)
                        )
                        ->has('6', fn ($json) =>    
                            $json->where('id', 11)
                                ->where('surname', "Solovyova")
                                ->where('oldSurname', null)
                                ->where('name', "Olga")
                                ->where('patronymic', "Igorevna")
                            ) 
                        ->etc()
            ]
        ];
    }

    public function testPossible401(): void
    {
        $response = $this->getJson(
            route("marriage.possible", ["personId" => "1"])
        );
        $response->assertStatus(401);
    }

    public function testPossible403(): void
    {
        $response = $this->getJson(
            route("marriage.possible", ["personId" => "1"]),
            $this->getHeaderUserToken()
        );
        $response->assertStatus(403);
    }

    #[DataProvider('possible422Provider')]
    public function testPossible422(array $request): void
    {
        $response = $this->getJson(
            route("marriage.possible", $request),
            $this->getHeaderAdminToken()
        );
        $response->assertStatus(422);
    }

    /**
     * @return array[]
     */
    public static function possible422Provider(): array
    {
        return [
            [
                [
                    "person_id" => "fake",
                    "role_id" => "1",
                ]
            ],
            [
                [
                    "person_id" => 99,
                    "role_id" => "1",
                ]
            ],
            [
                [
                    "birth_date" => "fake",
                    "role_id" => "1",
                ]
            ],
            [
                [
                    "birth_date" => "2000-14-34",
                    "role_id" => "1",
                ]
            ],
            [
                [
                    "role_id" => null,
                ]
            ],
            [
                [
                    "role_id" => 99,
                ]
            ],
            [
                [
                    "role_id" => "1",
                    "parents" => [
                        "fake"
                    ]
                ]
            ],
            [
                [
                    "role_id" => "1",
                    "parents" => [
                        [
                            "person" => "fake"
                        ]
                    ]
                ]
            ],
            [
                [
                    "role_id" => "1",
                    "parents" => [
                        [
                            "person" => 99
                        ]
                    ]
                ]
            ],
            [
                [
                    "role_id" => "1",
                    "parents" => [
                        [
                            "person" => 1
                        ],
                        [
                            "person" => 1
                        ]
                    ]
                ]
            ],
            [
                [
                    "person_id" => 1,
                    "role_id" => "1",
                    "parents" => [
                        [
                            "person" => 1
                        ],
                    ]
                ]
            ],
        ];
    }
}
