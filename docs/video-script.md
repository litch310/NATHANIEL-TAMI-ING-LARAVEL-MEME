# Video re-record plan: Nathaniel Tami-ing Laravel Deployment

The current cut is **2:23** and each shot lasts about **3–4 seconds**, often with a big title *and* a subtitle on screen. That's too fast to read. Several steps are also missing or only flashed.

Target length: **about 5–6 minutes.**

## Pacing rules (fixes the "too fast" feeling)

- **Text on screen: at least 5 seconds**, plus 1 extra second for every 10 words. Two lines of text means about 7–8 seconds.
- **One text layer at a time.** Don't put a big "STEP 2" title over code while a subtitle is also running. Show the step card by itself for 2–3 seconds, then cut to the screen.
- **Let each click land.** After every click, hold for about 1 second so viewers see what changed before you cut.
- **Typing in the terminal:** speed it up 2–4×, but play the result (the output) at normal speed and hold it for 3 seconds.
- **Zoom in** (125–150%) on small things: Render form fields, log lines, and the URL bar.
- Number every step card the same way: **STEP 1 of 8 … STEP 8 of 8.** The current cut jumps from STEP 2 to STEP 6.

## What the current cut is missing

| Missing / too short | What to add |
|---|---|
| No CRUD at all | New STEP 7: create, read, edit and delete a note **on the live site** |
| `php artisan test` only flashes for 1 second | Hold on "19 passed" for 3 seconds |
| Postgres: only "New → Postgres" is shown | Show the name, region (same as the web service), the Free plan, the Create button, then copying the **Internal Database URL** |
| Env vars: DB_URL appears for about 2 seconds | Show adding `DB_CONNECTION=pgsql` and `DB_URL` (blurred), then "Save, rebuild and deploy" |
| You never see migrations run on Render | Show the deploy log line where `migrate --force` creates `users` **and** `notes` |
| Live site: you sign up but never log in or open the present | Log in on the live URL, tick the captcha, open the present |
| Keep-awake bot (3 commits) not shown | Short shot of the `/up` health check and the GitHub Actions run |

## Shot list

### Intro (0:00–0:30)
1. Live site: the gift dodges twice, then opens and plays the meme. Let it play fully (about 8 seconds).
2. Black card: "but it only worked on my laptop." (5 seconds)
3. Black card: "so I put it online. free. 24/7. no credit card." (5 seconds)

### STEP 1 of 8: Build it locally (0:30–1:15)
4. Terminal: `composer create-project laravel/laravel nathaniel-tami-ing-laravel-web` (sped up). Hold on "Application key set".
5. `herd link`, then `php artisan --version` → hold on "Laravel Framework 13.x".
6. Browser on `nathaniel-tami-ing-laravel-web.test`: register, tick the captcha, log in. Caption: "this is the local version before deploying".

### STEP 2 of 8: Add CRUD (notes) (1:15–2:15)
7. VS Code, about 6 seconds each, one caption per file:
   - `database/migrations/..._create_notes_table.php`: "a notes table: who wrote it, title, body"
   - `routes/web.php`: highlight `Route::resource('notes', ...)`: "one line = all 7 CRUD routes"
   - `app/Http/Controllers/NoteController.php`: scroll through `store`, `update`, `destroy`: "Create, Read, Update, Delete"
   - `ensureOwner()`: "you can only edit or delete your own notes"
8. Terminal: `php artisan migrate`, hold on DONE.
9. Terminal: `php artisan test`, hold on **19 passed** for 3 seconds. Caption: "8 of these tests are just for CRUD".

### STEP 3 of 8: Get it ready for hosting (2:15–2:50)
10. Dockerfile: highlight PHP 8.4 + Apache + Postgres driver. (6 seconds)
11. `bootstrap/app.php` trustProxies: "trusting the proxy makes every link https". (6 seconds)
12. `.gitignore` `.env`: "my secrets never get uploaded". (5 seconds)

### STEP 4 of 8: Push to GitHub (2:50–3:10)
13. `git add -A`, `git commit -m "Add notes CRUD"`, `git push`. Hold on the push output.
14. GitHub repo page: point at the latest commit. (5 seconds)

### STEP 5 of 8: Database on Render (3:10–3:50)
15. Render → New → **Postgres**. Name, **region Oregon** (same as the web service), **Free** plan → Create.
16. Database page → copy the **Internal Database URL**. Blur it in the edit. Caption: "internal = only my web service can reach it".

### STEP 6 of 8: Web service on Render (3:50–4:40)
17. New → Web Service → connect GitHub → give access to **only this repo** → pick the repo.
18. Docker, branch `main`, region Oregon, **Free** instance.
19. Environment: `APP_ENV=production`, `APP_DEBUG=false`, `SESSION_DRIVER=cookie`, `CACHE_STORE=file`, `APP_KEY` (blurred), `DB_CONNECTION=pgsql`, `DB_URL` (blurred). Zoom in. Give it 8 seconds.
20. Deploy → logs. Zoom on the migration lines (`create_users_table`, `create_notes_table` … DONE) and on "Your service is live". Hold 4 seconds.

### STEP 7 of 8: Test CRUD on the live site (4:40–5:30)
21. Live URL → log in → open the present → click **notes**.
22. **Create:** "+ write a note", type a title and text, save. The green "note saved." message appears.
23. **Read:** back to "all notes": the note is in the list. Click it to open it.
24. **Update:** edit, change the title, save. "note updated." and the "edited" label appear.
25. **Delete:** delete → confirm popup → "note deleted." and the note is gone from the list.
26. Optional: log in as a second account and show there's no edit/delete button on someone else's note.

### STEP 8 of 8: Keep it awake (5:30–5:50)
27. Browser on `/up`: green "Application up".
28. GitHub → Actions → the keep-awake workflow run with a green tick. Caption: "free plans sleep, so a bot visits every 10 minutes".

### Outro (5:50–6:05)
29. "and that's how it went live." (4 seconds)
30. Credits card (6 seconds). Add **"CRUD notes"** to the tech line.
