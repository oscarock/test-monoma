<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Factories\UserFactory;
use App\Models\User;

class AspirantControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function agent_can_get_aspirants_list()
    {
        UserFactory::new(['role' => 'agent'])->create();
        $agent = User::where('role', 'agent')->first();
        $token = auth()->login($agent);

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])
                        ->get('api/leads');

        $response->assertStatus(200)
                ->assertJson(['meta' => ['success' => true]])
                ->assertJsonStructure(['data']);
    }

    /** @test */
    public function unauthenticated_user_response()
    {
        $response = $this->get('api/leads');

        $response->assertStatus(401)
                ->assertJson(['meta' => ['success' => false, 'errors' => 'Token not provided']]);
    }

    public function it_returns_error_for_nonexistent_id()
    {
        $nonexistentId = 999; // ID que no existe
        $response = $this->get("api/leads/{$nonexistentId}");

        $response->assertStatus(404)
                ->assertJson(['meta' => ['success' => false, 'errors' => ['No lead found']]]);
    }

    /** @test */
    public function authenticated_user_can_create_aspirant()
    {
        $user = UserFactory::new(['role' => 'manager'])->create();
        $token = auth()->login($user);

        $data = [
            'name' => 'Nuevo Aspirante',
            'source' => 'Fuente de aspirante',
            'owner' => $user->id,
        ];

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])
                        ->post('api/leads', $data);

        $response->assertStatus(200)
                ->assertJson(['meta' => ['success' => true]])
                ->assertJsonStructure(['data']);
    }

    public function authenticated_user_cannot_create_aspirant()
    {
        $user = UserFactory::new(['role' => 'agent'])->create();
        $token = auth()->login($user);

        $data = [
            'name' => 'Nuevo Aspirante',
            'source' => 'Fuente de aspirante',
            'owner' => $user->id,
        ];

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])
                        ->post('api/leads', $data);

        $response->assertStatus(401)
                ->assertJson(['meta' => ['success' => false, 'errors' => ['Profile not authorized to perform this action']]]);
    }

    /** @test */
    public function unauthenticated_user_cannot_create_aspirant()
    {
        $data = [
            'name' => 'Nuevo Aspirante',
            'source' => 'Fuente de aspirante',
            'owner' => 1, // Id de un usuario válido
        ];

        $response = $this->post('api/leads', $data);

        $response->assertStatus(401);
    }
}