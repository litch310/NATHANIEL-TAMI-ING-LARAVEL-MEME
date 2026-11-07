<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_humans_can_register_and_are_saved_to_the_database(): void
    {
        $this->post(route('register.store'), [
            'name' => 'Nathaniel Tami-ing',
            'email' => 'nathaniel@example.com',
            'password' => 'not-a-robot-123',
            'password_confirmation' => 'not-a-robot-123',
            'not_a_robot' => '1',
        ])->assertRedirect(route('home'));

        $this->assertDatabaseHas('users', ['email' => 'nathaniel@example.com', 'name' => 'Nathaniel Tami-ing']);
        $this->assertAuthenticated();
    }

    public function test_registration_requires_the_captcha(): void
    {
        $this->post(route('register.store'), [
            'name' => 'Beep Boop',
            'email' => 'robot@example.com',
            'password' => 'not-a-robot-123',
            'password_confirmation' => 'not-a-robot-123',
        ])->assertSessionHasErrors('not_a_robot');

        $this->assertDatabaseMissing('users', ['email' => 'robot@example.com']);
    }

    public function test_an_email_can_only_belong_to_one_human(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        $this->post(route('register.store'), [
            'name' => 'Copycat',
            'email' => 'taken@example.com',
            'password' => 'not-a-robot-123',
            'password_confirmation' => 'not-a-robot-123',
            'not_a_robot' => '1',
        ])->assertSessionHasErrors('email');
    }
}
