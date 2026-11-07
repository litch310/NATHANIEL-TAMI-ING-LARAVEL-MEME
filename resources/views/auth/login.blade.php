<x-layouts.paper title="are you human?">
    <span class="stamp">humans only beyond this point</span>
    <h1>are you human?</h1>
    <p class="lede">prove it. log in to open your present.</p>

    <form method="POST" action="{{ route('login.store') }}">
        @csrf

        <label class="field">
            email
            <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
        </label>
        @error('email')
            <p class="error">{{ $message }}</p>
        @enderror

        <label class="field">
            password
            <input type="password" name="password" required autocomplete="current-password">
        </label>
        @error('password')
            <p class="error">{{ $message }}</p>
        @enderror

        <label class="remember">
            <input type="checkbox" name="remember" value="1">
            remember me (I'm forgetful, like a human)
        </label>

        <x-fake-captcha />

        <button type="submit" class="button">let me in</button>
    </form>

    <p class="switch">new human? <a href="{{ route('register') }}">create an account</a></p>
</x-layouts.paper>
