<?php

namespace Tests\Feature\Http\Controllers\Register;

use App\Models\Person;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PersonControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function refreshTestDatabase()
    {
        $this->artisan('migrate:refresh', ['--database' => 'sqlite']);
    }

    /**
     * @test
     *
     * @return void
     */
    public function thisShouldBeAbleToCreateANewPersonAsExpected()
    {
        $response = $this->post(route('person.store'), [
            'name' => 'Teste',
            'cpf' => '12345678901',
            'address' => 'Rua Teste, 123',
        ]);

        $response->assertStatus(303);

        $this->assertDatabaseHas('pessoas', [
            'nome' => 'Teste',
            'cpf' => '12345678901',
            'endereco' => 'Rua Teste, 123',
        ]);
    }
}
