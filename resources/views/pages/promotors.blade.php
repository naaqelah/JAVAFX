{{-- resources/views/operations/promotors.blade.php --}}
@extends('layouts.app')
 
@php
    // ====== DATA (timpa dari controller: return view('operations.promotors', compact(...))) ======
    $attention      = $attention ?? 1;
    $attentionUrl   = $attentionUrl ?? '#';
    $importUrl      = $importUrl ?? '#';
    $accountUrl     = $accountUrl ?? '#';
    $reportingPeriod = $reportingPeriod ?? 'Week 1 — September 2026';
    $rosterPeriod    = $rosterPeriod ?? 'Week 2 — September 2026 · 08-14 September 2026';
    $promotorOptions = $promotorOptions ?? [['id' => 1, 'name' => 'Alfian'], ['id' => 2, 'name' => 'Gusti'], ['id' => 3, 'name' => 'Putri'], ['id' => 4, 'name' => 'Rizky']];
 
    // status akun: verified | not_found | missing      |   handle null => "— Not provided"
    $promotors = $promotors ?? [
        ['name' => 'Alfian', 'photo' => null, 'ig' => '@javafx.promo01', 'ig_status' => 'not_found', 'tt' => '@javafx.trader01',  'tt_status' => 'not_found', 'done' => 0, 'total' => 3, 'url' => '#'],
        ['name' => 'Gusti',  'photo' => null, 'ig' => '@scalping.id',    'ig_status' => 'missing',   'tt' => null,                'tt_status' => 'verified',  'done' => 0, 'total' => 3, 'url' => '#'],
        ['name' => 'Putri',  'photo' => null, 'ig' => '@chart.notes',    'ig_status' => 'not_found', 'tt' => '@market.recap.id',  'tt_status' => 'verified',  'done' => 0, 'total' => 3, 'url' => '#'],
        ['name' => 'Rizky',  'photo' => null, 'ig' => '@forex.insight',  'ig_status' => 'verified',  'tt' => '@forex.insight.tt', 'tt_status' => 'verified',  'done' => 0, 'total' => 3, 'url' => '#'],
    ];
    // Ringkasan (default = angka di desain; hitung dari database bila perlu)
    $stats = $stats ?? ['verified' => 0, 'not_found' => 4, 'missing_tiktok' => 1, 'not_checked' => 0];
 
    $statusLabel = ['verified' => 'Verified', 'not_found' => 'Not found', 'missing' => 'Missing'];
    $statusIcon  = ['verified' => 'bi-check-lg', 'not_found' => 'bi-exclamation-circle-fill', 'missing' => 'bi-exclamation-circle-fill'];
@endphp
 
@section('content')
{{-- CSS & ikon diletakkan di sini supaya tetap jalan walau layout belum punya @stack('styles') --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
<style>
    /* =========================================
       TOKENS & BASE (selaras dengan halaman lain)
    ========================================= */
    .pr, .pr * { box-sizing: border-box; }
 
    .pr {
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
 
    .pr h1, .pr h2, .pr h3, .pr p, .pr b { margin: 0; font-family: inherit; }
    .pr a { text-decoration: none; color: inherit; }
    .pr button, .pr select, .pr input { font-family: inherit; }
    .pr a:focus-visible, .pr button:focus-visible, .pr select:focus-visible, .pr input:focus-visible { outline: 2px solid #fff; outline-offset: 2px; }
 
    /* =========================================
       HEADER
    ========================================= */
    .pr .top h1 { font-size: 22.3px; font-weight: 600; line-height: 1.2; margin-bottom: 8px; }
    .pr .top .sub { color: var(--muted); font-size: 14.6px; font-weight: 500; margin-bottom: 22px; }
 
    /* =========================================
       BANNER PERHATIAN (dikembalikan persis seperti kode lama)
       zoom .75 = skala yang dulu dipakai oleh .pr, supaya ukurannya identik
    ========================================= */
    .pr .alert{zoom:.75;display:flex;align-items:center;gap:10px;background:#a31c1c;border-radius:6px;height:48px;padding:0 20px;font-size:17px;font-weight:500;margin-bottom:36px}
    .pr .alert .lead{font-size:20px}.pr .alert .go{margin-left:auto;font-size:20px}
 
    /* =========================================
       PANEL & FORM UMUM
    ========================================= */
    .pr .panel { padding: 24px; margin-bottom: 24px; background: var(--card); border: 1px solid var(--line); border-radius: var(--r-lg); box-shadow: 0 8px 24px rgba(0,0,0,.25); }
    .pr .panel h2 { font-size: 19px; font-weight: 600; letter-spacing: -.01em; margin-bottom: 4px; }
    .pr .panel .desc { font-size: 13.5px; color: var(--muted); }
    .pr .phead { display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; margin-bottom: 20px; }
    .pr hr { border: 0; border-top: 1px solid var(--line); margin: 20px 0 22px; }
    .pr label.l { display: block; font-size: 13.5px; font-weight: 600; margin-bottom: 10px; }
    .pr .hint { font-size: 13px; color: var(--muted); margin: 12px 0 18px; }
    .pr .note { display: flex; gap: 8px; align-items: center; font-size: 13px; color: var(--muted); margin-top: 14px; }
 
    .pr .inp {
        width: 100%; height: 48px; padding: 0 18px;
        font-size: 14px; color: #fff;
        background: var(--inner); border: 1px solid var(--line-strong); border-radius: 10px;
        outline: none; appearance: none; -webkit-appearance: none;
        transition: border-color .2s var(--ease), box-shadow .2s var(--ease);
    }
    .pr .inp::placeholder { color: #8b8b94; }
    .pr .inp:hover { border-color: #55555d; }
    .pr .inp:focus { border-color: #e0383d; box-shadow: 0 0 0 3px rgba(224,56,61,.2); }
    .pr .inp.pill { border-radius: 999px; padding: 0 22px; }
    .pr .sel { position: relative; }
    .pr .sel i { position: absolute; right: 18px; top: 50%; transform: translateY(-50%); pointer-events: none; font-size: 13px; color: var(--muted); }
    .pr .sel select.inp { padding-right: 44px; cursor: pointer; }
    .pr .sel select.inp:invalid { color: #8b8b94; }
    .pr .sel select.inp option { color: #000; }
 
    .pr .btn-full {
        width: 100%; height: 48px; display: flex; align-items: center; justify-content: center; gap: 10px;
        font-size: 15px; font-weight: 600; color: #fff; cursor: pointer;
        background: linear-gradient(145deg, var(--red), var(--red-deep)); border: 0; border-radius: 999px;
        box-shadow: 0 4px 14px rgba(165,31,35,.35);
        transition: background .2s var(--ease), transform .2s var(--ease);
    }
    .pr .btn-full:hover { background: linear-gradient(145deg, #d52c31, #b3242a); transform: translateY(-1px); }
 
    /* =========================================
       ADD ACCOUNTS
    ========================================= */
    .pr .period { display: flex; align-items: center; gap: 14px; padding: 10px 16px; background: var(--inner); border: 1px solid var(--line-strong); border-radius: var(--r-md); }
    .pr .period i { width: 38px; height: 38px; display: grid; place-items: center; font-size: 17px; color: #fff; background: linear-gradient(145deg, var(--red), var(--red-deep)); border-radius: 10px; }
    .pr .period small { display: block; font-size: 12px; color: var(--muted); }
    .pr .period b { font-size: 14px; font-weight: 600; }
 
    .pr .inner { padding: 22px 20px; background: var(--inner); border: 1px solid var(--line); border-radius: var(--r-md); }
    .pr .inner h3 { font-size: 15px; font-weight: 600; margin-bottom: 16px; }
    .pr .inner h3.s2 { margin: 28px 0 16px; padding-top: 24px; border-top: 1px solid var(--line); }
    .pr .inner .inp { background: #1a1a1d; }
    .pr .inner label.f { display: block; font-size: 13.5px; font-weight: 500; margin: 14px 0 8px; }
    .pr .inner label.f:first-of-type { margin-top: 0; }
    .pr .pair { display: grid; grid-template-rows: auto auto; grid-auto-flow: column; grid-auto-columns: 1fr; column-gap: 16px; }
    .pr .pair + .pair { margin-top: 18px; padding-top: 18px; border-top: 1px dashed var(--line-strong); }
    .pr .pair label.f { margin-top: 0; }
    .pr .pairfoot { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-top: 16px; }
    .pr .pairfoot span { font-size: 13px; color: var(--muted); }
 
    .pr .btn-sm { display: inline-flex; align-items: center; gap: 8px; height: 36px; padding: 0 14px; font-size: 13px; font-weight: 500; color: #fff; background: var(--card); border: 1px solid var(--line-strong); border-radius: 8px; cursor: pointer; transition: background .2s var(--ease), border-color .2s var(--ease); }
    .pr .btn-sm:hover { background: var(--red-deep); border-color: var(--red-deep); }
 
    .pr .formfoot { display: flex; justify-content: flex-end; gap: 12px; margin-top: 22px; }
    .pr .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 44px; padding: 0 18px; font-size: 14px; font-weight: 500; color: #fff; border: 1px solid transparent; border-radius: 10px; cursor: pointer; transition: background .2s var(--ease), border-color .2s var(--ease); }
    .pr .btn.cancel { min-width: 100px; color: var(--muted); background: transparent; border-color: var(--line-strong); }
    .pr .btn.cancel:hover { color: #fff; border-color: #55555d; }
    .pr .btn.save { background: linear-gradient(145deg, var(--red), var(--red-deep)); box-shadow: 0 4px 14px rgba(165,31,35,.35); }
    .pr .btn.save:hover { background: linear-gradient(145deg, #d52c31, #b3242a); }
    .pr .btn.gray { background: var(--inner); border-color: var(--line-strong); }
    .pr .btn.gray:hover { background: #2c2c32; border-color: #55555d; }
    .pr .pill-info { display: inline-flex; align-items: center; height: 44px; padding: 0 16px; font-size: 13.5px; font-weight: 500; background: var(--inner); border: 1px solid var(--line-strong); border-radius: 10px; }
 
    /* =========================================
       STATISTIK
    ========================================= */
    .pr .cards { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px; }
    .pr .sc { display: flex; align-items: center; gap: 14px; min-width: 0; padding: 18px; background: var(--inner); border: 1px solid var(--line); border-radius: var(--r-md); transition: border-color .2s var(--ease); }
    .pr .sc:hover { border-color: var(--line-strong); }
    .pr .sc .ic { flex: none; width: 44px; height: 44px; display: grid; place-items: center; font-size: 19px; color: #fff; background: linear-gradient(145deg, var(--red), var(--red-deep)); border-radius: 12px; box-shadow: 0 4px 12px rgba(165,31,35,.3); }
    .pr .sc small { display: block; font-size: 13px; color: var(--muted); }
    .pr .sc b { font-size: 24px; font-weight: 700; letter-spacing: -.02em; line-height: 1.2; }
 
    /* =========================================
       FILTER
    ========================================= */
    .pr .filters { display: grid; grid-template-columns: 1fr 260px; gap: 12px; margin: 0 0 16px; }
    .pr .search { position: relative; }
    .pr .search i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); font-size: 14px; color: var(--muted); pointer-events: none; }
    .pr .search input { width: 100%; height: 46px; padding: 0 18px 0 42px; font-size: 14px; color: #fff; background: var(--card); border: 1px solid var(--line-strong); border-radius: 10px; outline: none; transition: border-color .2s var(--ease), box-shadow .2s var(--ease); }
    .pr .search input::placeholder { color: #8b8b94; }
    .pr .search input:focus { border-color: #e0383d; box-shadow: 0 0 0 3px rgba(224,56,61,.2); }
    .pr .fsel { position: relative; height: 46px; background: var(--card); border: 1px solid var(--line-strong); border-radius: 10px; }
    .pr .fsel:hover { border-color: #55555d; }
    .pr .fsel select { appearance: none; -webkit-appearance: none; width: 100%; height: 100%; padding: 0 44px 0 18px; font-size: 14px; color: #fff; background: transparent; border: 0; border-radius: 10px; outline: none; cursor: pointer; }
    .pr .fsel select option { color: #000; }
    .pr .fsel i { position: absolute; right: 18px; top: 50%; transform: translateY(-50%); pointer-events: none; font-size: 13px; color: var(--muted); }
 
    /* =========================================
       TABEL
    ========================================= */
    .pr .tbl-wrap { overflow-x: auto; border-radius: var(--r-lg); }
    .pr .tbl { min-width: 980px; background: var(--card); border: 1px solid var(--line); border-radius: var(--r-lg); overflow: hidden; }
    .pr .tr { display: grid; grid-template-columns: minmax(150px,1.1fr) minmax(190px,1.5fr) minmax(150px,1.2fr) minmax(220px,1.8fr) minmax(130px,1fr) 100px; align-items: start; column-gap: 12px; padding: 0 20px; }
    .pr .th { align-items: center; height: 46px; font-size: 13px; font-weight: 500; color: var(--muted); background: var(--inner); border-bottom: 1px solid var(--line); }
    .pr .rowp { padding-top: 12px; padding-bottom: 12px; min-height: 108px; font-size: 14px; border-bottom: 1px solid var(--line); transition: background .2s var(--ease); }
    .pr .rowp:last-of-type { border-bottom: 0; }
    .pr .rowp:hover { background: rgba(255,255,255,.03); }
 
    .pr .prom { display: flex; align-items: center; gap: 12px; height: 40px; font-weight: 600; font-size: 15px; }
    .pr .av { width: 38px; height: 38px; flex: none; overflow: hidden; display: grid; place-items: center; font-size: 15px; font-weight: 600; background: linear-gradient(135deg, #4b5563, #27272a); border: 2px solid var(--line-strong); border-radius: 50%; }
    .pr .av img { width: 100%; height: 100%; object-fit: cover; }
 
    .pr .acc { display: flex; align-items: center; gap: 12px; min-height: 40px; overflow-wrap: anywhere; }
    .pr .soc { width: 28px; height: 28px; flex: none; display: grid; place-items: center; font-size: 15px; color: #fff; border-radius: 8px; }
    .pr .soc.ig { background: linear-gradient(45deg, #f09433, #e6683c 30%, #dc2743 55%, #bc1888); }
    .pr .soc.tt { background: transparent; font-size: 21px; }
    .pr .soc.tt i { filter: drop-shadow(1.5px 1px 0 #25f4ee) drop-shadow(-1.5px -1px 0 #fe2c55); }
    .pr .acc .none { color: var(--muted); }
 
    .pr .vs { display: flex; align-items: center; min-height: 40px; }
    .pr .vb { display: inline-flex; align-items: center; gap: 8px; padding: 4px 12px 4px 9px; font-size: 12.5px; font-weight: 500; line-height: 1.4; border: 1px solid; border-radius: 999px; }
    .pr .vb i { font-size: 13px; }
    .pr .vb.verified  { color: #5eeaa8; background: rgba(34,201,133,.12); border-color: rgba(34,201,133,.35); }
    .pr .vb.not_found { color: #ff8b8e; background: rgba(224,56,61,.14); border-color: rgba(224,56,61,.45); }
    .pr .vb.missing   { color: #ffc75a; background: rgba(245,183,43,.12); border-color: rgba(245,183,43,.4); }
 
    .pr .chk { display: flex; flex-wrap: wrap; gap: 8px 22px; align-items: center; min-height: 40px; }
    .pr .chk span { display: inline-flex; align-items: center; gap: 10px; font-size: 14px; }
    .pr .chk i.c { position: relative; width: 18px; height: 18px; display: inline-block; border: 1.5px solid #71717a; border-radius: 50%; }
    .pr .chk i.c.on { background: var(--green); border-color: var(--green); }
    .pr .chk i.c.on::after { content: "✓"; position: absolute; inset: 0; font-style: normal; font-size: 11px; line-height: 15px; text-align: center; color: #fff; }
 
    .pr .prog { padding-top: 10px; }
    .pr .prog .bar { width: calc(100% - 12px); height: 8px; overflow: hidden; background: rgba(255,255,255,.1); border-radius: 6px; }
    .pr .prog .bar i { display: block; height: 100%; background: linear-gradient(90deg, var(--red-deep), #e0383d); border-radius: 6px; }
    .pr .prog small { display: block; margin-top: 8px; font-size: 13px; color: var(--muted); }
 
    .pr .view { display: inline-flex; align-items: center; gap: 8px; height: 36px; padding: 0 14px; font-size: 13px; font-weight: 500; background: var(--inner); border: 1px solid var(--line-strong); border-radius: 8px; transition: background .2s var(--ease), border-color .2s var(--ease); }
    .pr .view:hover { background: var(--red-deep); border-color: var(--red-deep); }
    .pr .nores { display: none; padding: 34px; text-align: center; color: var(--muted); }
 
    /* =========================================
       FOOTER TABEL
    ========================================= */
    .pr .foot { display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; margin: 18px 4px 0; font-size: 13.5px; }
    .pr .foot .info { color: var(--muted); }
    .pr .pager { display: flex; align-items: center; gap: 10px; color: var(--muted); }
    .pr .rpp { position: relative; width: 84px; height: 38px; background: var(--card); border: 1px solid var(--line-strong); border-radius: 8px; }
    .pr .rpp select { appearance: none; -webkit-appearance: none; width: 100%; height: 100%; padding: 0 30px 0 14px; font-size: 13.5px; font-weight: 500; color: #fff; background: transparent; border: 0; cursor: pointer; outline: none; }
    .pr .rpp select option { color: #000; }
    .pr .rpp i { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none; font-size: 11px; color: var(--muted); }
    .pr .pg { width: 38px; height: 38px; display: grid; place-items: center; font-size: 14px; color: #fff; background: var(--card); border: 1px solid var(--line-strong); border-radius: 8px; cursor: pointer; transition: background .2s var(--ease); }
    .pr .pg:hover:not(:disabled) { background: #2c2c32; }
    .pr .pg.on { background: var(--red-deep); border-color: var(--red-deep); font-weight: 600; }
    .pr .pg:disabled { opacity: .4; cursor: default; }
    .pr .rpp-label { margin-right: 4px; }
 
    /* =========================================
       TABLET
    ========================================= */
    @media (max-width: 1100px) {
        .pr .top h1 { font-size: 20.8px; }
        .pr .top .sub { font-size: 13.1px; }
        .pr .cards { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 900px) {
        .pr .filters { grid-template-columns: 1fr; }
    }
 
    /* =========================================
       MOBILE: tabel berubah menjadi kartu
    ========================================= */
    @media (max-width: 768px) {
        .pr { padding: 84px 16px 40px; font-size: 16px; }
        .pr .top h1 { font-size: 33px; }
        .pr .top .sub { font-size: 19px; line-height: 1.55; }
 
        .pr .panel { padding: 18px 16px; }
        .pr .panel h2 { font-size: 21px; }
        .pr .panel .desc { font-size: 14px; }
        .pr .phead { flex-direction: column; align-items: stretch; }
        .pr .phead > div[style] { flex-direction: column; align-items: stretch !important; gap: 10px !important; }
        .pr .period { width: 100%; }
        .pr .inp, .pr .btn-full { height: 52px; font-size: 16px; }
        .pr .pair { display: block; }
        .pr .pair label.f { margin-top: 14px; }
        .pr .pair label.f:first-child { margin-top: 0; }
        .pr .formfoot .btn { flex: 1; height: 48px; }
        .pr .pairfoot { flex-wrap: wrap; }
        .pr .btn-sm { height: 42px; }
 
        .pr .cards { gap: 10px; }
        .pr .sc { gap: 10px; padding: 14px; }
        .pr .sc .ic { width: 38px; height: 38px; font-size: 17px; }
        .pr .sc b { font-size: 22px; }
 
        .pr .search input, .pr .fsel { height: 50px; }
        .pr .search input, .pr .fsel select { font-size: 16px; }
 
        .pr .tbl-wrap { overflow: visible; }
        .pr .tbl { min-width: 0; background: transparent; border: 0; border-radius: 0; overflow: visible; }
        .pr .th { display: none; }
        .pr .rowp {
            grid-template-columns: 1fr 1fr;
            grid-template-areas: "prom view" "acc ver" "chk chk" "prog prog";
            gap: 8px 12px; padding: 16px 14px; min-height: 0; margin-bottom: 12px;
            background: var(--card); border: 1px solid var(--line); border-radius: var(--r-md);
        }
        .pr .rowp:last-of-type { border-bottom: 1px solid var(--line); }
        .pr .rowp > :nth-child(1) { grid-area: prom; }
        .pr .rowp > :nth-child(2) { grid-area: acc; min-width: 0; }
        .pr .rowp > :nth-child(3) { grid-area: ver; justify-self: end; }
        .pr .rowp > :nth-child(4) { grid-area: chk; padding-top: 8px; border-top: 1px solid var(--line); }
        .pr .rowp > :nth-child(5) { grid-area: prog; padding-top: 0; }
        .pr .rowp > :nth-child(5) .bar { width: 100%; }
        .pr .rowp > :nth-child(6) { grid-area: view; justify-self: end; }
        .pr .view { height: 40px; }
 
        .pr .foot { justify-content: center; }
        .pr .pager { flex-wrap: wrap; justify-content: center; }
    }
 
    @media (max-width: 480px) {
        .pr { padding: 84px 14px 36px; }
        .pr .top h1 { font-size: 31px; }
        .pr .top .sub { font-size: 18px; }
        .pr .cards { grid-template-columns: 1fr; }
        .pr .rowp { grid-template-columns: 1fr; grid-template-areas: "prom" "view" "acc" "ver" "chk" "prog"; }
        .pr .rowp > :nth-child(3), .pr .rowp > :nth-child(6) { justify-self: start; }
    }
 
    @media (max-width: 360px) {
        .pr { padding-left: 12px; padding-right: 12px; }
        .pr .top h1 { font-size: 28px; }
        .pr .top .sub { font-size: 17px; }
    }
 
    @media (prefers-reduced-motion: reduce) {
        .pr *, .pr *::before { transition: none !important; }
    }
</style>
 
<div class="pr">
 
    <div class="top">
        <h1>Promoters</h1>
        <div class="sub">Influencer handles, verification and post checklists</div>
    </div>
 
    @if($attention > 0)
        <a href="{{ $attentionUrl }}" class="alert">
            <i class="bi bi-exclamation-triangle lead"></i>{{ $attention }} item{{ $attention > 1 ? 's' : '' }} needs attention
            <i class="bi bi-arrow-right go"></i>
        </a>
    @endif
 
    {{-- ========== IMPORT FROM SHEET ========== --}}
    <form method="POST" action="{{ $importUrl }}" class="panel">
        @csrf
        <h2>Import from sheet</h2>
        <div class="desc">Reads the tracking sheet your scraper writes. Nothing is written back to it.</div>
        <hr>
        <label class="l" for="sheet">Google Sheets URL or Spreadsheet ID</label>
        <input id="sheet" name="sheet" type="text" class="inp pill" placeholder="Paste your Google Sheets link here...">
        <div class="hint">Make sure the spreadsheet is accessible to the connected account. Connect spreadsheet</div>
        <button type="submit" class="btn-full"><i class="bi bi-box-arrow-up-right"></i>Connect spreadsheet</button>
        <div class="note"><i class="bi bi-info-circle"></i>Data is imported in read-only mode. Changes must be made in the source spreadsheet.</div>
    </form>
 
    {{-- ========== ADD ACCOUNTS ========== --}}
    <form method="POST" action="{{ $accountUrl }}" class="panel" id="accountForm">
        @csrf
        <div class="phead">
            <div>
                <h2>Add accounts</h2>
                <div class="desc">Register promoter accounts and connect their Instagram and TikTok usernames.</div>
            </div>
            <div class="period"><i class="bi bi-calendar3"></i><div><small>Reporting Period</small><b>{{ $reportingPeriod }}</b></div></div>
        </div>
 
        <div class="inner">
            <h3>Promoter information</h3>
            <div class="sel">
                <select name="promoter_id" class="inp" required>
                    <option value="" selected disabled>Choose a promotor</option>
                    @foreach($promotorOptions as $o)<option value="{{ $o['id'] }}">{{ $o['name'] }}</option>@endforeach
                </select>
                <i class="bi bi-chevron-down"></i>
            </div>
            <label class="f" style="margin-top:14px" for="dn">Display name (optional)</label>
            <input id="dn" name="display_name" type="text" class="inp" placeholder="Enter display name">
 
            <h3 class="s2">Social media accounts</h3>
            <div id="pairs">
                <div class="pair">
                    <label class="f">Instagram username</label>
                    <input name="instagram[]" type="text" class="inp" placeholder="@username_instagram">
                    <label class="f">Tiktok username</label>
                    <input name="tiktok[]" type="text" class="inp" placeholder="@username_tiktok">
                </div>
            </div>
            <div class="pairfoot">
                <span id="pairCount">1 account pair</span>
                <button type="button" class="btn-sm" id="addPair"><i class="bi bi-plus-lg"></i>Add Another Pair</button>
            </div>
        </div>
 
        <div class="formfoot">
            <button type="reset" class="btn cancel">Cancel</button>
            <button type="submit" class="btn save"><i class="bi bi-check-lg"></i>Save Account</button>
        </div>
    </form>
 
    {{-- ========== ROSTER ========== --}}
    <div class="panel">
        <div class="phead" style="margin-bottom:0">
            <div>
                <h2>Promoter roster &amp; post checklist</h2>
                <div class="desc">Reads the tracking sheet your scraper writes. Nothing is written back to it.</div>
            </div>
            <div style="display:flex;gap:12px;align-items:center">
                <span class="pill-info">{{ $rosterPeriod }}</span>
                <a href="{{ $verifyUrl ?? '#' }}" class="btn gray"><i class="bi bi-arrow-repeat"></i>Verify Tiktok</a>
            </div>
        </div>
        <hr>
        <div class="cards">
            <div class="sc"><div class="ic"><i class="bi bi-patch-check"></i></div><div><small>Verifield</small><b>{{ $stats['verified'] }}</b></div></div>
            <div class="sc"><div class="ic"><i class="bi bi-x-circle"></i></div><div><small>Not found</small><b>{{ $stats['not_found'] }}</b></div></div>
            <div class="sc"><div class="ic"><i class="bi bi-exclamation-triangle"></i></div><div><small>Missing Tiktok</small><b>{{ $stats['missing_tiktok'] }}</b></div></div>
            <div class="sc"><div class="ic"><i class="bi bi-clock"></i></div><div><small>Not checker</small><b>{{ $stats['not_checked'] }}</b></div></div>
        </div>
    </div>
 
    <div class="filters">
        <div class="search"><i class="bi bi-search"></i><input type="text" id="q" placeholder="Search promoter, IG or TikTok username..."></div>
        <div class="fsel">
            <select id="st">
                <option value="">All status</option>
                <option value="verified">Verified</option>
                <option value="not_found">Not found</option>
                <option value="missing">Missing</option>
            </select>
            <i class="bi bi-chevron-down"></i>
        </div>
    </div>
 
    <div class="tbl-wrap"><div class="tbl">
        <div class="tr th">
            <div>Promotor</div><div>Social media account</div><div>Verification status</div><div>Post Checklist (3 post)</div><div>Progress</div><div>Actions</div>
        </div>
 
        @foreach($promotors as $p)
            @php
                $pct = $p['total'] > 0 ? round($p['done'] / $p['total'] * 100) : 0;
                $search = strtolower($p['name'] . ' ' . ($p['ig'] ?? '') . ' ' . ($p['tt'] ?? ''));
            @endphp
            <div class="tr rowp prow" data-search="{{ $search }}" data-status="{{ $p['ig_status'] }} {{ $p['tt_status'] }}">
                <div class="prom">
                    <span class="av">@if(!empty($p['photo']))<img src="{{ $p['photo'] }}" alt="{{ $p['name'] }}">@else{{ strtoupper(mb_substr($p['name'], 0, 1)) }}@endif</span>
                    {{ $p['name'] }}
                </div>
                <div>
                    <div class="acc"><span class="soc ig"><i class="bi bi-instagram"></i></span>{{ $p['ig'] ?? '— Not provided' }}</div>
                    <div class="acc"><span class="soc tt"><i class="bi bi-tiktok"></i></span><span class="{{ $p['tt'] ? '' : 'none' }}">{{ $p['tt'] ?? '— Not provided' }}</span></div>
                </div>
                <div>
                    <div class="vs"><span class="vb {{ $p['ig_status'] }}"><i class="bi {{ $statusIcon[$p['ig_status']] }}"></i>{{ $statusLabel[$p['ig_status']] }}</span></div>
                    <div class="vs"><span class="vb {{ $p['tt_status'] }}"><i class="bi {{ $statusIcon[$p['tt_status']] }}"></i>{{ $statusLabel[$p['tt_status']] }}</span></div>
                </div>
                <div class="chk">
                    @for($i = 1; $i <= $p['total']; $i++)
                        <span><i class="c {{ $i <= $p['done'] ? 'on' : '' }}"></i>Post</span>
                    @endfor
                </div>
                <div class="prog">
                    <div class="bar"><i style="width:{{ $pct }}%"></i></div>
                    <small>{{ $p['done'] }}/{{ $p['total'] }}</small>
                </div>
                <div><a href="{{ $p['url'] ?? '#' }}" class="view"><i class="bi bi-box-arrow-up-right"></i>View</a></div>
            </div>
        @endforeach
        <div class="nores" id="none">No promoters match.</div>
    </div></div>
 
    <div class="foot">
        <div class="info" id="showing">Showing 1 - {{ count($promotors) }} of {{ count($promotors) }} promoters</div>
        <div class="pager">
            <span class="rpp-label">Rows per page</span>
            <div class="rpp">
                <select id="rpp"><option>10</option><option>25</option><option>50</option></select>
                <i class="bi bi-chevron-down"></i>
            </div>
            <button type="button" class="pg" id="prev"><i class="bi bi-chevron-left"></i></button>
            <button type="button" class="pg on" id="pageNo">1</button>
            <button type="button" class="pg" id="next"><i class="bi bi-chevron-right"></i></button>
        </div>
    </div>
 
</div>
 
<script>
(() => {
    // ---- Add Another Pair ----
    const pairs = document.getElementById('pairs'), count = document.getElementById('pairCount');
    document.getElementById('addPair').addEventListener('click', () => {
        const c = pairs.firstElementChild.cloneNode(true);
        c.querySelectorAll('input').forEach(i => i.value = '');
        pairs.appendChild(c);
        count.textContent = pairs.children.length + ' account pairs';
    });
    document.getElementById('accountForm').addEventListener('reset', () => {
        while (pairs.children.length > 1) pairs.lastElementChild.remove();
        count.textContent = '1 account pair';
    });
 
    // ---- Search + filter + pagination tabel ----
    const rows = [...document.querySelectorAll('.pr .prow')];
    const q = document.getElementById('q'), st = document.getElementById('st'), rpp = document.getElementById('rpp');
    const prev = document.getElementById('prev'), next = document.getElementById('next'), pageNo = document.getElementById('pageNo');
    const none = document.getElementById('none'), showing = document.getElementById('showing');
    let page = 1;
    const render = () => {
        const term = q.value.trim().toLowerCase(), status = st.value, per = +rpp.value;
        const match = rows.filter(r => (!term || r.dataset.search.includes(term)) && (!status || r.dataset.status.split(' ').includes(status)));
        const pages = Math.max(1, Math.ceil(match.length / per));
        page = Math.min(page, pages);
        const start = (page - 1) * per;
        rows.forEach(r => r.style.display = 'none');
        match.slice(start, start + per).forEach(r => r.style.display = '');
        none.style.display = match.length ? 'none' : 'block';
        showing.textContent = match.length
            ? `Showing ${start + 1} - ${Math.min(start + per, match.length)} of ${match.length} promoters`
            : 'Showing 0 promoters';
        pageNo.textContent = page;
        prev.disabled = page <= 1; next.disabled = page >= pages;
    };
    [q, st].forEach(e => e.addEventListener('input', () => { page = 1; render(); }));
    rpp.addEventListener('change', () => { page = 1; render(); });
    prev.addEventListener('click', () => { page--; render(); });
    next.addEventListener('click', () => { page++; render(); });
    render();
})();
</script>
@endsection
 