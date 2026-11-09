<div class="topbar">
    <span>
        <a href="{{ route('home') }}">← the present</a>
        · <a href="{{ route('notes.index') }}">all notes</a>
    </span>
    <span class="meta">human: {{ auth()->user()->name }}</span>
</div>

@if (session('status'))
    <p class="flash" role="status">{{ session('status') }}</p>
@endif
