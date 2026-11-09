<x-layouts.paper :title="$note->title" wide>
    @include('notes._topbar')

    <span class="stamp">read</span>
    <h1 class="note-title">{{ $note->title }}</h1>
    <p class="meta">
        by {{ $note->user->name }} · {{ $note->created_at->format('M j, Y g:i A') }}
        @if ($note->updated_at->gt($note->created_at)) · edited @endif
    </p>

    <div class="note-body">{{ $note->body }}</div>

    @if ($note->user_id === auth()->id())
        <div class="actions">
            <a href="{{ route('notes.edit', $note) }}" class="button small">edit</a>
            <form method="POST" action="{{ route('notes.destroy', $note) }}" onsubmit="return confirm('Delete this note for real?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="button small danger">delete</button>
            </form>
        </div>
    @endif
</x-layouts.paper>
