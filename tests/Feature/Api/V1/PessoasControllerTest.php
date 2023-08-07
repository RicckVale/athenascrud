<?php

namespace Tests\Feature\Api\V1;

use App\Models\Pessoas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PessoasControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testPessoasEndpointGet(): void
    {
        $response = $this->getJson('/api/v1/pessoas');
        $response->assertStatus(200);
    }

    public function testPessoasEndpointGetWithCreationFactoryData()
    {
        Pessoas::factory(5)->create();
        $response = $this->getJson('/api/v1/pessoas');
        $response->assertStatus(200);
        $response->assertJsonCount(5, '0.data');
    }

    public function testPessoasEndpointGetSelectOne()
    {
        $pessoa = Pessoas::factory(1)->createOne();

        $response = $this->getJson('/api/v1/pessoas/'.$pessoa->id);

        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($pessoa) {
            $json->hasAll([
                "id",
                "nome",
                "cpf",
                "email",
                "categoria"
            ]);

            $json->whereAllType([
                "id" => 'integer',
                "nome" => 'string',
                "cpf" => 'string',
                "email" => 'string',
                "categoria" => 'integer',
                "classificacao" => 'string',
                "_links" => 'array',
            ]);

            switch ($pessoa->categoria) {
                case 1:
                case 2:
                    $pessoa->classificacao = "Ouro";
                    break;
                case 3:
                    $pessoa->classificacao = "Prata";
                    break;

            }

            $json->whereAll([
                "id" => $pessoa->id,
                "nome" => $pessoa->nome,
                "cpf" => $pessoa->cpf,
                "email" => $pessoa->email,
                "categoria" => $pessoa->categoria,
                "classificacao" => $pessoa->classificacao,
                "_links" => [
                    [
                        'href' => 'http://localhost/api/v1/pessoas/'.$pessoa->id,
                        'rel' => 'self',
                        'type' => 'GET',
                    ],
                    [
                        'href' => 'http://localhost/api/v1/pessoas',
                        'rel' => 'index',
                        'type' => 'GET',
                    ],
                    [
                        'href' => 'http://localhost/api/v1/pessoas',
                        'rel' => 'store',
                        'type' => 'POST',
                    ],
                    [
                        'href' => 'http://localhost/api/v1/pessoas/'.$pessoa->id,
                        'rel' => 'update',
                        'type' => 'PATCH',
                    ],
                    [
                        'href' => 'http://localhost/api/v1/pessoas/'.$pessoa->id,
                        'rel' => 'destroy',
                        'type' => 'DELETE',
                    ],
                ],
            ]);
        });
    }

    public function testPessoasEndpointGetSelectOneJsonFormatHATEOAS()
    {
        Pessoas::factory()->createOne();

        $response = $this->getJson('/api/v1/pessoas/1');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'id',
            'nome',
            'cpf',
            'email',
            'categoria',
            'classificacao',
            '_links' => [
                '*' => [
                    'rel',
                    'type',
                    'href'
                ]
            ]
        ]);
    }

    public function testPessoasEndpointGetFiveItensPaginatedJsonFormat()
    {
        $pessoas = Pessoas::factory(5)->create();
        $response = $this->getJson('/api/v1/pessoas');
        $response->assertStatus(200);

        // Assert the structure of the response JSON
        $response->assertJsonStructure([
            'current_page',
            0 => [
                'data' => [
                    '*' => [
                        'id',
                        'nome',
                        'cpf',
                        'email',
                        'categoria',
                        'classificacao',
                        '_links' => [
                            '*' => [
                                'rel',
                                'type',
                                'href'
                            ]
                        ]
                    ]
                ],
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links' => [
                    '*' => [
                        'url',
                        'label',
                        'active'
                    ]
                ],
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total'
            ],
        ]);
    }

    public function testPessoasEndpointPostToStore()
    {
        $pessoa = Pessoas::factory(1)->makeOne()->toArray();

        $response = $this->postJson('api/v1/pessoas', $pessoa);

        $response->assertStatus(201);

        $response->assertJson(function (AssertableJson $json) use ($pessoa) {
            $json->hasAll(
                [
                    'id',
                    'nome',
                    'cpf',
                    'email',
                    'categoria',
                    'classificacao',
                ]
            );

            $json->whereAll([
                'id' => 1,
                'nome' => $pessoa['nome'],
                'cpf' => $pessoa['cpf'],
                'email' => $pessoa['email'],
                'categoria' => $pessoa['categoria'],
                'classificacao' => null,
                '_links' => [
                    [
                        'href' => url('/api/v1/pessoas/1'),
                        'rel' => 'self',
                        'type' => 'GET',
                    ],
                    [
                        'href' => url('/api/v1/pessoas'),
                        'rel' => 'index',
                        'type' => 'GET',
                    ],
                    [
                        'href' => url('/api/v1/pessoas'),
                        'rel' => 'store',
                        'type' => 'POST',
                    ],
                    [
                        'href' => url('/api/v1/pessoas/1'),
                        'rel' => 'update',
                        'type' => 'PATCH',
                    ],
                    [
                        'href' => url('/api/v1/pessoas/1'),
                        'rel' => 'destroy',
                        'type' => 'DELETE',
                    ],
                ],
            ])->etc();
        });
    }

    public function testPessoasEndpointPut()
    {
        $nPessoa = Pessoas::factory(1)->createOne();

        $arrPessoa = Pessoas::factory(1)->makeOne()->toArray();

        $response = $this->putJson('api/v1/pessoas/'.$nPessoa->id, $arrPessoa);

        $response->assertStatus(201);

        $response->assertJson(function (AssertableJson $json) use ($arrPessoa) {
            $json->hasAll(
                [
                    'id',
                    'nome',
                    'cpf',
                    'email',
                    'categoria',
                    'classificacao',
                ]
            );

            $json->whereAll([
                'id' => 1,
                'nome' => $arrPessoa['nome'],
                'cpf' => $arrPessoa['cpf'],
                'email' => $arrPessoa['email'],
                'categoria' => $arrPessoa['categoria'],
                'classificacao' => null,
                '_links' => [
                    [
                        'href' => url('/api/v1/pessoas/1'),
                        'rel' => 'self',
                        'type' => 'GET',
                    ],
                    [
                        'href' => url('/api/v1/pessoas'),
                        'rel' => 'index',
                        'type' => 'GET',
                    ],
                    [
                        'href' => url('/api/v1/pessoas'),
                        'rel' => 'store',
                        'type' => 'POST',
                    ],
                    [
                        'href' => url('/api/v1/pessoas/1'),
                        'rel' => 'update',
                        'type' => 'PATCH',
                    ],
                    [
                        'href' => url('/api/v1/pessoas/1'),
                        'rel' => 'destroy',
                        'type' => 'DELETE',
                    ],
                ],
            ])->etc();
        });
    }

    public function testPessoasEndpointPatch()
    {
        Pessoas::factory(1)->createOne();

        $pessoa = [
            'nome' => 'Zé das Coves',
        ];

        $response = $this->patchJson('api/v1/pessoas/1', $pessoa);

        $response->assertStatus(201);

        $response->assertJson(function (AssertableJson $json) use ($pessoa) {
            $json->hasAll(
                [
                    'id',
                    'nome',
                    'cpf',
                    'email',
                    'categoria',
                    'classificacao',
                ]
            )->etc();

            $json->where('nome', $pessoa['nome']);
        });
    }

    public function testPessoasEndpointDelete()
    {
        $pessoa = Pessoas::factory(1)->createOne();

        $response = $this->deleteJson('/api/v1/pessoas/'.$pessoa->id);

        $response->assertStatus(204);
    }
}
