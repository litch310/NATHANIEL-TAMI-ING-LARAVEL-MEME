@csrf

<label class="field">
    title
    <input type="text" name="title" value="{{ old('title', $note->title ?? '') }}" maxlength="100" required autofocus>
</label>
@error('title')
    <p class="error">{{ $message }}</p>
@enderror

<label class="field">
    your note
    <textarea name="body" maxlength="2000" required>{{ old('body', $note->body ?? '') }}</textarea>
</label>
@error('body')
    <p class="error">{{ $message }}</p>
@enderror
