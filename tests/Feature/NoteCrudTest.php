<?php

namespace Tests\Feature;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoteCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_sent_to_login(): void
    {
        $this->get(route('notes.index'))->assertRedirect(route('login'));
    }

    public function test_humans_can_see_the_list_of_notes(): void
    {
        $note = Note::factory()->create(['title' => 'thank you sir']);

        $this->actingAs(User::factory()->create())
            ->get(route('notes.index'))
            ->assertOk()
            ->assertSee('thank you sir')
            ->assertSee($note->user->name);
    }

    public function test_humans_can_create_a_note(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('notes.store'), [
            'title' => 'please pass me',
            'body' => 'I deployed it and everything.',
        ]);

        $note = Note::firstOrFail();
        $response->assertRedirect(route('notes.show', $note));
        $this->assertSame($user->id, $note->user_id);
        $this->assertSame('please pass me', $note->title);
    }

    public function test_a_note_needs_a_title_and_body(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('notes.store'), ['title' => '', 'body' => ''])
            ->assertSessionHasErrors(['title', 'body']);

        $this->assertDatabaseCount('notes', 0);
    }

    public function test_humans_can_read_one_note(): void
    {
        $note = Note::factory()->create(['body' => 'the cornfield was scary']);

        $this->actingAs(User::factory()->create())
            ->get(route('notes.show', $note))
            ->assertOk()
            ->assertSee('the cornfield was scary');
    }

    public function test_authors_can_update_their_note(): void
    {
        $note = Note::factory()->create();

        $this->actingAs($note->user)
            ->get(route('notes.edit', $note))
            ->assertOk();

        $this->actingAs($note->user)
            ->put(route('notes.update', $note), ['title' => 'fixed typo', 'body' => 'new body'])
            ->assertRedirect(route('notes.show', $note));

        $this->assertSame('fixed typo', $note->fresh()->title);
    }

    public function test_authors_can_delete_their_note(): void
    {
        $note = Note::factory()->create();

        $this->actingAs($note->user)
            ->delete(route('notes.destroy', $note))
            ->assertRedirect(route('notes.index'));

        $this->assertModelMissing($note);
    }

    public function test_other_humans_cannot_edit_or_delete_someone_elses_note(): void
    {
        $note = Note::factory()->create();
        $stranger = User::factory()->create();

        $this->actingAs($stranger)->get(route('notes.edit', $note))->assertForbidden();
        $this->actingAs($stranger)->put(route('notes.update', $note), ['title' => 'hacked', 'body' => 'hacked'])->assertForbidden();
        $this->actingAs($stranger)->delete(route('notes.destroy', $note))->assertForbidden();

        $this->assertModelExists($note);
        $this->assertNotSame('hacked', $note->fresh()->title);
    }
}
