@extends('layouts.app')
 
@php
    $selectedMonth = $selectedMonth ?? 'October 2026';
    $months        = $months ?? ['October 2026', 'September 2026', 'August 2026', 'July 2026'];
    $attention     = $attention ?? 1;
    $attentionUrl  = $attentionUrl ?? '#';
    $newUrl        = url('/projects/create');
 
    // Status: completed | in_progress | blocked | overdue
    $projects = $projects ?? [
        ['id' => 1, 'name' => 'Test Notification', 'owner' => 'Jason Judah Pakasi',        'category' => 'Web',               'done' => 8,  'total' => 8,  'status' => 'completed'],
        ['id' => 2, 'name' => 'Q3 Creative Refresh','owner' => 'Abraham Partogi Liem Silaen','category' => 'Content Production','done' => 20, 'total' => 20, 'status' => 'completed'],
        ['id' => 3, 'name' => 'Test Colab',        'owner' => 'Abraham Partogi Liem Silaen','category' => 'Social Media',    'done' => 1,  'total' => 3,  'status' => 'in_progress'],
        ['id' => 4, 'name' => 'Brand Guidelines',  'owner' => 'Abraham Partogi Liem Silaen','category' => 'Brand Identity',   'done' => 20, 'total' => 20, 'status' => 'completed'],
        ['id' => 5, 'name' => 'Influencer Brief',  'owner' => 'Abraham Partogi Liem Silaen','category' => 'Partnerships',    'done' => 20, 'total' => 20, 'status' => 'completed'],
        ['id' => 6, 'name' => 'Launch Video',      'owner' => 'Abraham Partogi Liem Silaen','category' => 'Video Production', 'done' => 20, 'total' => 20, 'status' => 'completed'],
    ];
    $statusLabel = ['completed' => 'Completed', 'in_progress' => 'In Progress', 'blocked' => 'Blocked', 'overdue' => 'Past Deadline'];
@endphp
 
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
<style>
    /* =========================================
       TOKENS & BASE (selaras dengan Overview & Team Scorecards)
    ========================================= */
    .pj, .pj * { box-sizing: border-box; }
 
    .pj {
        --card: #1a1a1d;
        --inner: #222226;
        --line: #2e2e33;
        --line-strong: #3d3d44;
        --muted: #a1a1aa;
        --red: #c8262b;
        --red-deep: #a51f23;
        --green: #22c985;
        --amber: #f5b72b;
        --r-lg: 16px;
        --r-md: 12px;
        --ease: cubic-bezier(.2,.7,.2,1);
 
        width: 100%;
        max-width: 1440px;
        margin: 0 auto;
        padding: 24px 0 56px;
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 14px;
        line-height: 1.5;
        color: #f4f4f5;
        -webkit-font-smoothing: antialiased;
    }
 
    .pj h1, .pj h2, .pj p, .pj b { margin: 0; font-family: inherit; }
    .pj a { text-decoration: none; color: inherit; }
    .pj button, .pj select { font-family: inherit; }
    .pj a:focus-visible, .pj button:focus-visible, .pj select:focus-visible, .pj summary:focus-visible { outline: 2px solid #fff; outline-offset: 2px; }
 
    /* =========================================
       HEADER + AKSI
    ========================================= */
    .pj .top { display: flex; justify-content: space-between; align-items: flex-end; gap: 16px; flex-wrap: wrap; margin-bottom: 22px; }
    .pj .top h1 { font-size: 22.3px; font-weight: 600; line-height: 1.2; margin-bottom: 8px; }
    .pj .top .sub { color: var(--muted); font-size: 14.6px; font-weight: 500; }
    .pj .actions { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
 
    .pj .btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        height: 42px; padding: 0 18px;
        font-size: 14px; font-weight: 500; white-space: nowrap;
        color: #fff; background: var(--inner);
        border: 1px solid var(--line-strong); border-radius: 10px;
        cursor: pointer;
        transition: background .2s var(--ease), border-color .2s var(--ease);
    }
    .pj .btn:hover { background: #2c2c32; border-color: #55555d; }
    .pj .btn.export, .pj .btn.new {
        background: linear-gradient(145deg, var(--red), var(--red-deep));
        border-color: transparent;
        box-shadow: 0 4px 14px rgba(165,31,35,.35);
    }
    .pj .btn.export:hover, .pj .btn.new:hover { background: linear-gradient(145deg, #d52c31, #b3242a); }
    .pj .btn.export > i:first-child { color: #fff; }
    .pj .btn.new i { font-size: 17px; }
 
    .pj .month { position: relative; padding: 0; }
    .pj .month select {
        appearance: none; -webkit-appearance: none;
        height: 100%; min-width: 172px; padding: 0 42px 0 18px;
        font-size: 14px; font-weight: 500; color: #fff;
        background: transparent; border: 0; cursor: pointer;
    }
    .pj .month select option { color: #000; }
    .pj .month i { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); pointer-events: none; font-size: 13px; color: #fff; }
 
    .pj details.exp { position: relative; }
    .pj details.exp > summary { list-style: none; }
    .pj details.exp > summary::-webkit-details-marker { display: none; }
    .pj details.exp > summary .bi-chevron-down { font-size: 12px; transition: transform .2s var(--ease); }
    .pj details.exp[open] > summary .bi-chevron-down { transform: rotate(180deg); }
    .pj .menu {
        position: absolute; right: 0; top: 50px; z-index: 20; min-width: 190px; padding: 6px;
        background: #1f1f23; border: 1px solid var(--line-strong); border-radius: var(--r-md);
        box-shadow: 0 16px 40px rgba(0,0,0,.5);
    }
    .pj .menu a { display: block; padding: 10px 12px; border-radius: 8px; font-size: 14px; }
    .pj .menu a:hover { background: #2e2e33; }
 
    /* =========================================
       BANNER PERHATIAN (dikembalikan persis seperti kode lama)
       zoom .75 = skala yang dulu dipakai oleh .pj, supaya ukurannya identik
    ========================================= */
    .pj .alert{zoom:.75;display:flex;align-items:center;gap:10px;background:#a31c1c;border-radius:6px;height:47px;padding:0 20px;font-size:16px;font-weight:500;margin-bottom:30px}
    .pj .alert .lead{font-size:19px}.pj .alert .go{margin-left:auto;font-size:19px}
 
    /* =========================================
       PANEL
    ========================================= */
    .pj .panel { padding: 24px; background: var(--card); border: 1px solid var(--line); border-radius: var(--r-lg); box-shadow: 0 8px 24px rgba(0,0,0,.25); }
    .pj .panel-head { display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 20px; }
    .pj .panel-head h2 { font-size: 19px; font-weight: 600; letter-spacing: -.01em; margin-bottom: 4px; }
    .pj .panel-head p { font-size: 13.5px; color: var(--muted); }
    .pj hr { border: 0; border-top: 1px solid var(--line); margin: 0; }
    .pj br { display: block; content: ""; margin-top: 12px; }
 
    /* =========================================
       TABEL
    ========================================= */
    .pj .tbl-wrap { overflow-x: auto; border-radius: var(--r-md); }
    .pj .tbl { min-width: 820px; border: 1px solid var(--line); border-radius: var(--r-md); overflow: hidden; background: var(--card); }
    .pj .tr { display: grid; grid-template-columns: minmax(170px,1.4fr) minmax(210px,1.7fr) minmax(150px,1.2fr) 140px 140px 44px; align-items: center; column-gap: 12px; padding: 0 16px 0 20px; }
    .pj .th { height: 46px; font-size: 13px; font-weight: 500; color: var(--muted); background: var(--inner); border-bottom: 1px solid var(--line); }
    .pj .th > div:first-child, .pj .rowp > div:first-child { padding-left: 0; }
 
    .pj .rowp { position: relative; min-height: 70px; border-bottom: 1px solid var(--line); transition: background .2s var(--ease); }
    .pj .rowp:last-child { border-bottom: 0; }
    .pj .rowp:hover { background: rgba(255,255,255,.035); }
    .pj .rowp::after { display: none; }
    .pj .rowp .name { font-weight: 600; font-size: 15px; }
    .pj .rowp .owner { display: flex; align-items: center; gap: 10px; min-width: 0; color: #d4d4d8; }
    .pj .rowp .owner span.av { flex: none; width: 30px; height: 30px; display: grid; place-items: center; font-size: 12px; font-weight: 600; background: linear-gradient(135deg, #4b5563, #27272a); border: 1px solid var(--line-strong); border-radius: 50%; }
    .pj .rowp .owner span.nm { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .pj .rowp .cat { justify-self: start; padding: 3px 10px; font-size: 12.5px; color: #d4d4d8; background: rgba(255,255,255,.06); border: 1px solid var(--line); border-radius: 999px; }
 
    .pj .rowp .prog { display: flex; flex-direction: column; gap: 6px; font-weight: 600; font-size: 14px; }
    .pj .mini { display: block; width: 100%; max-width: 100px; height: 5px; overflow: hidden; background: rgba(255,255,255,.1); border-radius: 4px; }
    .pj .mini i { display: block; height: 100%; border-radius: 4px; background: var(--green); }
    .pj .s-in_progress .mini i { background: var(--amber); }
    .pj .s-blocked .mini i, .pj .s-overdue .mini i { background: #ff4b4b; }
 
    .pj .rowp .go { text-align: center; padding-left: 0; font-size: 15px; color: #ff5a5f; transition: transform .2s var(--ease); }
    .pj .rowp:hover .go { transform: translateX(3px); }
 
    .pj .badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 11px 4px 9px; font-size: 12.5px; font-weight: 500; line-height: 1.4; border-radius: 999px; border: 1px solid; }
    .pj .badge::before { content: ""; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .pj .badge.completed   { color: #5eeaa8; background: rgba(34,201,133,.12); border-color: rgba(34,201,133,.35); }
    .pj .badge.in_progress { color: #ffc75a; background: rgba(245,183,43,.12); border-color: rgba(245,183,43,.4); }
    .pj .badge.blocked, .pj .badge.overdue { color: #ff8b8e; background: rgba(224,56,61,.14); border-color: rgba(224,56,61,.45); }
 
    .pj .empty { padding: 48px 20px; text-align: center; color: var(--muted); }
 
    /* =========================================
       TABLET
    ========================================= */
    @media (max-width: 1100px) {
        .pj .top h1 { font-size: 20.8px; }
        .pj .top .sub { font-size: 13.1px; }
    }
 
    /* =========================================
       MOBILE: tabel berubah menjadi kartu
    ========================================= */
    @media (max-width: 768px) {
        .pj { padding: 84px 16px 40px; font-size: 16px; }
        .pj .top { align-items: stretch; }
        .pj .top h1 { font-size: 33px; }
        .pj .top .sub { font-size: 19px; line-height: 1.55; margin-bottom: 4px; }
 
        .pj .actions { width: 100%; gap: 10px; }
        .pj .month { flex: 1 1 100%; }
        .pj .month select { width: 100%; }
        .pj .actions > .btn, .pj .actions > details.exp { flex: 1 1 calc(50% - 5px); }
        .pj .actions > details.exp > summary { width: 100%; }
        .pj .btn { height: 46px; font-size: 15px; }
        .pj .menu { left: 0; right: 0; min-width: 0; }
 
        .pj .panel { padding: 18px 16px; }
        .pj .panel-head { flex-direction: column; align-items: stretch; margin-bottom: 16px; }
        .pj .panel-head h2 { font-size: 21px; }
        .pj .panel-head p { font-size: 14px; }
        .pj .btn.new { width: 100%; }
 
        .pj .tbl-wrap { overflow: visible; }
        .pj .tbl { min-width: 0; background: transparent; border: 0; border-radius: 0; overflow: visible; }
        .pj .th { display: none; }
        .pj .rowp {
            grid-template-columns: 1fr auto 20px;
            grid-template-areas: "name status go" "owner owner owner" "cat cat prog";
            gap: 10px; padding: 16px 14px; min-height: 0;
            margin-top: 12px; background: var(--inner);
            border: 1px solid var(--line); border-radius: var(--r-md);
        }
        .pj .rowp:last-child { border-bottom: 1px solid var(--line); }
        .pj .rowp > :nth-child(1) { grid-area: name; font-size: 17px; }
        .pj .rowp > :nth-child(2) { grid-area: owner; font-size: 14px; }
        .pj .rowp > :nth-child(3) { grid-area: cat; }
        .pj .rowp > :nth-child(4) { grid-area: prog; align-items: flex-end; }
        .pj .rowp > :nth-child(5) { grid-area: status; }
        .pj .rowp > :nth-child(6) { grid-area: go; }
        .pj .rowp .cat { font-size: 13px; }
    }
 
    @media (max-width: 480px) {
        .pj { padding: 84px 14px 36px; }
        .pj .top h1 { font-size: 31px; }
        .pj .top .sub { font-size: 18px; }
        .pj .actions > .btn, .pj .actions > details.exp { flex: 1 1 100%; }
    }
 
    @media (max-width: 360px) {
        .pj { padding-left: 12px; padding-right: 12px; }
        .pj .top h1 { font-size: 28px; }
        .pj .top .sub { font-size: 17px; }
    }
 
    @media (prefers-reduced-motion: reduce) {
        .pj *, .pj *::before { transition: none !important; }
    }
</style>
 
<div class="pj">
    <div class="top">
        <div>
            <h1>Projects</h1>
            <div class="sub">Work in flight, by the person accountable for it</div>
        </div>
        <div class="actions">
            <form method="GET" class="btn month">
                <select name="month" onchange="this.form.submit()" aria-label="Month">
                    @foreach($months as $m)
                        <option value="{{ $m }}" @selected($m === $selectedMonth)>{{ $m }}</option>
                    @endforeach
                </select>
                <i class="bi bi-chevron-down"></i>
            </form>
            <a href="{{ $dossierUrl ?? '#' }}" class="btn"><i class="bi bi-calculator"></i>Board Dossier</a>
            <details class="exp">
                <summary class="btn export"><i class="bi bi-file-earmark-arrow-up"></i>Export As <i class="bi bi-chevron-down"></i></summary>
                <div class="menu">
                    <a href="{{ $exportPdfUrl ?? '#' }}">PDF</a>
                    <a href="{{ $exportXlsxUrl ?? '#' }}">Excel (.xlsx)</a>
                    <a href="{{ $exportCsvUrl ?? '#' }}">CSV</a>
                </div>
            </details>
        </div>
    </div>
 
    @if($attention > 0)
        <a href="{{ $attentionUrl }}" class="alert">
            <i class="bi bi-exclamation-triangle lead"></i>{{ $attention }} item{{ $attention > 1 ? 's' : '' }} needs attention
            <i class="bi bi-arrow-right go"></i>
        </a>
    @endif
 
    <div class="panel">
        <div class="panel-head">
            <div>
                <h2>Project Roster &amp; Post Checklist</h2>
                <p>Reads live data from your connected Google Sheets.</p>
            </div>
            <a href="{{ $newUrl }}" class="btn new"><i class="bi bi-plus-lg"></i>New Project</a>
        </div>
        <hr>
        <br>
        <div class="tbl-wrap">
            <div class="tbl">
                <div class="tr th">
                    <div>Project</div>
                    <div>Owner</div>
                    <div>Category</div>
                    <div>Progress</div>
                    <div>Status</div>
                    <div></div>
                </div>
 
                @forelse($projects as $p)
                    <a href="{{ url('/projects/' . $p['id']) }}" class="tr rowp s-{{ $p['status'] }}">
                        <div class="name">{{ $p['name'] }}</div>
                        <div class="owner"><span class="av">{{ strtoupper(mb_substr($p['owner'], 0, 1)) }}</span><span class="nm">{{ $p['owner'] }}</span></div>
                        <div class="cat">{{ $p['category'] }}</div>
                        <div class="prog">
                            {{ $p['done'] }}/{{ $p['total'] }}
                            <span class="mini"><i style="width:{{ $p['total'] > 0 ? round($p['done'] / $p['total'] * 100) : 0 }}%"></i></span>
                        </div>
                        <div><span class="badge {{ $p['status'] }}">{{ $statusLabel[$p['status']] ?? $p['status'] }}</span></div>
                        <div class="go"><i class="bi bi-chevron-right"></i></div>
                    </a>
                @empty
                    <div class="empty">No projects yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
 