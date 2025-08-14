<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class)->group('feature', 'api');

test('it creates a user when authenticated', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'sanctum')->postJson('/api/users', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password',
        'age' => 30,
    ]);

    $response->assertStatus(201)
             ->assertJson([
                 'name' => 'John Doe',
                 'email' => 'john@example.com',
                 'age' => 30,
             ]);

    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'age' => 30,
    ]);
});

test('it returns 401 if unauthenticated', function () {
    $response = $this->postJson('/api/users', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password',
        'age' => 25,
    ]);

    $response->assertStatus(401);
});

test('it fails with invalid data', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'sanctum')->postJson('/api/users', [
        'name' => '',
        'email' => 'not-email',
        'age' => 'abc',
    ]);

    $response->assertStatus(422)
             ->assertJsonValidationErrors(['name', 'email', 'age']);
});