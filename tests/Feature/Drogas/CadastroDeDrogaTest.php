<?php

namespace Tests\Feature\Drogas;

use App\Models\Droga;
use Tests\TestCase;

class CadastroDeDrogaTest extends TestCase
{
    public function cenariosValidacao(): array
    {
        return [
            //Não enviando a descrição
            [null, 'O campo descricao é obrigatório.'],
            //Enviando valor booleano no campo descrição
            [true, 'O campo descricao deve ser uma string.']
        ];
    }

    /**
     * @param mixed $valor
     * @param string $erro
     * @dataProvider cenariosValidacao
     */
    public function testValidacaoDoCampoDescricao($valor, string $erro)
    {
        $this->authenticated();

        $data = [
            'descricao' => $valor
        ];

        $response = $this->postJson('api/drogas', $data);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'descricao'
            ]
        ]);
        $response->assertJsonFragment([
            'errors' => [
                'descricao' => [
                    $erro
                ]
            ]
        ]);
    }

    public function testDrogaComDescricaoDuplicada()
    {
        $this->authenticated();

        factory(Droga::class)->create([
            'id' => 6,
            'descricao' => 'droga de teste'
        ]);

        $data = ['descricao' => 'droga de teste'];

        $response = $this->postJson('api/drogas', $data);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'descricao'
            ]
        ]);
        $response->assertJsonFragment([
            'errors' => [
                'descricao' => [
                    'O campo descricao já está sendo utilizado.'
                ]
            ]
        ]);
    }

    public function testCriandoDrogaComSucesso()
    {
        $this->authenticated();

        $data = [
            'descricao' => 'droga de teste criada'
        ];

        $response = $this->postJson('api/drogas', $data);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id',
            'descricao',
        ]);
        $response->assertJsonFragment([
            'descricao' => 'droga de teste criada'
        ]);
    }
}
