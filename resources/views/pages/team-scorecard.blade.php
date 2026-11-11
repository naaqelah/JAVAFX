{{-- resources/views/performance/team-scorecards.blade.php --}}
@extends('layouts.app')
 
@php
    // ====== DATA (timpa dari controller: return view('performance.team-scorecards', compact(...))) ======
    $selectedMonth = $selectedMonth ?? 'October 2026';
    $months        = $months ?? ['October 2026', 'September 2026', 'August 2026', 'July 2026'];
    $attention     = $attention ?? 1;
    $attentionUrl  = $attentionUrl ?? '#';
    $assignPeriod  = $assignPeriod ?? 'August 2026';
    $assignUrl     = $assignUrl ?? '#';
 
    // tier: on_track | attention | no_data   |   composite: angka (96.1) atau null   |   photo: URL foto (opsional)
    $people = $people ?? [
        ['name' => 'Lidia',   'role' => 'Lead Performance Marketing',  'kpis' => 2, 'composite' => 96.1, 'tier' => 'on_track', 'photo' => null],
        ['name' => 'Bella',   'role' => 'Content Creator',             'kpis' => 1, 'composite' => 95.8, 'tier' => 'on_track', 'photo' => null],
        ['name' => 'Michele', 'role' => 'Lead Performance Marketing',  'kpis' => 1, 'composite' => 87.3, 'tier' => 'attention', 'photo' => null],
        ['name' => 'Jason',   'role' => 'Performing Marketing Executive', 'kpis' => 1, 'composite' => null, 'tier' => 'no_data', 'photo' => null],
        ['name' => 'Jodie',   'role' => 'Content Strategist',          'kpis' => 1, 'composite' => null, 'tier' => 'no_data', 'photo' => null],
        ['name' => 'Louie',   'role' => 'Marketing Operations Executive', 'kpis' => 1, 'composite' => null, 'tier' => 'no_data', 'photo' => null],
    ];
    $kpiOptions = $kpiOptions ?? [];   // contoh: [['id' => 1, 'name' => 'Leads per month']]
 
    $tierLabel = ['on_track' => 'On Track', 'attention' => 'Need Attention', 'no_data' => 'No Data'];
 
    // Ranking: hanya yang punya composite, urut tertinggi
    $ranked   = collect($people)->filter(fn ($p) => $p['composite'] !== null)->sortByDesc('composite')->values();
    $unranked = collect($people)->whereNull('composite')->count();
    $scaleMax = 120;                         // skala batang 0 - 120%
    $pctOf    = fn ($v) => min(100, max(0, $v / $scaleMax * 100));
    $axis     = [0, 30, 60, 90, 100, 120];
@endphp
 
@section('content')
{{-- CSS & ikon diletakkan di sini supaya tetap jalan walau layout belum punya @stack('styles') --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
<style>
    /* =========================================
       TOKENS & BASE (selaras dengan halaman Overview)
    ========================================= */
    .tsc, .tsc * { box-sizing: border-box; }
 
    .tsc {
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
 
    .tsc h1, .tsc h2, .tsc h3, .tsc p, .tsc b { margin: 0; font-family: inherit; }
    .tsc a { text-decoration: none; color: inherit; }
    .tsc button, .tsc select, .tsc input { font-family: inherit; }
    .tsc a:focus-visible, .tsc button:focus-visible, .tsc select:focus-visible,
    .tsc input:focus-visible, .tsc summary:focus-visible { outline: 2px solid #fff; outline-offset: 2px; }
 
    /* =========================================
       HEADER + AKSI
    ========================================= */
    .tsc .top { display: flex; justify-content: space-between; align-items: flex-end; gap: 16px; flex-wrap: wrap; margin-bottom: 22px; }
    .tsc .top h1 { font-size: 22.3px; font-weight: 600; line-height: 1.2; margin-bottom: 8px; }
    .tsc .top .sub { color: var(--muted); font-size: 14.6px; font-weight: 500; }
    .tsc .actions { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
 
    .tsc .btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        height: 42px; padding: 0 18px;
        font-size: 14px; font-weight: 500; white-space: nowrap;
        color: #fff; background: var(--inner);
        border: 1px solid var(--line-strong); border-radius: 10px;
        cursor: pointer;
        transition: background .2s var(--ease), border-color .2s var(--ease), transform .2s var(--ease);
    }
    .tsc .btn:hover { background: #2c2c32; border-color: #55555d; }
    .tsc .btn.red { background: linear-gradient(145deg, var(--red), var(--red-deep)); border-color: transparent; box-shadow: 0 4px 14px rgba(165,31,35,.35); }
    .tsc .btn.red:hover { background: linear-gradient(145deg, #d52c31, #b3242a); }
 
    .tsc .btn.month { position: relative; padding: 0; }
    .tsc .btn.month select {
        appearance: none; -webkit-appearance: none;
        height: 100%; min-width: 172px; padding: 0 42px 0 18px;
        font-size: 14px; font-weight: 500; color: #fff;
        background: transparent; border: 0; cursor: pointer;
    }
    .tsc .btn.month select option { color: #000; }
    .tsc .btn.month i { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); pointer-events: none; font-size: 13px; }
 
    .tsc details.exp { position: relative; }
    .tsc details.exp > summary { list-style: none; }
    .tsc details.exp > summary::-webkit-details-marker { display: none; }
    .tsc details.exp[open] > summary .bi-chevron-down { transform: rotate(180deg); }
    .tsc details.exp > summary .bi-chevron-down { transition: transform .2s var(--ease); font-size: 12px; }
    .tsc .menu {
        position: absolute; right: 0; top: 50px; z-index: 20; min-width: 190px; padding: 6px;
        background: #1f1f23; border: 1px solid var(--line-strong); border-radius: var(--r-md);
        box-shadow: 0 16px 40px rgba(0,0,0,.5);
    }
    .tsc .menu a { display: block; padding: 10px 12px; border-radius: 8px; font-size: 14px; }
    .tsc .menu a:hover { background: #2e2e33; }
 
    /* =========================================
       BANNER PERHATIAN (dikembalikan persis seperti kode lama)
       zoom .75 = skala yang dulu dipakai oleh .tsc, supaya ukurannya identik
    ========================================= */
    .tsc .alert{zoom:.75;display:flex;align-items:center;gap:10px;background:#a31c1c;border-radius:6px;height:47px;padding:0 20px;font-size:16px;font-weight:500;margin-bottom:32px}
    .tsc .alert i.lead{font-size:19px}
    .tsc .alert i.go{margin-left:auto;font-size:19px}
 
    /* =========================================
       SUBMITTED RESULTS
    ========================================= */
    .tsc .submitted { padding: 16px 18px; margin-bottom: 20px; background: var(--card); border: 1px solid var(--line); border-radius: var(--r-md); }
    .tsc .submitted .t { display: flex; align-items: center; gap: 12px; font-size: 15px; font-weight: 600; }
    .tsc .submitted .t i { width: 34px; height: 34px; display: grid; place-items: center; font-size: 16px; color: #8cb7ff; background: rgba(59,130,246,.14); border-radius: 10px; }
    .tsc .submitted p { margin-top: 2px; padding-left: 46px; font-size: 13.5px; color: var(--muted); }
 
    /* =========================================
       TABEL ORANG
    ========================================= */
    .tsc .tbl-wrap { overflow-x: auto; margin-bottom: 24px; border-radius: var(--r-lg); }
    .tsc .tbl { min-width: 780px; background: var(--card); border: 1px solid var(--line); border-radius: var(--r-lg); overflow: hidden; }
    .tsc .tr { display: grid; grid-template-columns: 48px minmax(170px,1.5fr) minmax(210px,2.2fr) 70px minmax(140px,1.3fr) 150px; align-items: center; column-gap: 8px; padding: 0 18px 0 8px; }
    .tsc .th { height: 48px; font-size: 13px; font-weight: 500; color: var(--muted); background: var(--inner); border-bottom: 1px solid var(--line); }
    .tsc .rowp { min-height: 76px; border-bottom: 1px solid var(--line); transition: background .2s var(--ease); }
    .tsc .rowp:last-child { border-bottom: 0; }
    .tsc .rowp:hover { background: rgba(255,255,255,.03); }
    .tsc .chev { color: #ff5a5f; font-size: 13px; text-align: center; transition: transform .2s var(--ease); }
    .tsc .rowp:hover .chev { transform: translateX(3px); }
 
    .tsc .person { display: flex; align-items: center; gap: 14px; font-size: 15px; font-weight: 600; white-space: nowrap; }
    .tsc .person .av {
        width: 44px; height: 44px; flex: none; overflow: hidden;
        display: grid; place-items: center;
        font-size: 17px; font-weight: 600;
        background: linear-gradient(135deg, #4b5563, #27272a);
        border-radius: 50%;
        border: 2px solid var(--line-strong);
    }
    .tsc .person .av img { width: 100%; height: 100%; object-fit: cover; }
    .tsc .t-on_track .av { border-color: var(--green); }
    .tsc .t-attention .av { border-color: var(--amber); }
 
    .tsc .role { color: #d4d4d8; }
    .tsc .comp { display: flex; flex-direction: column; gap: 6px; font-weight: 600; font-size: 15px; }
    .tsc .mini { display: block; width: 100%; max-width: 110px; height: 5px; background: rgba(255,255,255,.1); border-radius: 4px; overflow: hidden; }
    .tsc .mini i { display: block; height: 100%; border-radius: 4px; background: var(--green); }
    .tsc .t-attention .mini i { background: var(--amber); }
 
    .tsc .badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 11px 4px 9px; font-size: 12.5px; font-weight: 500; line-height: 1.4; border-radius: 999px; border: 1px solid; }
    .tsc .badge::before { content: ""; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .tsc .badge.on_track  { color: #5eeaa8; background: rgba(34,201,133,.12); border-color: rgba(34,201,133,.35); }
    .tsc .badge.attention { color: #ffc75a; background: rgba(245,183,43,.12); border-color: rgba(245,183,43,.4); }
    .tsc .badge.no_data   { color: #c4c4cc; background: rgba(255,255,255,.06); border-color: var(--line-strong); }
 
    /* =========================================
       SECTION COLLAPSIBLE
    ========================================= */
    .tsc details.sec { margin: 0 0 16px; }
    .tsc details.sec > summary {
        list-style: none; display: flex; align-items: center; gap: 12px;
        height: 56px; padding: 0 20px;
        font-size: 15px; font-weight: 600;
        background: var(--card); border: 1px solid var(--line); border-radius: var(--r-md);
        cursor: pointer; user-select: none;
        transition: border-color .2s var(--ease), background .2s var(--ease);
    }
    .tsc details.sec > summary:hover { border-color: var(--line-strong); background: #1f1f23; }
    .tsc details.sec > summary::-webkit-details-marker { display: none; }
    .tsc details.sec > summary i { font-size: 14px; color: var(--muted); transition: transform .2s var(--ease); }
    .tsc details.sec:not([open]) > summary i { transform: rotate(-90deg); }
    .tsc .box { margin-top: 12px; background: var(--card); border: 1px solid var(--line); border-radius: var(--r-lg); }
 
    /* =========================================
       RANKING
    ========================================= */
    .tsc .rank { padding: 26px 30px 30px; }
    .tsc .rank h2 { font-size: 19px; font-weight: 600; margin-bottom: 4px; }
    .tsc .rank .desc { font-size: 13.5px; color: var(--muted); margin-bottom: 20px; }
    .tsc .rk-wrap { padding-left: 76px; padding-right: 44px; }
    .tsc .rk-plot { position: relative; padding-top: 40px; }
    .tsc .rk-row { position: relative; height: 26px; margin-bottom: 14px; }
    .tsc .rk-name { position: absolute; left: -76px; top: 0; width: 68px; overflow: hidden; text-overflow: ellipsis; line-height: 26px; font-size: 13.5px; font-weight: 500; white-space: nowrap; }
    .tsc .rk-track { position: absolute; inset: 0; background: rgba(255,255,255,.07); border-radius: 7px; }
    .tsc .rk-fill { position: absolute; left: 0; top: 0; bottom: 0; background: linear-gradient(90deg, var(--red-deep), #e0383d); border-radius: 7px; box-shadow: 0 2px 10px rgba(200,38,43,.35); }
    .tsc .rk-val { position: absolute; top: 0; margin-left: 10px; line-height: 26px; font-size: 13px; font-weight: 600; color: #fff; }
    .tsc .rk-target { position: absolute; top: 22px; bottom: 28px; width: 0; border-left: 1.5px dashed #ff6a6e; }
    .tsc .rk-target span { position: absolute; top: -22px; left: 0; transform: translateX(-50%); padding: 1px 8px; font-size: 12px; font-weight: 500; white-space: nowrap; color: #ffb3b5; background: rgba(224,56,61,.14); border-radius: 999px; }
    .tsc .rk-axis { position: relative; height: 20px; margin-top: 4px; border-top: 1px solid var(--line-strong); }
    .tsc .rk-axis span { position: absolute; top: 4px; transform: translateX(-50%); font-size: 12px; color: var(--muted); }
    .tsc .rk-note { display: flex; align-items: center; gap: 12px; margin-top: 28px; padding: 12px 16px; font-size: 14px; background: var(--inner); border: 1px solid var(--line); border-radius: var(--r-md); }
    .tsc .rk-note i { font-size: 20px; color: var(--muted); }
    .tsc .rk-note b { font-weight: 600; }
 
    /* =========================================
       FORM ASSIGN
    ========================================= */
    .tsc .assign { padding: 22px 28px 28px; }
    .tsc .fgrid { display: grid; grid-template-columns: 1fr 1fr; gap: 4px 24px; }
    .tsc .fld label { display: block; font-size: 13.5px; font-weight: 600; margin: 12px 0 8px; }
    .tsc .fld label em { color: #ff5a5f; font-style: normal; font-size: 12px; margin-left: 2px; }
    .tsc .ctrl { position: relative; }
    .tsc .ctrl select, .tsc .ctrl input {
        width: 100%; height: 48px; padding: 0 18px;
        font-size: 14px; color: #fff;
        background: var(--inner); border: 1px solid var(--line-strong); border-radius: 10px;
        outline: none; appearance: none; -webkit-appearance: none;
        transition: border-color .2s var(--ease), box-shadow .2s var(--ease);
    }
    .tsc .ctrl select { padding-right: 44px; cursor: pointer; }
    .tsc .ctrl select:invalid, .tsc .ctrl select.ph { color: #8b8b94; }
    .tsc .ctrl input::placeholder { color: #8b8b94; }
    .tsc .ctrl select:hover, .tsc .ctrl input:hover { border-color: #55555d; }
    .tsc .ctrl input:focus, .tsc .ctrl select:focus { border-color: #e0383d; box-shadow: 0 0 0 3px rgba(224,56,61,.2); }
    .tsc .ctrl i { position: absolute; right: 18px; top: 50%; transform: translateY(-50%); pointer-events: none; font-size: 13px; color: var(--muted); }
    .tsc .ctrl select option { color: #000; }
    .tsc .fbtns { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 24px; }
    .tsc .fbtns .btn { height: 44px; }
    .tsc .fbtns span.btn { cursor: default; color: #d4d4d8; }
    .tsc .fbtns span.btn:hover { background: var(--inner); border-color: var(--line-strong); }
 
    /* =========================================
       SUMBER DATA
    ========================================= */
    .tsc .source { margin-top: 24px; padding: 24px 28px 26px; background: var(--card); border: 1px solid var(--line); border-radius: var(--r-lg); }
    .tsc .source h3 { display: flex; align-items: center; gap: 12px; margin-bottom: 10px; font-size: 17px; font-weight: 600; }
    .tsc .source h3 i { width: 36px; height: 36px; display: grid; place-items: center; font-size: 17px; color: #fff; background: linear-gradient(145deg, var(--red), var(--red-deep)); border-radius: 10px; }
    .tsc .source p { max-width: 90ch; padding-left: 48px; font-size: 14px; line-height: 1.65; color: var(--muted); }
 
    /* =========================================
       TABLET
    ========================================= */
    @media (max-width: 1100px) {
        .tsc .top h1 { font-size: 20.8px; }
        .tsc .top .sub { font-size: 13.1px; }
    }
    @media (max-width: 900px) {
        .tsc .fgrid { grid-template-columns: 1fr; }
        .tsc .rank, .tsc .assign { padding-left: 18px; padding-right: 18px; }
    }
 
    /* =========================================
       MOBILE: tabel berubah menjadi kartu
    ========================================= */
    @media (max-width: 768px) {
        .tsc { padding: 84px 16px 40px; font-size: 16px; }
        .tsc .top { align-items: stretch; }
        .tsc .top h1 { font-size: 33px; }
        .tsc .top .sub { font-size: 19px; line-height: 1.55; margin-bottom: 4px; }
 
        .tsc .actions { width: 100%; gap: 10px; }
        .tsc .btn.month { flex: 1 1 100%; }
        .tsc .btn.month select { width: 100%; }
        .tsc .actions > .btn, .tsc .actions > details.exp { flex: 1 1 calc(50% - 5px); }
        .tsc .actions > details.exp > summary { width: 100%; }
        .tsc .btn { height: 46px; font-size: 15px; }
        .tsc .menu { left: 0; right: 0; min-width: 0; }
 
        .tsc .submitted p { padding-left: 0; margin-top: 10px; font-size: 14px; }
 
        .tsc .tbl-wrap { overflow: visible; }
        .tsc .tbl { min-width: 0; background: transparent; border: 0; border-radius: 0; overflow: visible; }
        .tsc .th { display: none; }
        .tsc .rowp {
            grid-template-columns: 24px 1fr auto;
            grid-template-areas: "chev person badge" ". role role" ". kpis comp";
            gap: 10px 10px; padding: 16px 14px 16px 10px; min-height: 0;
            margin-bottom: 12px; background: var(--card);
            border: 1px solid var(--line); border-radius: var(--r-md);
        }
        .tsc .rowp:last-child { border-bottom: 1px solid var(--line); }
        .tsc .rowp > :nth-child(1) { grid-area: chev; }
        .tsc .rowp > :nth-child(2) { grid-area: person; }
        .tsc .rowp > :nth-child(3) { grid-area: role; font-size: 14px; color: var(--muted); }
        .tsc .rowp > :nth-child(4) { grid-area: kpis; font-size: 14px; color: var(--muted); }
        .tsc .rowp > :nth-child(4)::before { content: "KPIs: "; }
        .tsc .rowp > :nth-child(5) { grid-area: comp; align-items: flex-end; }
        .tsc .rowp > :nth-child(6) { grid-area: badge; }
        .tsc .mini { max-width: 90px; }
 
        .tsc details.sec > summary { height: 60px; font-size: 16px; }
        .tsc .rank { padding: 22px 16px 24px; }
        .tsc .rank h2 { font-size: 21px; }
        .tsc .rank .desc { font-size: 14px; }
        .tsc .rk-wrap { padding-left: 64px; padding-right: 40px; }
        .tsc .rk-name { left: -64px; width: 58px; font-size: 13px; }
        .tsc .rk-axis span, .tsc .rk-target span { font-size: 11.5px; }
        .tsc .rk-note { font-size: 14px; }
 
        .tsc .assign { padding: 14px 16px 22px; }
        .tsc .fld label { font-size: 15px; }
        .tsc .ctrl select, .tsc .ctrl input { height: 52px; font-size: 16px; }
        .tsc .fbtns .btn { flex: 1 1 100%; }
 
        .tsc .source { padding: 20px 16px 22px; }
        .tsc .source h3 { font-size: 18px; }
        .tsc .source p { padding-left: 0; font-size: 15px; }
    }
 
    @media (max-width: 480px) {
        .tsc { padding: 84px 14px 36px; }
        .tsc .top h1 { font-size: 31px; }
        .tsc .top .sub { font-size: 18px; }
        .tsc .actions > .btn, .tsc .actions > details.exp { flex: 1 1 100%; }
    }
 
    @media (max-width: 360px) {
        .tsc { padding-left: 12px; padding-right: 12px; }
        .tsc .top h1 { font-size: 28px; }
        .tsc .top .sub { font-size: 17px; }
    }
 
    @media (prefers-reduced-motion: reduce) {
        .tsc *, .tsc *::before { transition: none !important; }
    }
</style>
 
<div class="tsc">
 
    {{-- Judul + kontrol --}}
    <div class="top">
        <div>
            <h1>Team Scorecards</h1>
            <div class="sub">Team Performance from the latest synchronised data</div>
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
                <summary class="btn red"><i class="bi bi-file-earmark-arrow-up"></i>Export As <i class="bi bi-chevron-down"></i></summary>
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
 
    {{-- Hasil yang disubmit --}}
    <div class="submitted">
        <div class="t"><i class="bi bi-inbox"></i>Your submitted results</div>
        <p>Sent for review - the official figure does not move until a manager approve it.</p>
    </div>
 
    {{-- Tabel orang --}}
    <div class="tbl-wrap">
        <div class="tbl">
            <div class="tr th">
                <div></div>
                <div class="c1">Person</div>
                <div>Role/Position.</div>
                <div>KPIs</div>
                <div>Composite</div>
                <div>Tier</div>
            </div>
            @foreach($people as $p)
                <div class="tr rowp t-{{ $p['tier'] }}">
                    <div class="chev"><i class="bi bi-chevron-right"></i></div>
                    <div class="person">
                        <span class="av">
                            @if(!empty($p['photo']))<img src="{{ $p['photo'] }}" alt="{{ $p['name'] }}">@else{{ strtoupper(mb_substr($p['name'], 0, 1)) }}@endif
                        </span>
                        {{ $p['name'] }}
                    </div>
                    <div class="role">{{ $p['role'] }}</div>
                    <div>{{ $p['kpis'] }}</div>
                    <div class="comp">
                        {{ $p['composite'] !== null ? number_format($p['composite'], 1) . '%' : '-' }}
                        @if($p['composite'] !== null)<span class="mini"><i style="width:{{ $pctOf($p['composite']) }}%"></i></span>@endif
                    </div>
                    <div><span class="badge {{ $p['tier'] }}">{{ $tierLabel[$p['tier']] ?? $p['tier'] }}</span></div>
                </div>
            @endforeach
        </div>
    </div>
 
    {{-- Team ranking --}}
    <details class="sec" open>
        <summary><i class="bi bi-chevron-down"></i>Team ranking</summary>
        <div class="box rank">
            <h2>Team ranking</h2>
            <div class="desc">Composite across each person's reported KPIs, against the 100% rule</div>
 
            <div class="rk-wrap">
                <div class="rk-plot">
                    <div class="rk-target" style="left:{{ $pctOf(100) }}%"><span>100% Target</span></div>
                    @foreach($ranked as $r)
                        <div class="rk-row">
                            <div class="rk-name">{{ $r['name'] }}</div>
                            <div class="rk-track">
                                <div class="rk-fill" style="width:{{ $pctOf($r['composite']) }}%"></div>
                                <div class="rk-val" style="left:{{ $pctOf($r['composite']) }}%">{{ round($r['composite']) }}%</div>
                            </div>
                        </div>
                    @endforeach
                    <div class="rk-axis">
                        @foreach($axis as $a)<span style="left:{{ $pctOf($a) }}%">{{ $a }}%</span>@endforeach
                    </div>
                </div>
            </div>
 
            @if($unranked > 0)
                <div class="rk-note"><i class="bi bi-people"></i><span><b>{{ $unranked }} people have</b> no recorded result this month and are not ranked.</span></div>
            @endif
        </div>
    </details>
 
    {{-- Assign a KPI --}}
    <details class="sec" open>
        <summary><i class="bi bi-chevron-down"></i>Assign a KPI</summary>
        <form method="POST" action="{{ $assignUrl }}" class="box assign">
            @csrf
            <div class="fgrid">
                <div class="fld">
                    <label for="person">Person <em>*</em></label>
                    <div class="ctrl">
                        <select id="person" name="person_id" required class="ph" onchange="this.classList.toggle('ph', !this.value)">
                            <option value="" disabled selected>Choose somebody</option>
                            @foreach($people as $i => $p)<option value="{{ $p['id'] ?? $i + 1 }}">{{ $p['name'] }}</option>@endforeach
                        </select>
                        <i class="bi bi-chevron-down"></i>
                    </div>
                </div>
                <div class="fld">
                    <label for="kpi">KPI <em>*</em></label>
                    <div class="ctrl">
                        <select id="kpi" name="kpi_id" required class="ph" onchange="this.classList.toggle('ph', !this.value)">
                            <option value="" disabled selected>Choose a KPI</option>
                            @foreach($kpiOptions as $k)<option value="{{ $k['id'] }}">{{ $k['name'] }}</option>@endforeach
                        </select>
                        <i class="bi bi-chevron-down"></i>
                    </div>
                </div>
                <div class="fld">
                    <label for="target">Monthly target</label>
                    <div class="ctrl"><input id="target" name="monthly_target" type="text" placeholder="No default"></div>
                </div>
                <div class="fld">
                    <label for="weight">Weight (0-1)</label>
                    <div class="ctrl"><input id="weight" name="weight" type="number" step="0.01" min="0" max="1" placeholder="1"></div>
                </div>
            </div>
            <div class="fbtns">
                <button type="submit" class="btn red">Assign for this period</button>
                <span class="btn"><i class="bi bi-calendar3"></i>{{ $assignPeriod }}</span>
            </div>
        </form>
    </details>
 
    {{-- Sumber data --}}
    <div class="source">
        <h3><i class="bi bi-question-circle"></i>Where these figures come from</h3>
        <p>KPI figures are automatically synced from the source spreadsheet or Marketing Performance data. They are not entered manually on this page.
           </p>
    </div>
 
</div>
@endsection
 