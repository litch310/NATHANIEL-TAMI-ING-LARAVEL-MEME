<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} — for Sir Zeus</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&family=Patrick+Hand&family=VT323&display=swap" rel="stylesheet">
    <style>
        :root {
            --paper: #f2ead8;
            --ink: #151515;
            --red: #d9382b;
            --yellow: #f6c445;
            --night: #10141c;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1.25rem;
            padding: 2.5rem 1rem;
            overflow-x: hidden;
            font-family: 'Patrick Hand', 'Comic Sans MS', cursive;
            font-size: 1.25rem;
            color: var(--ink);
            background-color: var(--paper);
            background-image: radial-gradient(rgba(21, 21, 21, 0.13) 1px, transparent 1px);
            background-size: 22px 22px;
            transition: background-color 0.15s, color 0.15s;
        }

        body.night {
            --ink: #f2ead8;
            background-color: var(--night);
            background-image: radial-gradient(rgba(242, 234, 216, 0.08) 1px, transparent 1px);
        }

        .stamp {
            display: inline-block;
            padding: 0.1rem 0.6rem;
            border: 2px solid var(--red);
            color: var(--red);
            font-family: 'Permanent Marker', cursive;
            font-size: 0.85rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            transform: rotate(-4deg);
        }

        h1 {
            max-width: 16ch;
            font-family: 'Permanent Marker', cursive;
            font-weight: 400;
            font-size: clamp(2rem, 6vw, 3.4rem);
            line-height: 1.05;
            text-align: center;
        }

        .subtitle {
            max-width: 32ch;
            min-height: 1.4em;
            text-align: center;
            line-height: 1.3;
        }

        /* ---------- The present ---------- */
        .stage {
            position: relative;
            width: 230px;
            height: 240px;
            margin-top: 1rem;
            transition: transform 0.3s cubic-bezier(.5, -0.6, .5, 1.6);
        }

        .gift {
            position: absolute;
            inset: 0;
            border: none;
            background: none;
            font: inherit;
            cursor: pointer;
            animation: idle 2.6s ease-in-out infinite;
        }

        .gift:focus-visible { outline: 3px dashed var(--ink); outline-offset: 12px; }

        .box, .lid {
            position: absolute;
            border: 3px solid #151515;
            background: var(--red);
        }

        .box {
            bottom: 0;
            left: 18px;
            width: 190px;
            height: 150px;
            box-shadow: 7px 7px 0 #151515;
            background-image: repeating-linear-gradient(-45deg, transparent 0 9px, rgba(0, 0, 0, 0.12) 9px 11px);
            background-color: var(--red);
        }

        .lid {
            top: 46px;
            left: 6px;
            width: 214px;
            height: 46px;
            z-index: 2;
            box-shadow: 0 5px 0 #151515;
        }

        .box::before, .lid::before {
            content: '';
            position: absolute;
            top: -3px;
            bottom: -3px;
            left: 50%;
            width: 32px;
            transform: translateX(-50%);
            border-inline: 3px solid #151515;
            background: var(--yellow);
        }

        .bow {
            position: absolute;
            top: -44px;
            left: 50%;
            width: 110px;
            height: 46px;
            transform: translateX(-50%);
        }

        .bow::before, .bow::after {
            content: '';
            position: absolute;
            bottom: 0;
            width: 50px;
            height: 38px;
            border: 3px solid #151515;
            border-radius: 50% 50% 8% 50%;
            background: var(--yellow);
        }

        .bow::before { left: 2px; transform: rotate(-22deg); }
        .bow::after { right: 2px; transform: rotate(22deg) scaleX(-1); }

        @keyframes idle {
            0%, 100% { transform: rotate(0); }
            50% { transform: rotate(-2deg) translateY(-4px); }
        }

        .gift.shaking { animation: shake 0.1s steps(2) infinite; }

        @keyframes shake {
            0% { transform: translate(-5px, 1px) rotate(-3deg); }
            100% { transform: translate(5px, -1px) rotate(3deg); }
        }

        .gift.opened { animation: none; cursor: default; }
        .gift.opened .lid { animation: lid-fly 0.9s cubic-bezier(.2, .8, .3, 1) forwards; }
        .gift.opened .box { animation: box-drop 0.7s 0.25s ease-in forwards; }

        @keyframes lid-fly {
            to { transform: translate(240px, -380px) rotate(400deg); }
        }

        @keyframes box-drop {
            to { transform: translateY(140px) rotate(8deg); opacity: 0; }
        }

        /* ---------- The meme ---------- */
        .meme {
            display: none;
            position: relative;
            width: min(90vw, 400px);
            margin-top: 1.25rem;
            padding: 12px 12px 0;
            background: #fffdf6;
            border: 3px solid #151515;
            box-shadow: 8px 8px 0 #151515;
        }

        .meme.visible {
            display: block;
            animation: slap 0.35s cubic-bezier(.3, 1.6, .5, 1) both;
        }

        @keyframes slap {
            from { transform: scale(1.6) rotate(8deg); opacity: 0; }
            to { transform: scale(1) rotate(-1.5deg); opacity: 1; }
        }

        .meme::before, .meme::after {
            content: '';
            position: absolute;
            top: -14px;
            width: 90px;
            height: 26px;
            background: rgba(246, 196, 69, 0.75);
            z-index: 3;
        }

        .meme::before { left: -18px; transform: rotate(-32deg); }
        .meme::after { right: -18px; transform: rotate(30deg); }

        .meme-frame {
            position: relative;
            overflow: hidden;
        }

        .meme img {
            display: block;
            width: 100%;
            height: auto;
        }

        .curtain {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 54%;
            display: flex;
            align-items: center;
            justify-content: center;
            border-top: 3px solid #151515;
            background: #fffdf6;
            background-image: repeating-linear-gradient(45deg, transparent 0 12px, rgba(21, 21, 21, 0.07) 12px 14px);
            color: #151515;
            font-family: 'Permanent Marker', cursive;
            font-size: 1.3rem;
            transform-origin: top left;
        }

        .meme.full .curtain { animation: curtain-drop 0.7s cubic-bezier(.5, 0, .7, .4) forwards; }

        @keyframes curtain-drop {
            30% { transform: rotate(14deg); }
            100% { transform: translateY(160%) rotate(28deg); }
        }

        .caption {
            padding: 0.5rem 0 0.6rem;
            text-align: center;
            color: #151515;
            font-size: 1.05rem;
        }

        .name-tag {
            position: absolute;
            top: 66%;
            left: 76%;
            padding: 0.15rem 0.5rem;
            border: 2px solid #151515;
            background: var(--red);
            color: #fff;
            font-family: 'Permanent Marker', cursive;
            font-size: clamp(0.7rem, 2.4vw, 0.95rem);
            white-space: nowrap;
            box-shadow: 3px 3px 0 #151515;
            transform: translate(-50%, -100%) rotate(-4deg) scale(0);
            pointer-events: none;
            z-index: 2;
        }

        .name-tag::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            width: 2px;
            height: 10px;
            background: #151515;
        }

        .meme.full .name-tag { animation: tag-in 0.3s 0.9s cubic-bezier(.3, 1.8, .5, 1) forwards; }

        @keyframes tag-in {
            to { transform: translate(-50%, -100%) rotate(-4deg) scale(1); }
        }

        /* ---------- Bits ---------- */
        .controls { display: none; gap: 1rem; flex-wrap: wrap; justify-content: center; margin-top: 0.75rem; }
        .controls.visible { display: flex; }

        .button {
            padding: 0.45rem 1.1rem;
            border: 3px solid #151515;
            background: var(--yellow);
            color: #151515;
            font: inherit;
            cursor: pointer;
            box-shadow: 4px 4px 0 #151515;
        }

        .button:hover { transform: translate(-1px, -1px); box-shadow: 5px 5px 0 #151515; }
        .button:active { transform: translate(4px, 4px); box-shadow: 0 0 0 #151515; }
        .button.secondary { background: #fffdf6; }

        .scrap {
            position: fixed;
            top: -20px;
            border: 2px solid #151515;
            pointer-events: none;
            z-index: 50;
            animation: fall linear forwards;
        }

        @keyframes fall {
            to { transform: translateY(110vh) rotate(var(--spin)); }
        }

        .clock {
            position: fixed;
            top: 1rem;
            right: 1rem;
            padding: 0.1rem 0.6rem;
            border: 3px solid #f2ead8;
            background: #000;
            color: #ff3b2f;
            font-family: 'VT323', monospace;
            font-size: 2rem;
            letter-spacing: 0.05em;
            visibility: hidden;
        }

        .human-bar {
            position: fixed;
            top: 1rem;
            left: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.3rem 0.4rem 0.3rem 0.8rem;
            border: 2px solid var(--ink);
            font-size: 1rem;
            line-height: 1.15;
        }

        .human-bar strong { font-weight: 400; color: var(--red); }

        .human-bar .button { padding: 0.15rem 0.6rem; font-size: 0.95rem; box-shadow: 3px 3px 0 #151515; }

        .clock.visible { visibility: visible; animation: blink 1s steps(1) infinite; }

        @keyframes blink { 50% { color: #5a120d; } }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; animation-iteration-count: 1 !important; transition-duration: 0.01ms !important; }
        }
    </style>
</head>
<body>
    <div class="human-bar">
        <span>verified human: <strong>{{ $human->name }}</strong><br>human #{{ $human->id }} of {{ $verifiedHumanCount }} so far</span>
        <a href="{{ route('notes.index') }}" class="button">notes</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="button secondary">log out</button>
        </form>
    </div>

    <div class="clock" id="clock" aria-hidden="true">3:00 AM</div>

    <span class="stamp" id="stamp">fragile. handle with prompts.</span>
    <h1 id="title">Sir Zeus, a student left you a present</h1>
    <p class="subtitle" id="subtitle">go on, sir. open it.</p>

    <div class="stage" id="stage">
        <button type="button" class="gift" id="gift" aria-label="Open the present">
            <span class="box"></span>
            <span class="lid"><span class="bow"></span></span>
        </button>
    </div>

    <figure class="meme" id="meme">
        <div class="meme-frame">
            <img src="{{ asset('images/ai-meme.png') }}" alt="Meme: normal people use AI like a therapist or a tutor, while developers at 3 AM are out in a dark cornfield with three AI chatbots, about to be hit by a man with a sickle." width="387" height="516">
            <div class="curtain">(nothing to see here)</div>
            <span class="name-tag">Nathaniel Tami-ing</span>
        </div>
        <figcaption class="caption" id="caption">aww. wholesome.</figcaption>
    </figure>

    <div class="controls" id="controls">
        <button type="button" class="button" id="again">wrap it again</button>
        <button type="button" class="button secondary" id="share">share with the faculty</button>
    </div>

    <script>
        const gift = document.getElementById('gift');
        const stage = document.getElementById('stage');
        const meme = document.getElementById('meme');
        const stamp = document.getElementById('stamp');
        const title = document.getElementById('title');
        const subtitle = document.getElementById('subtitle');
        const caption = document.getElementById('caption');
        const controls = document.getElementById('controls');
        const clock = document.getElementById('clock');

        const dodgeLines = [
            'nope. too slow.',
            'closer. try again.',
            'ugh, fine.',
        ];

        let clickCount = 0;
        let isOpening = false;
        let pendingTimers = [];

        const later = (callback, delay) => pendingTimers.push(setTimeout(callback, delay));

        gift.addEventListener('click', () => {
            if (isOpening) {
                return;
            }

            if (clickCount < 2) {
                const offsetX = (Math.random() > 0.5 ? 1 : -1) * (110 + Math.random() * 80);
                const offsetY = -10 - Math.random() * 50;
                stage.style.transform = `translate(${offsetX}px, ${offsetY}px) rotate(${offsetX / 10}deg)`;
                subtitle.textContent = dodgeLines[clickCount];
                clickCount++;

                return;
            }

            isOpening = true;
            stage.style.transform = '';
            subtitle.textContent = dodgeLines[2];
            gift.classList.add('shaking');

            later(() => {
                gift.classList.remove('shaking');
                gift.classList.add('opened');
                throwScraps();
            }, 1000);

            later(() => {
                stage.style.display = 'none';
                stamp.textContent = 'a heartwarming look at AI';
                title.textContent = 'how normal people use AI';
                subtitle.textContent = 'therapy. homework help. so healthy.';
                meme.classList.add('visible');
            }, 1800);

            later(() => {
                stamp.textContent = 'meanwhile';
                title.textContent = 'and how your students use it';
                subtitle.textContent = 'hold on, what time is it?';
                clock.classList.add('visible');
                document.body.classList.add('night');
            }, 4800);

            later(() => {
                title.textContent = '3 AM. the cornfield.';
                subtitle.textContent = '"one more prompt and it\'s fixed" — your students, the night before the deadline';
                caption.textContent = 'he has been waiting for this.';
                meme.classList.add('full');
                controls.classList.add('visible');
            }, 6600);
        });

        document.getElementById('again').addEventListener('click', () => {
            pendingTimers.forEach(clearTimeout);
            pendingTimers = [];
            clickCount = 0;
            isOpening = false;
            gift.className = 'gift';
            stage.style.display = '';
            stage.style.transform = '';
            meme.className = 'meme';
            controls.classList.remove('visible');
            clock.classList.remove('visible');
            document.body.classList.remove('night');
            stamp.textContent = 'fragile. handle with prompts.';
            title.textContent = 'Sir Zeus, a student left you a present';
            subtitle.textContent = 'go on, sir. open it.';
            caption.textContent = 'aww. wholesome.';
        });

        document.getElementById('share').addEventListener('click', async (event) => {
            const shareButton = event.currentTarget;

            try {
                await navigator.clipboard.writeText(window.location.href);
                shareButton.textContent = 'link copied. spread the suffering.';
            } catch {
                shareButton.textContent = window.location.href;
            }
        });

        function throwScraps() {
            const colors = ['#d9382b', '#f6c445', '#fffdf6', '#151515'];

            for (let index = 0; index < 70; index++) {
                const scrap = document.createElement('span');
                scrap.className = 'scrap';
                scrap.style.left = Math.random() * 100 + 'vw';
                scrap.style.width = 8 + Math.random() * 14 + 'px';
                scrap.style.height = 6 + Math.random() * 10 + 'px';
                scrap.style.background = colors[index % colors.length];
                scrap.style.setProperty('--spin', (Math.random() * 900 - 450) + 'deg');
                scrap.style.animationDuration = 1.8 + Math.random() * 2 + 's';
                scrap.style.animationDelay = Math.random() * 0.4 + 's';
                document.body.appendChild(scrap);
                scrap.addEventListener('animationend', () => scrap.remove());
            }
        }
    </script>
</body>
</html>
