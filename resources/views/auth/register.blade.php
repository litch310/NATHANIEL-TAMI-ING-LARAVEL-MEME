<x-layouts.paper title="become a verified human">
    <span class="stamp">human registration office</span>
    <h1>become a verified human</h1>
    <p class="lede">one account per human. robots, please leave.</p>

    <form method="POST" action="{{ route('register.store') }}">
        @csrf

        <label class="field">
            your name
            <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
        </label>
        @error('name')
            <p class="error">{{ $message }}</p>
        @enderror

        <label class="field">
            email
            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
        </label>
        @error('email')
            <p class="error">{{ $message }}</p>
        @enderror

        <label class="field">
            password
            <input type="password" name="password" required autocomplete="new-password">
        </label>
        @error('password')
            <p class="error">{{ $message }}</p>
        @enderror

        <label class="field">
            password again (humans make typos)
            <input type="password" name="password_confirmation" required autocomplete="new-password">
        </label>

        <x-fake-captcha />

        <button type="submit" class="button">I am human, sign me up</button>
    </form>

    <p class="switch">already human? <a href="{{ route('login') }}">log in</a></p>
</x-layouts.paper>
