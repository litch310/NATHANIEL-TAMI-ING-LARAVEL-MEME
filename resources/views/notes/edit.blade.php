<x-layouts.paper title="edit note" wide>
    @include('notes._topbar')

    <span class="stamp">update</span>
    <h1>edit your note</h1>
    <p class="lede">fix the typo. we all saw it.</p>

    <form method="POST" action="{{ route('notes.update', $note) }}">
        @method('PUT')
        @include('notes._form')

        <div class="actions">
            <button type="submit" class="button">save changes</button>
            <a href="{{ route('notes.show', $note) }}">cancel</a>
        </div>
    </form>
</x-layouts.paper>
