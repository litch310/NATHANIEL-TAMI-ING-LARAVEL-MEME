<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_sent_to_the_login_page(): void
    {
        $this->get('/')->assertRedirect(route('login'));
    }

    public function test_logged_in_humans_see_the_gift_and_the_human_count(): void
    {
        User::factory()->count(2)->create();
        $human = User::factory()->create(['name' => 'Sir Zeus']);

        $this->actingAs($human)
            ->get('/')
            ->assertOk()
            ->assertSee('images/ai-meme.png')
            ->assertSee('Nathaniel Tami-ing')
            ->assertSee('Sir Zeus')
            ->assertSee('of 3 so far');
    }
}
