<?php

namespace Tests\Feature\Paciente;

use App\Models\Paciente;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;

class MostrarPacienteEspecificoTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->authenticated();
    }

    public function testMostrarPacienteQueNaoExiste()
    {
        $response = $this->getJson('/api/pacientes/0');
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'paciente_id'
            ]
        ]);
    }

    public function testPacienteDeOutroColetador()
    {
        $user = factory(User::class)->create(['cpf' => '11111111111']);
        $paciente = factory(Paciente::class)->create([
            'coletador_id' => $user->id
        ]);

        $response = $this->getJson("/api/pacientes/{$paciente->id}");
        $response->assertNotFound();
        $response->assertJsonStructure([
            'message'
        ]);
        $response->assertJsonFragment([
            'message' => 'Paciente não encontrado.'
        ]);
    }

    public function testPacienteComSucesso()
    {
        $paciente = factory(Paciente::class)->create([
            'coletador_id' => $this->currentUser->id
        ]);
        $response = $this->getJson("/api/pacientes/{$paciente->id}");
        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'prontuario',
            'data_internacao',
            'data_atendimento_referencia',
            'sexo',
            'data_nascimento',
            'qtd_pessoas_domicilio',
            'caso_confirmado',
            'data_inicio_sintomas',
            'created_at',
            'updated_at',
            'suporte_respiratorio',
            'reinternacao',
            'estado',
            'instituicao_primeiro_atendimento',
            'cor',
            'estado_civil',
            'escolaridade',
            'atividade_profissional',
            'instituicao_referencia',
            'municipio',
            'estado_nascimento',
            'tipo_suporte_respiratorios',
            'telefones'
        ]);
    }
}
