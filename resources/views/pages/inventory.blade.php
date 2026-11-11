{{-- resources/views/operations/inventory.blade.php --}}
@extends('layouts.app')
 
@php
    // ====== DATA (timpa dari controller: return view('operations.inventory', compact(...))) ======
    $attention    = $attention ?? 1;
    $attentionUrl = $attentionUrl ?? '#';
    $addUrl       = url('/inventory/create');
 
    // Ringkasan "Stock on hand" (isi dari database; default = angka di desain)
    $stats = $stats ?? ['items' => 1, 'units' => 2, 'valuation' => 0, 'low' => 0];
 
    // Merchandise: status normal | low
    $merch = $merch ?? [
        ['name' => 'Lampu',   'category' => 'Listrik', 'on_hand' => 24, 'minimum' => 5,  'unit_cost' => 25000, 'status' => 'normal'],
        ['name' => 'Kabel',   'category' => 'Listrik', 'on_hand' => 15, 'minimum' => 5,  'unit_cost' => 8000,  'status' => 'normal'],
        ['name' => 'Sakelar', 'category' => 'Listrik', 'on_hand' => 12, 'minimum' => 3,  'unit_cost' => 15000, 'status' => 'normal'],
        ['name' => 'Sekring', 'category' => 'Listrik', 'on_hand' => 30, 'minimum' => 10, 'unit_cost' => 5000,  'status' => 'normal'],
    ];
 
    // Equipment
    $equipment = $equipment ?? [
        ['name' => 'Lampu',   'category' => 'Listrik', 'on_hand' => 24, 'unit_cost' => 0, 'stock_value' => 600000],
        ['name' => 'Kabel',   'category' => 'Listrik', 'on_hand' => 15, 'unit_cost' => 0, 'stock_value' => 120000],
        ['name' => 'Sakelar', 'category' => 'Listrik', 'on_hand' => 12, 'unit_cost' => 0, 'stock_value' => 180000],
        ['name' => 'Sekring', 'category' => 'Listrik', 'on_hand' => 30, 'unit_cost' => 0, 'stock_value' => 150000],
    ];
 
    // Log: type in | out
    $logs = $logs ?? [
        ['type' => 'out', 'item' => 'Tumbler',  'item_type' => 'Merchandise', 'delta' => -10, 'balance' => 90, 'note' => 'Giveaway',    'by' => 'Reinhart Okta Putra', 'by_at' => '2 Nov 2026, 20:54', 'date' => '2 Nov 2026', 'time' => '20:54'],
        ['type' => 'out', 'item' => 'Notebook', 'item_type' => 'Merchandise', 'delta' => -10, 'balance' => 90, 'note' => 'Giveaway',    'by' => 'Reinhart Okta Putra', 'by_at' => '2 Nov 2026, 20:54', 'date' => '1 Nov 2026', 'time' => '16:30'],
        ['type' => 'out', 'item' => 'Notebook', 'item_type' => 'Merchandise', 'delta' => -10, 'balance' => 90, 'note' => 'Seminar Kit', 'by' => 'Andi Pratama',        'by_at' => '1 Nov 2026, 14:15', 'date' => '1 Nov 2026', 'time' => '14:15'],
        ['type' => 'out', 'item' => 'Mug',      'item_type' => 'Merchandise', 'delta' => -10, 'balance' => 90, 'note' => 'Giveaway',    'by' => 'Reinhart Okta Putra', 'by_at' => '2 Nov 2026, 20:54', 'date' => '1 Oct 2026', 'time' => '16:30'],
    ];
 
    $rp = fn ($n) => 'Rp ' . number_format($n, 0, ',', '.');
@endphp
 
@section('content')
{{-- CSS & ikon diletakkan di sini supaya tetap jalan walau layout belum punya @stack('styles') --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
<style>
    /* =========================================
       TOKENS & BASE (selaras dengan halaman lain)
    ========================================= */
    .iv, .iv * { box-sizing: border-box; }
 
    .iv {
        --card: #1a1a1d;
        --inner: #222226;
        --line: #2e2e33;
        --line-strong: #3d3d44;
        --muted: #a1a1aa;
        --red: #c8262b;
        --red-deep: #a51f23;
        --green: #22c985;
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
 
    .iv h1, .iv h2, .iv p, .iv b { margin: 0; font-family: inherit; }
    .iv a { text-decoration: none; color: inherit; }
    .iv button, .iv select, .iv input { font-family: inherit; }
    .iv a:focus-visible, .iv button:focus-visible, .iv select:focus-visible, .iv input:focus-visible { outline: 2px solid #fff; outline-offset: 2px; }
 
    /* =========================================
       HEADER
    ========================================= */
    .iv .top h1 { font-size: 22.3px; font-weight: 600; line-height: 1.2; margin-bottom: 8px; }
    .iv .top .sub { color: var(--muted); font-size: 14.6px; font-weight: 500; margin-bottom: 22px; }
 
    /* =========================================
       BANNER PERHATIAN (dikembalikan persis seperti kode lama)
       zoom .75 = skala yang dulu dipakai oleh .iv, supaya ukurannya identik
    ========================================= */
    .iv .alert{zoom:.75;display:flex;align-items:center;gap:10px;background:#a31c1c;border-radius:6px;height:48px;padding:0 20px;font-size:17px;font-weight:500;margin-bottom:36px}
    .iv .alert .lead{font-size:20px}.iv .alert .go{margin-left:auto;font-size:20px}
 
    /* =========================================
       STOCK ON HAND
    ========================================= */
    .iv .stock { padding: 22px; margin-bottom: 32px; background: var(--card); border: 1px solid var(--line); border-radius: var(--r-lg); box-shadow: 0 8px 24px rgba(0,0,0,.25); }
    .iv .stock-head { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 18px; }
    .iv .stock-head h2 { font-size: 19px; font-weight: 600; letter-spacing: -.01em; }
    .iv .btn-add {
        display: inline-flex; align-items: center; gap: 8px; height: 42px; padding: 0 18px;
        font-size: 14px; font-weight: 500; color: #fff; white-space: nowrap;
        background: linear-gradient(145deg, var(--red), var(--red-deep));
        border-radius: 10px; box-shadow: 0 4px 14px rgba(165,31,35,.35);
        transition: background .2s var(--ease), transform .2s var(--ease);
    }
    .iv .btn-add:hover { background: linear-gradient(145deg, #d52c31, #b3242a); transform: translateY(-1px); }
    .iv .btn-add i { font-size: 17px; }
 
    .iv .cards { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px; }
    .iv .sc { display: flex; align-items: center; gap: 14px; min-width: 0; padding: 18px; background: var(--inner); border: 1px solid var(--line); border-radius: var(--r-md); transition: border-color .2s var(--ease); }
    .iv .sc:hover { border-color: var(--line-strong); }
    .iv .sc .ic { flex: none; width: 44px; height: 44px; display: grid; place-items: center; font-size: 19px; color: #fff; background: linear-gradient(145deg, var(--red), var(--red-deep)); border-radius: 12px; box-shadow: 0 4px 12px rgba(165,31,35,.3); }
    .iv .sc small { display: block; font-size: 13px; color: var(--muted); }
    .iv .sc b { display: block; font-size: 22px; font-weight: 700; letter-spacing: -.02em; line-height: 1.2; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .iv .sc > div:last-child { min-width: 0; }
 
    /* =========================================
       SEKSI & TABEL
    ========================================= */
    .iv .section { margin-bottom: 32px; }
    .iv .sec-title { font-size: 19px; font-weight: 600; letter-spacing: -.01em; margin: 0 0 14px 2px; }
 
    .iv .tbl-wrap { overflow-x: auto; border-radius: var(--r-lg); }
    .iv .tbl { min-width: 900px; background: var(--card); border: 1px solid var(--line); border-radius: var(--r-lg); overflow: hidden; }
    .iv .tr { display: grid; align-items: center; column-gap: 10px; padding: 0 18px 0 20px; }
    .iv .th { height: 46px; font-size: 13px; font-weight: 500; color: var(--muted); background: var(--inner); border-bottom: 1px solid var(--line); }
    .iv .rowp { min-height: 58px; font-size: 14px; border-bottom: 1px solid var(--line); transition: background .2s var(--ease); }
    .iv .rowp:last-child { border-bottom: 0; }
    .iv .rowp:hover { background: rgba(255,255,255,.035); }
    .iv .c { text-align: center; }
    .iv .first { padding-left: 0; font-weight: 600; }
    .iv .th .first { font-weight: 500; }
 
    .iv .t-merch { grid-template-columns: minmax(150px,1.4fr) minmax(100px,1fr) 90px 90px 120px 130px 120px 110px; }
    .iv .t-equip { grid-template-columns: minmax(150px,1.6fr) minmax(100px,1fr) 90px 120px 140px 110px; }
    .iv .t-merch.rowp, .iv .t-equip.rowp { min-height: 58px; }
 
    .iv .badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 11px 4px 9px; font-size: 12.5px; font-weight: 500; line-height: 1.4; border-radius: 999px; border: 1px solid; }
    .iv .badge::before { content: ""; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .iv .badge.normal { color: #5eeaa8; background: rgba(34,201,133,.12); border-color: rgba(34,201,133,.35); }
    .iv .badge.low { color: #ff8b8e; background: rgba(224,56,61,.14); border-color: rgba(224,56,61,.45); }
 
    .iv .adj { display: inline-flex; align-items: center; justify-content: center; gap: 7px; height: 32px; padding: 0 14px; font-size: 13px; font-weight: 500; color: #fff; background: var(--inner); border: 1px solid var(--line-strong); border-radius: 8px; cursor: pointer; transition: background .2s var(--ease), border-color .2s var(--ease); }
    .iv .adj:hover { background: var(--red-deep); border-color: var(--red-deep); }
 
    /* =========================================
       LOG
    ========================================= */
    .iv .log-head { display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; margin-bottom: 14px; }
    .iv .log-head .sec-title { margin: 0; }
    .iv .tools { display: flex; gap: 12px; flex-wrap: wrap; }
 
    .iv .search { position: relative; width: 320px; max-width: 100%; }
    .iv .search i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: 14px; pointer-events: none; }
    .iv .search input { width: 100%; height: 42px; padding: 0 16px 0 42px; font-size: 14px; color: #fff; background: var(--inner); border: 1px solid var(--line-strong); border-radius: 10px; outline: none; transition: border-color .2s var(--ease), box-shadow .2s var(--ease); }
    .iv .search input::placeholder { color: #8b8b94; }
    .iv .search input:focus { border-color: #e0383d; box-shadow: 0 0 0 3px rgba(224,56,61,.2); }
 
    .iv .filter { position: relative; width: 150px; height: 42px; background: var(--inner); border: 1px solid var(--line-strong); border-radius: 10px; }
    .iv .filter:hover { border-color: #55555d; }
    .iv .filter select { appearance: none; -webkit-appearance: none; width: 100%; height: 100%; padding: 0 36px 0 40px; font-size: 14px; font-weight: 500; color: #fff; background: transparent; border: 0; border-radius: 10px; cursor: pointer; outline: none; }
    .iv .filter select option { color: #000; }
    .iv .filter .l { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); pointer-events: none; font-size: 17px; }
    .iv .filter .r { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); pointer-events: none; font-size: 11px; color: var(--muted); }
 
    .iv .t-log { grid-template-columns: 110px minmax(150px,1.3fr) 130px minmax(110px,1fr) minmax(170px,1.6fr) 110px 36px; }
    .iv .t-log.rowp { min-height: 76px; padding-top: 10px; padding-bottom: 10px; }
    .iv .t-log .type { padding-left: 0; }
 
    .iv .out, .iv .in { display: inline-flex; align-items: center; gap: 8px; height: 30px; padding: 0 12px 0 10px; font-size: 13px; font-weight: 600; letter-spacing: .4px; border-radius: 999px; border: 1px solid; }
    .iv .out { color: #ff8b8e; background: rgba(224,56,61,.14); border-color: rgba(224,56,61,.45); }
    .iv .in { color: #5eeaa8; background: rgba(34,201,133,.12); border-color: rgba(34,201,133,.35); }
    .iv .out i, .iv .in i { font-size: 14px; }
 
    .iv .item b { display: block; font-weight: 600; }
    .iv .item { font-size: 13px; color: var(--muted); }
    .iv .item b { font-size: 14px; color: #f4f4f5; }
    .iv .chg { font-weight: 700; color: #ff5a5f; }
    .iv .chg.pos { color: var(--green); }
    .iv .chg i { font-size: 10px; margin: 0 4px; opacity: .8; }
    .iv .by span { display: block; }
    .iv .by span:last-child { font-size: 12.5px; color: var(--muted); }
    .iv .dots { display: grid; place-items: center; width: 32px; height: 32px; font-size: 17px; color: var(--muted); border-radius: 8px; cursor: pointer; transition: background .2s var(--ease), color .2s var(--ease); }
    .iv .dots:hover { background: var(--inner); color: #fff; }
    .iv .nores { display: none; padding: 34px; text-align: center; color: var(--muted); }
 
    /* =========================================
       TABLET
    ========================================= */
    @media (max-width: 1100px) {
        .iv .top h1 { font-size: 20.8px; }
        .iv .top .sub { font-size: 13.1px; }
        .iv .cards { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
 
    /* =========================================
       MOBILE: tabel berubah menjadi kartu
    ========================================= */
    @media (max-width: 768px) {
        .iv { padding: 84px 16px 40px; font-size: 16px; }
        .iv .top h1 { font-size: 33px; }
        .iv .top .sub { font-size: 19px; line-height: 1.55; }
 
        .iv .stock { padding: 18px 16px; }
        .iv .stock-head h2 { font-size: 21px; }
        .iv .btn-add { height: 46px; font-size: 15px; }
        .iv .sc b { font-size: 21px; }
        .iv .sc small { font-size: 14px; }
        .iv .sec-title { font-size: 21px; }
 
        .iv .tbl-wrap { overflow: visible; }
        .iv .tbl { min-width: 0; background: transparent; border: 0; border-radius: 0; overflow: visible; }
        .iv .th { display: none; }
        .iv .rowp {
            gap: 10px 12px; padding: 16px 14px; min-height: 0; margin-bottom: 12px;
            background: var(--card); border: 1px solid var(--line); border-radius: var(--r-md);
        }
        .iv .rowp:last-child { border-bottom: 1px solid var(--line); }
        .iv .rowp.t-merch, .iv .rowp.t-equip { grid-template-columns: 1fr 1fr; }
        .iv .rowp .first { font-size: 17px; }
        .iv .rowp .c { text-align: left; }
 
        /* Merchandise: item, category, on hand, minimum, unit cost, valuation, status, adjust */
        .iv .t-merch.rowp { grid-template-areas: "n s" "cat cat" "oh mn" "uc va" "adj adj"; }
        .iv .t-merch.rowp > :nth-child(1) { grid-area: n; }
        .iv .t-merch.rowp > :nth-child(2) { grid-area: cat; color: var(--muted); }
        .iv .t-merch.rowp > :nth-child(3) { grid-area: oh; }
        .iv .t-merch.rowp > :nth-child(4) { grid-area: mn; }
        .iv .t-merch.rowp > :nth-child(5) { grid-area: uc; }
        .iv .t-merch.rowp > :nth-child(6) { grid-area: va; }
        .iv .t-merch.rowp > :nth-child(7) { grid-area: s; justify-self: end; }
        .iv .t-merch.rowp > :nth-child(8) { grid-area: adj; }
        .iv .t-merch.rowp > :nth-child(3)::before { content: "On hand"; }
        .iv .t-merch.rowp > :nth-child(4)::before { content: "Minimum"; }
        .iv .t-merch.rowp > :nth-child(5)::before { content: "Unit cost"; }
        .iv .t-merch.rowp > :nth-child(6)::before { content: "Valuation"; }
 
        /* Equipment: item, category, on hand, unit cost, stock value, adjust */
        .iv .t-equip.rowp { grid-template-areas: "n n" "cat cat" "oh uc" "sv sv" "adj adj"; }
        .iv .t-equip.rowp > :nth-child(1) { grid-area: n; }
        .iv .t-equip.rowp > :nth-child(2) { grid-area: cat; color: var(--muted); }
        .iv .t-equip.rowp > :nth-child(3) { grid-area: oh; }
        .iv .t-equip.rowp > :nth-child(4) { grid-area: uc; }
        .iv .t-equip.rowp > :nth-child(5) { grid-area: sv; }
        .iv .t-equip.rowp > :nth-child(6) { grid-area: adj; }
        .iv .t-equip.rowp > :nth-child(3)::before { content: "On hand"; }
        .iv .t-equip.rowp > :nth-child(4)::before { content: "Unit cost"; }
        .iv .t-equip.rowp > :nth-child(5)::before { content: "Stock value"; }
 
        .iv .t-merch.rowp > :nth-child(n+3):nth-child(-n+6)::before,
        .iv .t-equip.rowp > :nth-child(n+3):nth-child(-n+5)::before { display: block; font-size: 12px; color: var(--muted); }
        .iv .t-merch.rowp .adj, .iv .t-equip.rowp .adj { width: 100%; height: 44px; font-size: 15px; }
 
        /* Log */
        .iv .t-log.rowp { grid-template-columns: auto 1fr auto; grid-template-areas: "type item dots" "chg chg chg" "note note note" "by by date"; align-items: start; }
        .iv .t-log.rowp > :nth-child(1) { grid-area: type; }
        .iv .t-log.rowp > :nth-child(2) { grid-area: item; }
        .iv .t-log.rowp > :nth-child(3) { grid-area: chg; font-size: 17px; }
        .iv .t-log.rowp > :nth-child(4) { grid-area: note; }
        .iv .t-log.rowp > :nth-child(5) { grid-area: by; }
        .iv .t-log.rowp > :nth-child(6) { grid-area: date; text-align: right; font-size: 13px; color: var(--muted); }
        .iv .t-log.rowp > :nth-child(7) { grid-area: dots; }
        .iv .t-log.rowp > :nth-child(4)::before { content: "Note: "; color: var(--muted); }
 
        .iv .tools { width: 100%; }
        .iv .search { flex: 1 1 100%; width: 100%; }
        .iv .search input, .iv .filter { height: 46px; }
        .iv .filter { flex: 1 1 100%; width: 100%; }
        .iv .search input, .iv .filter select { font-size: 16px; }
    }
 
    @media (max-width: 480px) {
        .iv { padding: 84px 14px 36px; }
        .iv .top h1 { font-size: 31px; }
        .iv .top .sub { font-size: 18px; }
        .iv .cards { grid-template-columns: 1fr; }
    }
 
    @media (max-width: 360px) {
        .iv { padding-left: 12px; padding-right: 12px; }
        .iv .top h1 { font-size: 28px; }
        .iv .top .sub { font-size: 17px; }
    }
 
    @media (prefers-reduced-motion: reduce) {
        .iv *, .iv *::before { transition: none !important; }
    }
</style>
 
<div class="iv">
 
    <div class="top">
        <h1>Inventory</h1>
        <div class="sub">Collateral stock levels and reorder points</div>
    </div>
 
    @if($attention > 0)
        <a href="{{ $attentionUrl }}" class="alert">
            <i class="bi bi-exclamation-triangle lead"></i>{{ $attention }} item{{ $attention > 1 ? 's' : '' }} needs attention
            <i class="bi bi-arrow-right go"></i>
        </a>
    @endif
 
    {{-- Stock on hand --}}
    <div class="stock">
        <div class="stock-head">
            <h2>Stock on hand</h2>
            <a href="{{ $addUrl }}" class="btn-add"><i class="bi bi-plus-lg"></i>Add item</a>
        </div>
        <div class="cards">
            <div class="sc"><div class="ic"><i class="bi bi-file-earmark-text"></i></div><div><small>Items</small><b>{{ $stats['items'] }}</b></div></div>
            <div class="sc"><div class="ic"><i class="bi bi-box-seam"></i></div><div><small>Units</small><b>{{ $stats['units'] }}</b></div></div>
            <div class="sc"><div class="ic"><i class="bi bi-coin"></i></div><div><small>Valuation</small><b>{{ $rp($stats['valuation']) }}</b></div></div>
            <div class="sc"><div class="ic"><i class="bi bi-exclamation-triangle"></i></div><div><small>Low stock</small><b>{{ $stats['low'] }}</b></div></div>
        </div>
    </div>
 
    {{-- Merchandise --}}
    <div class="section">
        <h2 class="sec-title">Merchandise</h2>
        <div class="tbl-wrap"><div class="tbl">
            <div class="tr t-merch th">
                <div class="first">Item</div><div>Category</div><div>On hand</div><div>Minimum</div><div>Unit cost</div><div>Valuation</div><div class="c">Status</div><div class="c">Adjust</div>
            </div>
            @foreach($merch as $m)
                <div class="tr t-merch rowp">
                    <div class="first">{{ $m['name'] }}</div>
                    <div>{{ $m['category'] }}</div>
                    <div>{{ $m['on_hand'] }}</div>
                    <div>{{ $m['minimum'] }}</div>
                    <div>{{ $rp($m['unit_cost']) }}</div>
                    <div>{{ $rp($m['on_hand'] * $m['unit_cost']) }}</div>
                    <div class="c"><span class="badge {{ $m['status'] }}">{{ $m['status'] === 'low' ? 'Low stock' : 'Normal' }}</span></div>
                    <div class="c"><a href="{{ $m['adjust_url'] ?? '#' }}" class="adj"><i class="bi bi-pencil-square"></i>Adjust</a></div>
                </div>
            @endforeach
        </div></div>
    </div>
 
    {{-- Equipment --}}
    <div class="section">
        <h2 class="sec-title">Equipment</h2>
        <div class="tbl-wrap"><div class="tbl">
            <div class="tr t-equip th">
                <div class="first">Item</div><div>Category</div><div>On hand</div><div>Unit cost</div><div>Stock value</div><div class="c">Adjust</div>
            </div>
            @foreach($equipment as $e)
                <div class="tr t-equip rowp">
                    <div class="first">{{ $e['name'] }}</div>
                    <div>{{ $e['category'] }}</div>
                    <div>{{ $e['on_hand'] }}</div>
                    <div>{{ $rp($e['unit_cost']) }}</div>
                    <div>{{ $rp($e['stock_value']) }}</div>
                    <div class="c"><a href="{{ $e['adjust_url'] ?? '#' }}" class="adj"><i class="bi bi-pencil-square"></i>Adjust</a></div>
                </div>
            @endforeach
        </div></div>
    </div>
 
    {{-- Log --}}
    <div class="section" style="margin-bottom:0">
        <div class="log-head">
            <h2 class="sec-title">Log</h2>
            <div class="tools">
                <div class="search"><i class="bi bi-search"></i><input type="text" id="logSearch" placeholder="Search"></div>
                <div class="filter">
                    <i class="bi bi-filter-left l"></i>
                    <select id="logFilter">
                        <option value="">Filter</option>
                        <option value="in">IN</option>
                        <option value="out">OUT</option>
                    </select>
                    <i class="bi bi-chevron-down r"></i>
                </div>
            </div>
        </div>
 
        <div class="tbl-wrap"><div class="tbl">
            <div class="tr t-log th">
                <div>Type</div><div>Item</div><div>Stock Change</div><div>Note</div><div>By</div><div>Date</div><div></div>
            </div>
            @foreach($logs as $l)
                <div class="tr t-log rowp log-row" data-type="{{ $l['type'] }}">
                    <div class="type">
                        @if($l['type'] === 'in')
                            <span class="in"><i class="bi bi-arrow-up"></i>IN</span>
                        @else
                            <span class="out"><i class="bi bi-arrow-down"></i>OUT</span>
                        @endif
                    </div>
                    <div class="item"><b>{{ $l['item'] }}</b>Type: {{ $l['item_type'] }}</div>
                    <div class="chg {{ $l['delta'] > 0 ? 'pos' : '' }}">{{ $l['delta'] > 0 ? '+' : '' }}{{ $l['delta'] }}<i class="bi bi-arrow-right"></i>{{ $l['balance'] }}</div>
                    <div>{{ $l['note'] }}</div>
                    <div class="by"><span>{{ $l['by'] }}</span><span>{{ $l['by_at'] }}</span></div>
                    <div>{{ $l['date'] }}<br>{{ $l['time'] }}</div>
                    <div class="dots"><i class="bi bi-three-dots-vertical"></i></div>
                </div>
            @endforeach
            <div class="nores" id="logNone">No log entries match.</div>
        </div></div>
    </div>
 
</div>
 
<script>
(() => {
    const q = document.getElementById('logSearch'), f = document.getElementById('logFilter'),
          rows = document.querySelectorAll('.iv .log-row'), none = document.getElementById('logNone');
    const apply = () => {
        const term = q.value.trim().toLowerCase(), type = f.value;
        let shown = 0;
        rows.forEach(r => {
            const ok = (!type || r.dataset.type === type) && (!term || r.textContent.toLowerCase().includes(term));
            r.style.display = ok ? '' : 'none';
            if (ok) shown++;
        });
        none.style.display = shown ? 'none' : 'block';
    };
    q.addEventListener('input', apply);
    f.addEventListener('change', apply);
})();
</script>
@endsection
 