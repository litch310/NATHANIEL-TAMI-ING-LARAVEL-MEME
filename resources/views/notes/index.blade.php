<x-layouts.paper title="notes" wide>
    @include('notes._topbar')

    <span class="stamp">the suggestion box</span>
    <h1>notes</h1>
    <p class="lede">leave a note. be nice. or at least be funny.</p>

    <a href="{{ route('notes.create') }}" class="button">+ write a note</a>

    @if ($notes->isEmpty())
        <p class="empty">no notes yet. the box is empty. like my brain at 3 AM.</p>
    @else
        <ul class="notes">
            @foreach ($notes as $note)
                <li class="note">
                    <h2><a href="{{ route('notes.show', $note) }}">{{ $note->title }}</a></h2>
                    <p>{{ Str::limit($note->body, 140) }}</p>
                    <div class="actions">
                        <span class="meta">by {{ $note->user->name }} · {{ $note->created_at->diffForHumans() }}</span>
                        @if ($note->user_id === auth()->id())
                            <a href="{{ route('notes.edit', $note) }}" class="button small plain">edit</a>
                            <form method="POST" action="{{ route('notes.destroy', $note) }}" onsubmit="return confirm('Delete this note for real?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="button small danger">delete</button>
                            </form>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>

        @if ($notes->hasPages())
            <nav class="pager" aria-label="Pages">
                <span>@if ($notes->previousPageUrl())<a href="{{ $notes->previousPageUrl() }}">← newer</a>@endif</span>
                <span>@if ($notes->nextPageUrl())<a href="{{ $notes->nextPageUrl() }}">older →</a>@endif</span>
            </nav>
        @endif
    @endif
</x-layouts.paper>
