<?php

namespace Tests\Unit\Api;

use App\Models\Pessoas;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PessoasModelTest extends TestCase
{

    use RefreshDatabase;

    public function testPessoaCreateAndValidateInsertedData()
    {
        $data = [
            'nome' => 'John Doe',
            'cpf' => '123456789',
            'email' => 'john@example.com',
            'categoria' => '1',
        ];

        $pessoa = new Pessoas();

        $pessoa = $pessoa->create($data);

        $this->assertInstanceOf(Pessoas::class, $pessoa);
        $this->assertEquals($data['nome'], $pessoa->nome);
        $this->assertEquals($data['email'], $pessoa->email);
    }

    public function testPessoaCreateWithFactory()
    {
        $pessoa = Pessoas::factory(1)->createOne();
        $this->assertInstanceOf(Pessoas::class, $pessoa);
    }

    public function testPessoaCreate()
    {
        $pessoaData = [
            'nome' => 'John Doe',
            'cpf' => '123456789',
            'email' => 'john@example.com',
            'categoria' => '1',
        ];

        $pessoa = Pessoas::create($pessoaData);

        $this->assertInstanceOf(Pessoas::class, $pessoa);
        $this->assertDatabaseHas('pessoas', $pessoaData);
    }

    public function testPessoaUpdate()
    {
        $pessoa = Pessoas::factory()->create();

        $novoNome = 'João das Couves';
        $pessoa->nome = $novoNome;
        $pessoa->save();

        $this->assertEquals($novoNome, $pessoa->nome);
    }

    public function testPessoaSoftDelete()
    {
        $pessoa = Pessoas::factory()->create();

        $pessoa->delete();

        $this->assertSoftDeleted('pessoas', ['id' => $pessoa->id]);
    }

    public function testPessoaSearchById()
    {
        $pessoa = Pessoas::factory()->create();

        $pessoaEncontrado = Pessoas::find($pessoa->id);

        $this->assertInstanceOf(Pessoas::class, $pessoaEncontrado);
        $this->assertEquals($pessoa->id, $pessoaEncontrado->id);
    }


    public function testPessoaRequiredFieldNome()
    {
        $this->expectException(QueryException::class);

        $pessoa = new Pessoas([
            // 'nome' => 'John Doe',
            'cpf' => '123456789',
            'email' => 'john@example.com',
            'categoria' => '1',
        ]);
        $pessoa->save();
    }

    public function testPessoaRequiredFieldEmail()
    {
        $this->expectException(QueryException::class);

        $pessoa = new Pessoas([
            'nome' => 'John Doe',
            'cpf' => '123456789',
            // 'email' => 'john@example.com',
            'categoria' => '1',
        ]);
        $pessoa->save();
    }

    public function testPessoaRequiredFieldCategoria()
    {
        $pessoaData = [
            'nome' => 'John Doe',
            'cpf' => '123456789',
            'email' => 'john@example.com',
            // 'categoria' => '1',
        ];

        $pessoa = Pessoas::create($pessoaData);

        $this->assertInstanceOf(Pessoas::class, $pessoa);
        $this->assertDatabaseHas('pessoas', $pessoaData);
    }

}

