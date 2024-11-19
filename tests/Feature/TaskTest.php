<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;
use App\Models\Task;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_task()
    {
        $user = User::factory()->create();

        $taskData = [
            'title' => 'Nova Tarefa',
        ];

        $response = $this->actingAs($user)->postJson('/tasks', $taskData);
        $response->assertStatus(201);

        $this->assertDatabaseHas('tasks', $taskData);
    }

    /** @test */
    public function it_fetches_all_tasks()
    {
        $user = User::factory()->create();
        Task::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson('/tasks');
        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    /** @test */
    public function it_validates_task_creation()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/tasks', []);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['title']);
    }
}
