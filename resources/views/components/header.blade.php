{{-- resources/views/components/app-header.blade.php  →  pemakaian: <x-app-header /> --}}
@props([
    'workspace'     => 'JAVAFX',
    'subtitle'      => 'Forex & Commodities Brokerage',
    'badge'         => 'LIVE',
    'logo'          => null,
    'workspaces'    => [],
    'sourceLabel'   => 'Source: Google Sheets',
    'sourceUrl'     => '#',
    'briefLabel'    => 'Executive Brief',
    'briefUrl'      => '#',
 
    // ---- notifikasi & menu profil ----
    'notifications' => null,   // angka manual; null = hitung dari $user->unreadNotifications
    'notifUrl'      => '#',
    'kpiUrl'        => '#',
    'teamUrl'       => '#',
    'accountsUrl'   => '#',
    'adminLinks'    => true,   // tampilkan KPI configuration, Team access, Accounts
])
 
@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Route;
 
    $user      = auth()->user();
    $name      = $user->name ?? 'Reinhart';
    $role      = $user->role ?? 'Manager';
    $roleLabel = Str::headline((string) $role);
 
    // Inisial maksimal 2 huruf: "Louie Jason" → "LJ"
    $words   = preg_split('/\s+/', trim($name)) ?: [$name];
    $initial = mb_strtoupper(collect($words)->take(2)->map(fn ($w) => mb_substr($w, 0, 1))->implode(''));
 
    // Handle: username → bagian depan email → nama depan
    $handle = $user->username
        ?? (Str::before($user->email ?? '', '@') ?: Str::lower($words[0]));
 
    $notifCount = $notifications
        ?? (($user && method_exists($user, 'unreadNotifications')) ? $user->unreadNotifications()->count() : 0);
    $notifLabel = $notifCount > 99 ? '99+' : $notifCount;
 
    $logout = Route::has('logout') ? route('logout') : null;
    $profileUrl = Route::has('profile.edit') ? route('profile.edit') : '#';
@endphp
 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap">
<style>
    .hdr, .hdr *{box-sizing:border-box}
    header.hdr#appHeader{
        --hdr-h:70px;
        --hdr-pad:16px;
        position:sticky;top:0;z-index:40;
        display:flex;align-items:center;justify-content:space-between;gap:12px;
        min-height:var(--hdr-h);
        width:auto;max-width:none;
        margin-left:calc(50% - 50vw);margin-right:calc(50% - 50vw);
        padding:10px var(--hdr-pad);
        background:var(--page-bg,#141414);color:#fff;
        font-family:'Inter',system-ui,sans-serif;font-size:15px;line-height:1.3;
        border-bottom:1px solid #262626;
    }
    .hdr a{text-decoration:none;color:inherit}
    .hdr button{font-family:inherit}
    .hdr-left{display:flex;align-items:center;gap:10px;min-width:0;flex:0 1 auto}
    .hdr-right{display:flex;align-items:center;gap:10px;flex:none}
 
    /* hamburger (hanya mobile) */
    .hdr-burger{display:none;width:44px;height:44px;flex:none;border:1px solid #333;border-radius:10px;background:#1b1b1b;color:#fff;font-size:22px;cursor:pointer;place-items:center}
 
    /* dropdown (workspace) */
    .hdr details{position:relative;min-width:0}
    .hdr summary{list-style:none;cursor:pointer}
    .hdr summary::-webkit-details-marker{display:none}
    .hdr .menu{position:absolute;top:calc(100% + 8px);z-index:60;min-width:220px;background:#1e1e1e;border:1px solid #444;border-radius:10px;padding:6px;box-shadow:0 10px 30px rgba(0,0,0,.5)}
    .hdr .menu a,.hdr .menu button{display:flex;align-items:center;gap:10px;width:100%;padding:10px 12px;border:0;background:none;color:#fff;border-radius:7px;font-size:14px;text-align:left;cursor:pointer}
    .hdr .menu a:hover,.hdr .menu button:hover{background:#2d2d2d}
    .hdr .menu small{display:block;color:#9a9a9a;font-size:12px}
 
    /* workspace switcher */
    .hdr .ws>summary{display:flex;align-items:center;gap:12px;height:52px;padding:0 14px 0 12px;border:1px solid #363636;border-radius:10px;background:#171717;max-width:320px;min-width:0}
    .hdr .logo{width:36px;height:36px;flex:none;border-radius:8px;background:#A21E1E;display:grid;place-items:center;overflow:hidden;font-size:11px;font-style:italic;font-weight:600;color:#fff}
    .hdr .logo img{width:100%;height:100%;object-fit:cover}
    .hdr .ws-txt{min-width:0;flex:1}
    .hdr .ws-t1{display:flex;align-items:center;gap:8px;font-weight:600;font-size:15px;white-space:nowrap}
    .hdr .live{font-size:10px;font-weight:600;line-height:1;padding:3px 6px;border-radius:4px;background:#dcdcdc;color:#222}
    .hdr .ws-t2{display:block;font-size:13px;color:#cfcfcf;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .hdr .ws .chev{font-size:12px;color:#aaa;flex:none}
    .hdr .ws .menu{left:0;width:min(320px,90vw)}
    .hdr .ws .menu .logo{width:30px;height:30px;background:#A21E1E}
 
    /* tombol aksi */
    .hdr .hb{position:relative;display:inline-flex;align-items:center;justify-content:center;gap:8px;height:44px;padding:0 14px;border:1px solid #333;border-radius:10px;background:#1d1d1d;color:#fff;font-weight:500;font-size:14px;white-space:nowrap;cursor:pointer}
    .hdr .hb:hover{background:#262626}
    .hdr .hb i{font-size:17px}
 
    /* notifikasi */
    .hdr .bell{width:48px;height:48px;padding:0;border-radius:12px}
    .hdr .bell i{font-size:19px}
    .hdr .bell .count{
        position:absolute;top:-9px;right:-10px;
        min-width:24px;height:22px;padding:0 6px;
        display:grid;place-items:center;
        font-size:12px;font-weight:700;line-height:1;color:#fff;
        background:#c8262b;border:2px solid var(--page-bg,#141414);border-radius:999px;
    }
    .hdr .hdr-sep{width:1px;height:40px;margin:0 6px;background:#2a2a2a;flex:none}
 
    /* ---------- menu profil ---------- */
    .hdr .um>summary{display:flex;align-items:center;gap:12px;border-radius:12px}
    .hdr .um>summary:focus-visible{outline:2px solid #fff;outline-offset:3px}
    .hdr .av{width:48px;height:48px;border:1px solid #333;border-radius:12px;background:#1d1d1d;display:grid;place-items:center;font-size:15px;font-weight:600;letter-spacing:.02em;flex:none}
    .hdr .utxt{display:flex;align-items:center;gap:14px}
    .hdr .uname{display:block;font-weight:600;font-size:15px;line-height:1.25}
    .hdr .urole{display:block;font-size:15px;color:#b5b5b5;line-height:1.25}
    .hdr .uchev{font-size:13px;color:#a1a1a1;transition:transform .2s ease}
    .hdr .um[open] .uchev{transform:rotate(180deg)}
 
    .hdr .um-menu{
        position:absolute;top:calc(100% + 10px);right:0;z-index:60;
        width:340px;max-width:calc(100vw - 24px);
        padding:0;overflow:hidden;
        background:#161616;border:1px solid #2c2c2c;border-radius:14px;
        box-shadow:0 18px 44px rgba(0,0,0,.6);
    }
    .hdr .um-id{padding:20px 24px 18px}
    .hdr .um-id b{display:block;font-size:16px;font-weight:600;color:#fff}
    .hdr .um-id .um-role{display:block;margin-top:6px;font-size:15px;color:#c4c4c4}
    .hdr .um-id small{display:block;margin-top:8px;font-size:14px;color:#7d7d7d}
    .hdr .um-sep{display:block;height:1px;margin:0;border:0;background:#262626}
 
    .hdr .um-item{
        display:flex;align-items:center;gap:16px;
        width:100%;height:60px;padding:0 24px;
        border:0;background:none;
        font-size:15px;color:#cfcfcf;text-align:left;cursor:pointer;
        transition:background .15s ease,color .15s ease;
    }
    .hdr .um-item i{font-size:18px;color:#9a9a9a;flex:none;transition:color .15s ease}
    .hdr .um-item:hover,.hdr .um-item:focus-visible{background:#1e1e1e;color:#fff;outline:0}
    .hdr .um-item:hover i,.hdr .um-item:focus-visible i{color:#fff}
    .hdr .um-menu form{margin:0}
 
    /* Appearance */
    .hdr .um-appear{display:flex;align-items:center;justify-content:space-between;gap:12px;min-height:72px;padding:0 24px;font-size:15px;color:#cfcfcf}
    .hdr .um-seg{display:flex;gap:2px;padding:4px;border:1px solid #2c2c2c;border-radius:12px;background:#101010}
    .hdr .um-seg button{
        width:38px;height:34px;display:grid;place-items:center;
        border:0;border-radius:8px;background:transparent;
        font-size:16px;color:#9a9a9a;cursor:pointer;
        transition:background .15s ease,color .15s ease;
    }
    .hdr .um-seg button:hover{color:#fff}
    .hdr .um-seg button[aria-checked="true"]{background:#2a2a2a;color:#fff}
    .hdr .um-seg button:focus-visible{outline:2px solid #fff;outline-offset:1px}
 
    /* ---------- responsif ---------- */
    @media(max-width:1000px){
        .hdr .hb .txt{display:none}
        .hdr .hb{width:44px;padding:0}
        .hdr .bell{width:44px;height:44px}
        .hdr .utxt{display:none}
        .hdr .av{width:44px;height:44px}
    }
    .hdr-spacer{display:none}
    @media(max-width:700px){
        .hdr-spacer{display:block;height:64px}
        header.hdr#appHeader{
            --hdr-h:64px;--hdr-pad:12px;
            position:fixed;top:0;left:0;right:0;
            width:auto;max-width:none;margin:0;
            gap:10px;padding:10px var(--hdr-pad);
            border-bottom:1px solid #262626;
            background:rgba(20,20,20,.95);
            backdrop-filter:blur(8px);
        }
        .hdr-burger{display:grid}
        .hdr-left{flex:1 1 auto;gap:10px}
        .hdr-right{gap:10px}
        .hdr .hdr-sep{display:none}
        .hdr .ws{flex:1 1 auto;min-width:0}
        .hdr .ws>summary{height:46px;padding:0 12px;gap:10px;max-width:none;border-radius:10px;border-color:#363636;background:#171717}
        .hdr .logo{width:32px;height:32px;font-size:9px;border-radius:7px;background:#A21E1E}
        .hdr .ws-t1{font-size:14px}
        .hdr .ws-t2{display:none}
        .hdr .ws .chev{margin-left:auto}
        .hdr .hb,.hdr .av{width:44px;height:44px}
        .hdr .ws .menu{position:fixed;left:12px;right:12px;top:calc(var(--hdr-h) + 6px);width:auto}
        .hdr .um-menu{position:fixed;left:12px;right:12px;top:calc(var(--hdr-h) + 6px);width:auto;max-width:360px;margin-left:auto}
    }
    @media(max-width:480px){
        .hdr .hide-xs{display:none}
    }
    @media(max-width:360px){
        .hdr .ws .chev{display:none}
        .hdr .live{display:none}
        .hdr .bell .count{right:-8px}
    }
    @media(prefers-reduced-motion:reduce){
        .hdr *{transition:none!important}
    }
</style>
 
<div class="hdr-spacer"></div>
<header class="hdr" id="appHeader">
    <div class="hdr-left">
        <button type="button" class="hdr-burger" id="hdrBurger" aria-label="Open menu"><i class="bi bi-list"></i></button>
 
        <details class="ws" id="wsMenu">
            <summary aria-label="Switch workspace">
                <span class="logo">@if($logo)<img src="{{ $logo }}" alt="">@else JAVA @endif</span>
                <span class="ws-txt">
                    <span class="ws-t1">{{ $workspace }} @if($badge)<span class="live">{{ $badge }}</span>@endif</span>
                    <span class="ws-t2">{{ $subtitle }}</span>
                </span>
                <i class="bi bi-chevron-down chev"></i>
            </summary>
            @if(count($workspaces))
                <div class="menu">
                    @foreach($workspaces as $w)
                        <a href="{{ $w['url'] ?? '#' }}">
                            <span class="logo">@if(!empty($w['logo']))<img src="{{ $w['logo'] }}" alt="">@else JAVA @endif</span>
                            <span>{{ $w['name'] }}<small>{{ $w['subtitle'] ?? '' }}</small></span>
                        </a>
                    @endforeach
                </div>
            @endif
        </details>
    </div>
 
    <div class="hdr-right">
        <a href="{{ $sourceUrl }}" class="hb" title="{{ $sourceLabel }}" aria-label="{{ $sourceLabel }}"><i class="bi bi-database"></i><span class="txt">{{ $sourceLabel }}</span></a>
        <a href="{{ $briefUrl }}" class="hb hide-xs" title="{{ $briefLabel }}" aria-label="{{ $briefLabel }}"><i class="bi bi-printer"></i><span class="txt">{{ $briefLabel }}</span></a>
 
        {{-- Notifikasi --}}
        <a href="{{ $notifUrl }}" class="hb bell" title="Notifications" aria-label="Notifications{{ $notifCount ? ', '.$notifCount.' unread' : '' }}">
            <i class="bi bi-bell"></i>
            @if($notifCount > 0)<span class="count">{{ $notifLabel }}</span>@endif
        </a>
 
        <span class="hdr-sep" aria-hidden="true"></span>
 
        {{-- Menu profil --}}
        <details class="um" id="userMenu">
            <summary aria-label="User menu">
                <span class="av">{{ $initial }}</span>
                <span class="utxt">
                    <span>
                        <span class="uname">{{ $name }}</span>
                        <span class="urole">{{ $roleLabel }}</span>
                    </span>
                    <i class="bi bi-chevron-down uchev"></i>
                </span>
            </summary>
 
            <div class="um-menu" role="menu">
                <a href="{{ $profileUrl }}" class="um-id" style="display:block" role="menuitem">
                    <b>{{ $name }}</b>
                    <span class="um-role">{{ $roleLabel }}</span>
                    <small>&#64;{{ $handle }} · {{ $roleLabel }}</small>
                </a>
 
                @if($adminLinks)
                    <hr class="um-sep">
                    <a href="{{ $kpiUrl }}" class="um-item" role="menuitem"><i class="bi bi-sliders"></i>KPI configuration</a>
                    <hr class="um-sep">
                    <a href="{{ $teamUrl }}" class="um-item" role="menuitem"><i class="bi bi-person-gear"></i>Team access</a>
                    <hr class="um-sep">
                    <a href="{{ $accountsUrl }}" class="um-item" role="menuitem"><i class="bi bi-people"></i>Accounts</a>
                @endif
 
                <hr class="um-sep">
                <div class="um-appear">
                    <span id="appearLabel">Appearance</span>
                    <div class="um-seg" id="appearSeg" role="radiogroup" aria-labelledby="appearLabel">
                        <button type="button" role="radio" aria-checked="false" data-mode="system" title="System" aria-label="System"><i class="bi bi-display"></i></button>
                        <button type="button" role="radio" aria-checked="false" data-mode="light" title="Light" aria-label="Light"><i class="bi bi-sun"></i></button>
                        <button type="button" role="radio" aria-checked="true" data-mode="dark" title="Dark" aria-label="Dark"><i class="bi bi-moon"></i></button>
                    </div>
                </div>
 
                @if($logout)
                    <hr class="um-sep">
                    <form method="POST" action="{{ $logout }}">@csrf
                        <button type="submit" class="um-item" role="menuitem"><i class="bi bi-box-arrow-right"></i>Sign out</button>
                    </form>
                @endif
            </div>
        </details>
    </div>
</header>
 
<script>
(() => {
    /* ---------- buka/tutup dropdown ---------- */
    const menus = [document.getElementById('wsMenu'), document.getElementById('userMenu')];
    document.addEventListener('click', e => menus.forEach(m => m && !m.contains(e.target) && m.removeAttribute('open')));
    document.addEventListener('keydown', e => e.key === 'Escape' && menus.forEach(m => m && m.removeAttribute('open')));
    menus.forEach(m => m && m.addEventListener('toggle', () => m.open && menus.forEach(o => o && o !== m && o.removeAttribute('open'))));
    document.getElementById('hdrBurger').addEventListener('click', () => window.dispatchEvent(new CustomEvent('toggle-sidebar')));
 
    /* ---------- Appearance: system / light / dark ---------- */
    const KEY  = 'appearance';
    const root = document.documentElement;
    const mq   = window.matchMedia('(prefers-color-scheme: dark)');
    const seg  = document.getElementById('appearSeg');
 
    const saved = () => { try { return localStorage.getItem(KEY) || 'dark'; } catch (e) { return 'dark'; } };
 
    const apply = (mode, persist) => {
        const resolved = mode === 'system' ? (mq.matches ? 'dark' : 'light') : mode;
 
        root.dataset.appearance = mode;       // pilihan user: system | light | dark
        root.dataset.theme      = resolved;   // hasil akhir: light | dark
        root.classList.toggle('dark', resolved === 'dark');
        root.style.colorScheme  = resolved;
 
        seg.querySelectorAll('button').forEach(b => b.setAttribute('aria-checked', String(b.dataset.mode === mode)));
 
        if (persist) { try { localStorage.setItem(KEY, mode); } catch (e) {} }
        window.dispatchEvent(new CustomEvent('appearance-change', { detail: { mode, resolved } }));
    };
 
    seg.addEventListener('click', e => {
        const btn = e.target.closest('button[data-mode]');
        if (btn) apply(btn.dataset.mode, true);
    });
 
    // Navigasi panah kiri/kanan pada radio group
    seg.addEventListener('keydown', e => {
        if (!['ArrowLeft', 'ArrowRight'].includes(e.key)) return;
        const btns = [...seg.querySelectorAll('button')];
        const i = btns.findIndex(b => b.getAttribute('aria-checked') === 'true');
        const next = btns[(i + (e.key === 'ArrowRight' ? 1 : btns.length - 1)) % btns.length];
        next.focus(); apply(next.dataset.mode, true);
        e.preventDefault();
    });
 
    mq.addEventListener('change', () => { if (saved() === 'system') apply('system', false); });
 
    apply(saved(), false);
})();
</script>
 