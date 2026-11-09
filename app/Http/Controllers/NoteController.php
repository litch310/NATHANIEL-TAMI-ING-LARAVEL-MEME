<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Models\Note;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Notes: every logged-in human can read all notes,
 * but only the author can edit or delete their own.
 */
class NoteController extends Controller
{
    /**
     * Read: list every note, newest first.
     */
    public function index(): View
    {
        return view('notes.index', [
            'notes' => Note::with('user')->latest()->paginate(10),
        ]);
    }

    /**
     * Create: show the empty form.
     */
    public function create(): View
    {
        return view('notes.create');
    }

    /**
     * Create: save the new note.
     */
    public function store(StoreNoteRequest $request): RedirectResponse
    {
        $note = $request->user()->notes()->create($request->validated());

        return redirect()->route('notes.show', $note)->with('status', 'note saved.');
    }

    /**
     * Read: show one note.
     */
    public function show(Note $note): View
    {
        return view('notes.show', ['note' => $note->load('user')]);
    }

    /**
     * Update: show the form filled with the note.
     */
    public function edit(Request $request, Note $note): View
    {
        $this->ensureOwner($request, $note);

        return view('notes.edit', ['note' => $note]);
    }

    /**
     * Update: save the changes.
     */
    public function update(StoreNoteRequest $request, Note $note): RedirectResponse
    {
        $this->ensureOwner($request, $note);

        $note->update($request->validated());

        return redirect()->route('notes.show', $note)->with('status', 'note updated.');
    }

    /**
     * Delete: remove the note.
     */
    public function destroy(Request $request, Note $note): RedirectResponse
    {
        $this->ensureOwner($request, $note);

        $note->delete();

        return redirect()->route('notes.index')->with('status', 'note deleted.');
    }

    /**
     * Stop anyone but the author from changing a note.
     */
    private function ensureOwner(Request $request, Note $note): void
    {
        abort_unless($note->user_id === $request->user()->id, 403, 'That note belongs to another human.');
    }
}
