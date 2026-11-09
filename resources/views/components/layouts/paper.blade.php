@props(['title', 'wide' => false])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} — {{ $title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&family=Patrick+Hand&display=swap" rel="stylesheet">
    <style>
        :root {
            --paper: #f2ead8;
            --card: #fffdf6;
            --ink: #151515;
            --red: #d9382b;
            --yellow: #f6c445;
            --green: #2f8f4e;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1rem;
            font-family: 'Patrick Hand', 'Comic Sans MS', cursive;
            font-size: 1.2rem;
            color: var(--ink);
            background-color: var(--paper);
            background-image: radial-gradient(rgba(21, 21, 21, 0.13) 1px, transparent 1px);
            background-size: 22px 22px;
        }

        .sheet {
            position: relative;
            width: min(100%, 440px);
            padding: 2.2rem 2rem 1.8rem;
            border: 3px solid var(--ink);
            background: var(--card);
            box-shadow: 8px 8px 0 var(--ink);
            transform: rotate(-0.6deg);
        }

        .sheet::before {
            content: '';
            position: absolute;
            top: -16px;
            left: 50%;
            width: 110px;
            height: 28px;
            transform: translateX(-50%) rotate(-3deg);
            background: rgba(246, 196, 69, 0.75);
        }

        .stamp {
            display: inline-block;
            padding: 0.05rem 0.55rem;
            border: 2px solid var(--red);
            color: var(--red);
            font-family: 'Permanent Marker', cursive;
            font-size: 0.8rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            transform: rotate(-3deg);
        }

        h1 {
            margin: 0.6rem 0 0.2rem;
            font-family: 'Permanent Marker', cursive;
            font-weight: 400;
            font-size: 2.3rem;
            line-height: 1.05;
        }

        .lede { margin-bottom: 1.3rem; color: #4a4a4a; }

        form { display: grid; gap: 0.9rem; }

        label.field { display: grid; gap: 0.2rem; }

        .sheet.wide { width: min(100%, 640px); transform: rotate(-0.3deg); }

        input[type="text"], input[type="email"], input[type="password"], textarea {
            width: 100%;
            padding: 0.5rem 0.7rem;
            border: 2px solid var(--ink);
            background: #fff;
            font: inherit;
            color: var(--ink);
            box-shadow: 3px 3px 0 var(--ink);
            outline: none;
        }

        textarea { min-height: 9rem; resize: vertical; line-height: 1.3; }

        input:focus-visible, textarea:focus-visible { background: #fff8dc; }

        /* ---------- Notes (CRUD) ---------- */
        .topbar { display: flex; justify-content: space-between; align-items: center; gap: 1rem; margin-bottom: 0.8rem; font-size: 1.05rem; }
        .topbar a { color: var(--red); }

        .flash {
            margin-bottom: 1rem;
            padding: 0.4rem 0.7rem;
            border: 2px solid var(--green);
            color: var(--green);
            background: #eef8f0;
        }

        .notes { list-style: none; display: grid; gap: 0.8rem; margin: 1.2rem 0; }

        .note {
            padding: 0.7rem 0.9rem;
            border: 2px solid var(--ink);
            background: #fff;
            box-shadow: 3px 3px 0 var(--ink);
        }

        .note h2, .note-title { font-family: 'Permanent Marker', cursive; font-weight: 400; font-size: 1.25rem; line-height: 1.15; }
        .note h2 a { color: var(--ink); text-decoration: none; }
        .note h2 a:hover { text-decoration: underline; }
        .note p { margin-top: 0.25rem; color: #333; overflow-wrap: anywhere; }

        .meta { font-size: 0.95rem; color: #666; }

        .note-body { margin: 1rem 0 1.4rem; white-space: pre-line; overflow-wrap: anywhere; line-height: 1.35; }

        .actions { display: flex; flex-wrap: wrap; gap: 0.8rem; align-items: center; }
        .actions form { display: inline; }
        .actions > a:not(.button) { color: var(--red); }

        a.button { display: inline-block; text-decoration: none; }
        .button.small { margin: 0; padding: 0.2rem 0.8rem; font-size: 1.05rem; box-shadow: 3px 3px 0 var(--ink); }
        .button.danger { background: var(--red); color: #fff; }
        .button.plain { background: var(--card); }

        .empty { margin: 1.5rem 0; text-align: center; color: #666; }

        .pager { display: flex; justify-content: space-between; margin-top: 0.5rem; }
        .pager a { color: var(--red); }

        .error { color: var(--red); font-size: 1rem; }

        .button {
            margin-top: 0.3rem;
            padding: 0.55rem 1.1rem;
            border: 3px solid var(--ink);
            background: var(--yellow);
            color: var(--ink);
            font: inherit;
            font-size: 1.3rem;
            cursor: pointer;
            box-shadow: 4px 4px 0 var(--ink);
        }

        .button:hover { transform: translate(-1px, -1px); box-shadow: 5px 5px 0 var(--ink); }
        .button:active { transform: translate(4px, 4px); box-shadow: 0 0 0 var(--ink); }

        .switch { margin-top: 1.1rem; text-align: center; }
        .switch a { color: var(--red); }

        .remember { display: flex; align-items: center; gap: 0.5rem; font-size: 1.05rem; }
        .remember input { width: 18px; height: 18px; accent-color: var(--ink); }

        /* ---------- The (not) fake captcha ---------- */
        .captcha {
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.75rem 0.9rem;
            border: 2px solid var(--ink);
            background: #f7f7f7;
            cursor: pointer;
            user-select: none;
        }

        .captcha input { position: absolute; opacity: 0; pointer-events: none; }

        .captcha .tick {
            position: relative;
            flex: none;
            width: 30px;
            height: 30px;
            border: 3px solid var(--ink);
            background: #fff;
        }

        .captcha input:focus-visible + .tick { outline: 3px dashed var(--ink); outline-offset: 3px; }

        .captcha.verifying .tick {
            border-color: transparent;
            border-top-color: var(--ink);
            border-right-color: var(--ink);
            border-radius: 50%;
            background: transparent;
            animation: spin 0.7s linear infinite;
        }

        .captcha.verified .tick { border-color: var(--green); background: #fff; }

        .captcha.verified .tick::after {
            content: '';
            position: absolute;
            left: 7px;
            top: -4px;
            width: 9px;
            height: 22px;
            border: solid var(--green);
            border-width: 0 5px 5px 0;
            transform: rotate(40deg);
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .captcha .label { flex: 1; line-height: 1.15; }
        .captcha .label small { display: block; min-height: 1.1em; font-size: 0.85rem; color: #666; }
        .captcha.verified .label small { color: var(--green); }

        .captcha .brand {
            flex: none;
            text-align: center;
            font-size: 0.68rem;
            line-height: 1.1;
            color: #555;
        }

        .captcha .brand strong {
            display: block;
            font-family: 'Permanent Marker', cursive;
            font-size: 0.8rem;
            font-weight: 400;
            color: var(--ink);
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; animation-iteration-count: 1 !important; }
        }
    </style>
</head>
<body>
    <main @class(['sheet', 'wide' => $wide])>
        {{ $slot }}
    </main>

    <script>
        document.querySelectorAll('[data-captcha]').forEach((captcha) => {
            const checkbox = captcha.querySelector('input');
            const note = captcha.querySelector('small');
            let verifyTimer;

            const reset = () => {
                clearTimeout(verifyTimer);
                captcha.classList.remove('verifying', 'verified');
                note.textContent = '';
            };

            checkbox.addEventListener('change', () => {
                reset();

                if (! checkbox.checked) {
                    return;
                }

                captcha.classList.add('verifying');
                note.textContent = 'scanning your soul…';

                verifyTimer = setTimeout(() => {
                    captcha.classList.remove('verifying');
                    captcha.classList.add('verified');
                    note.textContent = 'verified human. this is not a fake captcha.';
                }, 1400);
            });

            if (checkbox.checked) {
                captcha.classList.add('verified');
                note.textContent = 'verified human. this is not a fake captcha.';
            }
        });
    </script>
</body>
</html>
