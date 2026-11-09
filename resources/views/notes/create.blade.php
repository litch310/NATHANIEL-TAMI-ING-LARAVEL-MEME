<x-layouts.paper title="write a note" wide>
    @include('notes._topbar')

    <span class="stamp">create</span>
    <h1>write a note</h1>
    <p class="lede">it goes straight into the database. no take-backs. (ok, you can edit it.)</p>

    <form method="POST" action="{{ route('notes.store') }}">
        @include('notes._form')

        <div class="actions">
            <button type="submit" class="button">save note</button>
            <a href="{{ route('notes.index') }}">cancel</a>
        </div>
    </form>
</x-layouts.paper>
