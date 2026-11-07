<div>
    <label class="captcha" data-captcha>
        <input type="checkbox" name="not_a_robot" value="1" @checked(old('not_a_robot'))>
        <span class="tick" aria-hidden="true"></span>
        <span class="label">
            I'm not a robot
            <small aria-live="polite"></small>
        </span>
        <span class="brand" aria-hidden="true">
            <strong>NOT A FAKE<br>CAPTCHA™</strong>
            privacy · trust me
        </span>
    </label>
    @error('not_a_robot')
        <p class="error">{{ $message }}</p>
    @enderror
</div>
