{{-- resources/views/dashboard/overview.blade.php --}}
@extends('layouts.app')
 
@php
    // ====== DATA ======
    $marketing = $marketing ?? ['total' => 17, 'not_scored' => 11, 'under_90' => 1, 'on_target' => 5];
    $calendar  = $calendar  ?? ['pipeline' => 13, 'review' => 0, 'approved' => 0, 'published' => 1];
    $project   = $project   ?? ['open' => 21, 'past_deadline' => 1, 'blocked' => 0, 'done' => 34];
    $team      = $team      ?? ['total' => 15, 'people' => 12, 'people_max' => 12, 'below80' => 2, 'awaiting' => 2];
    $inventory = $inventory ?? ['products' => 4, 'units' => 99, 'value' => 1500000, 'reorder' => 1];
 
    $items = $items ?? [
        ['name' => 'Tumler', 'status' => 'low', 'label' => 'Low stock · 2 short', 'meta' => 'Smatt 123 · Gudang Manager · Rp 1.500.000', 'qty' => 1, 'max' => 5],
        ['name' => 'Botol java', 'status' => 'normal', 'label' => 'Normal', 'meta' => 'SKU123 · Gudang Manager', 'qty' => 4, 'max' => 5],
        ['name' => 'lampuu', 'status' => 'normal', 'label' => 'Normal', 'meta' => 'lampu 123 · Gudang Manager', 'qty' => 4, 'max' => 5],
    ];
 
    $promotors = $promotors ?? [
        'sprint' => 'Week 3',
        'range' => '7 - 14 September',
        'active' => 11,
        'names' => 'Alfian, Putri, Louie, +8'
    ];
 
    // Social Media (Target vs Actual)
    $socialLabels = ['Jun','','Jul','','Aug','','Sep','','Oct','','Nov','Des'];
 
    $social = $social ?? [
        'impressions' => [
            'target' => [1460,1770,2220,2480,2600,2220,2830,2710,2470,2830,1770,230],
            'actual' => [1900,1970,2790,3520,3110,3560,3870,3110,2070,2290,3650,230],
        ],
        'reach' => [
            'target' => [900,1100,1500,1700,1800,1500,2000,1900,1700,2000,1200,150],
            'actual' => [1200,1300,1900,2400,2100,2500,2700,2200,1400,1600,2500,150]
        ],
        'engagement' => [
            'target' => [300,400,600,700,800,600,900,800,700,900,500,60],
            'actual' => [420,450,800,1000,900,1100,1200,900,600,700,1100,60]
        ],
        'posts' => [
            'target' => [10,12,14,15,16,14,18,17,15,18,12,3],
            'actual' => [12,13,17,20,18,21,22,18,13,14,21,3]
        ],
    ];
 
    // Promotors
    $promoNames = ['Alfian','Putri','Louie','Justin','Alvin','Gusti'];
    $promoIg = [70,85,58,74,80,96];
    $promoTt = [90,108,102,65,80,112];
 
    $pct = fn ($v, $max) => $max > 0 ? round($v / $max * 100) : 0;
@endphp
 
@section('content')
 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
 
<style>
    /* =========================================
       TOKENS & BASE
    ========================================= */
    .ov, .ov * { box-sizing: border-box; }
 
    .ov {
        --bg: #101012;
        --card: #1a1a1d;
        --inner: #222226;
        --line: #2e2e33;
        --line-strong: #3d3d44;
        --text: #f4f4f5;
        --muted: #a1a1aa;
        --red: #c8262b;
        --red-deep: #a51f23;
        --green: #22c985;
        --yellow: #f5b72b;
        --orange: #ff9f0a;
        --blue: #3b82f6;
        --radius-lg: 16px;
        --radius-md: 12px;
        --radius-sm: 8px;
        --ease: cubic-bezier(.2,.7,.2,1);
 
        width: 100%;
        max-width: 1440px;
        margin: 0 auto;
        padding: 24px 0 56px;
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 14px;
        line-height: 1.5;
        color: var(--text);
        background: var(--bg);
        min-height: 100vh;
        overflow-x: hidden;
        -webkit-font-smoothing: antialiased;
    }
 
    /* Latar belakang hitam penuh selebar & setinggi area konten
       (sebelumnya hanya kotak .ov, sisi kiri/kanan masih warna layout) */
    .main-content:has(.ov),
    .dashboard-main:has(> .ov) { background: #101012 !important; }
 
    .ov h1, .ov h4, .ov p, .ov b { margin: 0; font-family: inherit; }
    .ov a { text-decoration: none; color: inherit; }
    .ov button, .ov select { font-family: inherit; }
    .ov a:focus-visible, .ov button:focus-visible, .ov select:focus-visible {
        outline: 2px solid #fff; outline-offset: 2px;
    }
 
    /* =========================================
       HEADING
    ========================================= */
    .ov h1 {
        font-size: 22.3px;
        font-weight: 600;
        line-height: 1.2;
        margin-bottom: 8px;
    }
    .ov .sub {
        color: var(--muted);
        font-size: 14.6px;
        font-weight: 500;
        line-height: 1.5;
        margin-bottom: 20px;
    }
 
    /* =========================================
       LAYOUT
    ========================================= */
    .ov-grid, .ov-main {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
        width: 100%;
    }
    .ov-main { margin-top: 20px; align-items: stretch; }
 
    .ov-left { grid-column: span 2; display: flex; flex-direction: column; gap: 20px; min-width: 0; }
    .ov-pair { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 20px; flex: 1; min-width: 0; }
    .ov-right { display: flex; flex-direction: column; gap: 20px; min-width: 0; }
    .ov-right .sys-card { flex: 1; }
    .ov-card.colf { display: flex; flex-direction: column; }
 
    /* =========================================
       CARD
    ========================================= */
    .ov-card {
        position: relative;
        min-width: 0;
        padding: 22px;
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
        box-shadow: 0 1px 0 rgba(255,255,255,.03) inset, 0 8px 24px rgba(0,0,0,.25);
        transition: border-color .2s var(--ease);
    }
    .ov-card:hover { border-color: var(--line-strong); }
 
    .ov-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 18px;
        min-width: 0;
    }
    .ov-head-left {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
        flex: 1;
    }
    .ov-head-left > div:not(.ov-ico) { min-width: 0; }
 
    .ov-head-right {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }
 
    .ov-ico {
        width: 44px; height: 44px;
        display: grid; place-items: center;
        flex: none;
        font-size: 20px;
        color: #fff;
        background: linear-gradient(145deg, var(--red) 0%, var(--red-deep) 100%);
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(165,31,35,.35);
    }
 
    .ov-title { font-size: 17px; font-weight: 600; line-height: 1.25; letter-spacing: -.01em; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
 
    .badge-s {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 6px;
        padding: 2px 10px 2px 8px;
        font-size: 12px;
        font-weight: 500;
        line-height: 1.5;
        border-radius: 999px;
        border: 1px solid;
    }
    .badge-s::before {
        content: "";
        width: 6px; height: 6px;
        border-radius: 50%;
        background: currentColor;
    }
    .badge-s.warn { color: #ffb84d; border-color: rgba(255,159,10,.35); background: rgba(255,159,10,.1); }
    .badge-s.ok   { color: #5eeaa8; border-color: rgba(34,201,133,.35); background: rgba(34,201,133,.1); }
 
    .ov-go {
        width: 38px; height: 38px;
        display: grid; place-items: center;
        flex: none;
        font-size: 16px;
        color: #fff;
        background: var(--inner);
        border: 1px solid var(--line-strong);
        border-radius: 50%;
        transition: background .2s var(--ease), transform .2s var(--ease), border-color .2s var(--ease);
    }
    .ov-go:hover { background: var(--red-deep); border-color: var(--red-deep); transform: translateX(2px); }
 
    /* =========================================
       STAT TILES
    ========================================= */
    .stat-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
 
    .stat {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
        padding: 14px;
        background: var(--inner);
        border: 1px solid var(--line);
        border-radius: var(--radius-md);
    }
    .stat .ov-ico {
        width: 38px; height: 38px;
        font-size: 17px;
        border-radius: 10px;
        background: rgba(255,255,255,.07);
        box-shadow: none;
        color: #fff;
    }
    .stat small { display: block; font-size: 13px; color: var(--muted); }
    .stat b { font-size: 24px; font-weight: 700; letter-spacing: -.02em; line-height: 1.2; }
 
    .box {
        min-width: 0;
        padding: 14px 16px;
        background: var(--inner);
        border: 1px solid var(--line);
        border-radius: var(--radius-md);
    }
    .box small { display: block; font-size: 13px; color: var(--muted); }
    .box b { font-size: 19px; font-weight: 700; letter-spacing: -.01em; }
 
    .box.alert { position: relative; border-color: rgba(224,56,61,.55); background: rgba(224,56,61,.08); }
    .box.alert b { color: #ff5a5f; }
    .box.alert b span { color: var(--text); font-size: 13px; font-weight: 500; }
    .box.alert .dot {
        position: absolute; top: 12px; right: 12px;
        width: 8px; height: 8px;
        border-radius: 50%;
        background: #ff5a5f;
        box-shadow: 0 0 0 0 rgba(255,90,95,.6);
        animation: ov-pulse 2s infinite;
    }
    @keyframes ov-pulse {
        70% { box-shadow: 0 0 0 8px rgba(255,90,95,0); }
        100% { box-shadow: 0 0 0 0 rgba(255,90,95,0); }
    }
 
    /* =========================================
       MARKETING PERFORMANCE (DONUT)
    ========================================= */
    .mk { display: flex; align-items: center; justify-content: center; gap: 28px; min-width: 0; padding: 4px 0; }
 
    .donut { position: relative; width: 170px; height: 170px; flex: none; }
    .donut .mid, .gauge .mid {
        position: absolute; inset: 0;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        pointer-events: none;
    }
    .donut .mid b { font-size: 34px; font-weight: 700; line-height: 1; letter-spacing: -.02em; }
    .donut .mid span { font-size: 13px; color: var(--muted); margin-top: 2px; }
 
    .legend { display: grid; grid-template-columns: 1fr auto; column-gap: 20px; align-items: center; }
    .legend div { display: flex; align-items: center; gap: 8px; font-size: 14px; color: var(--muted); padding: 7px 0; }
    .legend i { width: 10px; height: 10px; border-radius: 50%; display: inline-block; flex: none; }
    .legend p { text-align: right; font-size: 17px; font-weight: 600; padding: 7px 0; }
 
    /* =========================================
       SOCIAL MEDIA (BAR CHART & SCROLL)
    ========================================= */
    .sel {
        height: 38px;
        width: 140px;
        padding: 0 12px;
        font-size: 14px;
        color: var(--text);
        background: var(--inner);
        border: 1px solid var(--line-strong);
        border-radius: 10px;
        cursor: pointer;
    }
    .sel:hover { border-color: #55555d; }
 
    .chart-legend {
        display: flex; justify-content: center; flex-wrap: wrap;
        gap: 18px;
        margin: 2px 0 10px;
        font-size: 13px;
        color: var(--muted);
    }
    .chart-legend i { display: inline-block; width: 10px; height: 10px; border-radius: 3px; margin-right: 6px; }
 
    .ov-chart-scroll {
        width: 100%;
        overflow-x: auto;
        scrollbar-width: thin;
        scrollbar-color: var(--line-strong) transparent;
        padding-bottom: 4px;
    }
    .ov-chart-scroll::-webkit-scrollbar {
        height: 5px;
    }
    .ov-chart-scroll::-webkit-scrollbar-thumb {
        background: var(--line-strong);
        border-radius: 9999px;
    }
    .ov-chart-inner {
        min-width: 100%;
    }
    @media (max-width: 768px) {
        .ov-chart-inner {
            min-width: 580px;
        }
    }
 
    .social-cv { position: relative; width: 100%; height: 230px; }
    .social-cv canvas, .donut canvas, .gauge canvas { display: block; }
 
    .tabs {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 6px;
        margin-top: 14px;
        padding: 5px;
        background: var(--inner);
        border: 1px solid var(--line);
        border-radius: var(--radius-md);
    }
    .tabs button {
        padding: 9px 8px;
        font-size: 14px;
        font-weight: 500;
        color: var(--muted);
        background: transparent;
        border: 0;
        border-radius: 8px;
        cursor: pointer;
        transition: background .2s var(--ease), color .2s var(--ease);
    }
    .tabs button:hover { color: var(--text); background: rgba(255,255,255,.05); }
    .tabs button.on { color: #fff; background: var(--red-deep); box-shadow: 0 2px 8px rgba(165,31,35,.45); }
 
    /* =========================================
       TEAM SCORECARDS (GAUGE)
    ========================================= */
    .team {
        overflow: hidden;
        background: linear-gradient(180deg, #4a2f33 0%, #2a1c1f 100%);
        border-color: rgba(255,255,255,.1);
    }
    .team::before {
        content: "";
        position: absolute; inset: 0 0 55% 0;
        background-image: radial-gradient(rgba(255,255,255,.12) 1.2px, transparent 1.4px);
        background-size: 10px 10px;
        -webkit-mask-image: linear-gradient(135deg, #000, transparent 60%);
        mask-image: linear-gradient(135deg, #000, transparent 60%);
        pointer-events: none;
    }
    .team > * { position: relative; }
    .team .ov-go { background: #fff; color: #111; border: 0; }
    .team .ov-go:hover { background: #ffe3e4; }
 
    .gauge { position: relative; height: 210px; max-width: 320px; width: 100%; margin: 4px auto 0; }
    .gauge .mid { justify-content: flex-end; padding-bottom: 26px; }
    .gauge .mid span { font-size: 15px; color: rgba(255,255,255,.7); }
    .gauge .mid b { font-size: 56px; font-weight: 700; line-height: 1; letter-spacing: -.03em; }
 
    .team hr { border: 0; border-top: 1px solid rgba(255,255,255,.18); margin: 28px 0 22px; }
    .team h4 { font-size: 16px; font-weight: 600; margin: 0 0 16px; }
 
    .prog { margin-bottom: 18px; }
    .prog:last-child { margin-bottom: 0; }
    .prog .row { display: flex; justify-content: space-between; gap: 10px; font-size: 14px; margin-bottom: 8px; color: rgba(255,255,255,.85); }
    .prog .bar { display: flex; align-items: center; gap: 12px; }
    .prog .track { flex: 1; height: 8px; background: rgba(255,255,255,.16); border-radius: 6px; overflow: hidden; }
    .prog .track i { display: block; height: 100%; background: #fff; border-radius: 6px; }
    .prog .track i.r { background: #ff4b4b; }
    .prog .track i.o { background: var(--orange); }
 
    .pill { min-width: 54px; padding: 2px 10px; font-size: 12px; font-weight: 600; text-align: center; border-radius: 999px; }
    .pill.w { background: rgba(255,255,255,.25); color: #fff; }
    .pill.r { background: #e11d1d; color: #fff; }
    .pill.o { background: #f5a300; color: #222; }
 
    /* =========================================
       INVENTORY
    ========================================= */
    .inv-top { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
 
    .inv-h { display: flex; justify-content: space-between; align-items: baseline; gap: 10px; margin: 22px 0 12px; font-size: 15px; font-weight: 600; }
    .inv-h small { font-size: 12px; font-weight: 500; color: #ff8b8e; }
 
    .item {
        display: flex; justify-content: space-between; align-items: center;
        gap: 12px;
        padding: 12px 14px;
        margin-bottom: 10px;
        background: var(--inner);
        border: 1px solid var(--line);
        border-radius: var(--radius-md);
        transition: border-color .2s var(--ease);
    }
    .item:last-child { margin-bottom: 0; }
    .item:hover { border-color: var(--line-strong); }
    .item b { font-size: 15px; font-weight: 600; }
    .item small { display: block; margin-top: 4px; font-size: 12px; color: var(--muted); }
 
    .tag { margin-left: 6px; padding: 1px 8px; font-size: 11px; font-weight: 500; vertical-align: middle; border-radius: 999px; color: #fff; }
    .tag.low { background: #b91c1c; }
    .tag.normal { background: #178a58; }
 
    .qty { flex: none; font-size: 18px; font-weight: 700; }
    .qty span { font-size: 14px; font-weight: 400; color: var(--muted); }
 
    /* =========================================
       PROMOTORS (BAR CHART)
    ========================================= */
    .pm-top { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; margin-bottom: 16px; }
 
    .pm-box { min-width: 0; padding: 14px 16px; background: var(--inner); border: 1px solid var(--line); border-radius: var(--radius-md); }
    .pm-box .k { display: flex; justify-content: space-between; align-items: center; gap: 10px; font-size: 12px; font-weight: 500; letter-spacing: .02em; color: var(--muted); }
    .pm-box b { display: block; margin: 6px 0 2px; font-size: 18px; font-weight: 700; letter-spacing: -.01em; }
    .pm-box small { font-size: 12px; color: var(--muted); }
 
    .pm-chart { flex: 1; display: flex; flex-direction: column; min-width: 0; padding: 16px; background: var(--inner); border: 1px solid var(--line); border-radius: var(--radius-md); }
    .pm-chart .k { font-size: 12px; font-weight: 500; letter-spacing: .02em; color: var(--muted); }
    .pm-chart .chart-legend { justify-content: flex-end; margin: 10px 0 0; }
    .pm-chart .cv { position: relative; flex: 1; min-height: 190px; margin-top: 10px; }
    .pm-chart .cv canvas { position: absolute; inset: 0; }
 
    /* =========================================
       SYSTEM
    ========================================= */
    .sys-item {
        display: flex; align-items: center; gap: 14px;
        padding: 12px 14px;
        margin-bottom: 12px;
        background: var(--inner);
        border: 1px solid var(--line);
        border-radius: var(--radius-md);
        transition: background .2s var(--ease), border-color .2s var(--ease), transform .2s var(--ease);
    }
    .sys-item:last-child { margin-bottom: 0; }
    .sys-item:hover { background: #2b2b30; border-color: var(--line-strong); transform: translateY(-1px); }
    .sys-item > .bi { color: var(--muted); transition: transform .2s var(--ease), color .2s var(--ease); }
    .sys-item:hover > .bi { color: #fff; transform: translateX(3px); }
    .sys-item .txt { flex: 1; min-width: 0; font-size: 15px; font-weight: 600; }
    .sys-item small { display: block; font-size: 12px; font-weight: 400; color: var(--muted); }
 
    /* =========================================
       TABLET
    ========================================= */
    @media (max-width: 1100px) {
        .ov h1 { font-size: 20.8px; }
        .ov .sub { font-size: 13.1px; }
        .ov-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .ov-main { grid-template-columns: 1fr; }
        .ov-left { grid-column: auto; }
        .ov-right { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
 
    /* =========================================
       MOBILE
    ========================================= */
    @media (max-width: 768px) {
        .ov { padding: 84px 16px 40px; font-size: 19px; }
        .ov h1 { font-size: 33px; }
        .ov .sub { font-size: 19px; line-height: 1.55; margin-bottom: 22px; }
 
        .ov-grid, .ov-main, .ov-pair { grid-template-columns: 1fr; gap: 14px; }
        .ov-left, .ov-right { display: flex; flex-direction: column; grid-column: auto; gap: 14px; width: 100%; min-width: 0; }
        .ov-main { margin-top: 14px; }
        .ov-card { width: 100%; padding: 18px; }
 
        .ov-head { flex-wrap: wrap; gap: 12px; margin-bottom: 16px; }
        .ov-head-left { flex: 1 1 0; }
        .ov-head-right { display: contents; }
        .ov-go { order: 2; margin-left: auto; }
        .ov-ico { width: 46px; height: 46px; font-size: 23px; }
        .ov-title { font-size: 21px; white-space: normal; }
        .badge-s { font-size: 14px; }
        .sel { order: 3; flex: 1 1 100%; width: 100%; height: 44px; font-size: 16px; }
 
        .stat-grid { margin-top: 0 !important; gap: 10px; }
        .stat .ov-ico { width: 38px; height: 38px; font-size: 19px; }
        .stat small { font-size: 15px; }
        .stat b { font-size: 24px; }
 
        .box { padding: 12px; }
        .box small { font-size: 15px; }
        .box b { font-size: 21px; }
        .box.alert b span { font-size: 14px; }
 
        .mk { flex-direction: column; align-items: center; gap: 18px; }
        .donut { width: 170px; height: 170px; }
        .legend { width: 100%; max-width: 300px; column-gap: 28px; }
        .legend div { font-size: 16px; white-space: nowrap; }
        .legend p { font-size: 18px; }
 
        .chart-legend { font-size: 15px; gap: 14px; }
        .social-cv { height: 240px; }
        .tabs { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .tabs button { padding: 12px 6px; font-size: 16px; }
 
        .inv-h { font-size: 18px; }
        .inv-h small { font-size: 14px; }
        .item { align-items: flex-start; }
        .item b { font-size: 17px; }
        .item small { font-size: 14px; }
        .tag { font-size: 12px; }
        .qty { font-size: 20px; }
 
        .pm-box { padding: 12px; }
        .pm-box .k { font-size: 13px; }
        .pm-box b { font-size: 21px; }
        .pm-box small { font-size: 13px; }
        .pm-chart { flex: none; padding: 14px; }
        .pm-chart .k { font-size: 14px; }
        .pm-chart .cv { flex: none; width: 100%; height: 260px; min-height: 0; margin-top: 8px; }
        .pm-chart .chart-legend { justify-content: center; }
 
        .gauge { height: 200px; max-width: 300px; }
        .gauge .mid { padding-bottom: 18px; }
        .gauge .mid span { font-size: 22px; }
        .gauge .mid b { font-size: 56px; }
        .team hr { margin: 22px 0 22px; }
        .team h4 { font-size: 20px; }
        .prog .row { font-size: 16px; }
        .pill { font-size: 13px; }
 
        .sys-item .txt { font-size: 18px; }
        .sys-item small { font-size: 14px; }
    }
 
    @media (max-width: 480px) {
        .ov { padding: 84px 14px 36px; }
        .ov h1 { font-size: 31px; }
        .ov .sub { font-size: 18px; }
        .ov-card { padding: 16px; }
        .ov-ico { width: 42px; height: 42px; font-size: 20px; }
        .donut { width: 150px; height: 150px; }
        .legend { max-width: 260px; }
        .legend div { font-size: 15px; }
        .stat { gap: 8px; padding: 10px; }
        .stat .ov-ico { width: 34px; height: 34px; font-size: 16px; }
        .stat small { font-size: 14px; }
        .stat b { font-size: 22px; }
        .inv-h { flex-direction: column; gap: 4px; }
        .pm-top { grid-template-columns: 1fr; }
        .gauge { height: 190px; }
        .gauge .mid b { font-size: 50px; }
        .prog .row { font-size: 15px; }
        .pill { min-width: 48px; font-size: 12px; }
    }
 
    @media (max-width: 360px) {
        .ov { padding-left: 12px; padding-right: 12px; }
        .ov h1 { font-size: 28px; }
        .ov .sub { font-size: 17px; }
        .ov-card { padding: 14px; }
        .ov-title { font-size: 19px; }
        .stat-grid { gap: 8px; }
        .stat { flex-direction: column; align-items: flex-start; }
        .sel { font-size: 13px; }
    }
 
    @media (prefers-reduced-motion: reduce) {
        .ov *, .ov *::before { animation: none !important; transition: none !important; }
    }
</style>
 
<div class="ov">
 
    <h1>Overview</h1>
    <div class="sub">What needs you right now, across your KPIs, content and project</div>
 
    <div class="ov-grid">
 
        {{-- ========== MARKETING PERFORMANCE ========== --}}
        <section class="ov-card">
            <div class="ov-head">
                <div class="ov-head-left">
                    <div class="ov-ico"><i class="bi bi-bar-chart-fill"></i></div>
                    <div>
                        <div class="ov-title">Marketing Performance</div>
                        <span class="badge-s warn">Need Attention</span>
                    </div>
                </div>
                <div class="ov-head-right">
                    <a href="{{ url('/marketing-performance') }}" class="ov-go" aria-label="Open Marketing Performance">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
 
            <div class="mk">
                <div class="donut">
                    <canvas id="marketingDonut"></canvas>
                    <div class="mid">
                        <b>{{ $marketing['total'] }}</b>
                        <span>Total</span>
                    </div>
                </div>
 
                <div class="legend">
                    <div><i style="background:#fff"></i>Not Scored</div>
                    <p>{{ $marketing['not_scored'] }}</p>
 
                    <div><i style="background:var(--yellow)"></i>Under 90%</div>
                    <p>{{ $marketing['under_90'] }}</p>
 
                    <div><i style="background:var(--green)"></i>On Target</div>
                    <p>{{ $marketing['on_target'] }}</p>
                </div>
            </div>
        </section>
 
        {{-- ========== CONTENT CALENDAR ========== --}}
        <section class="ov-card">
            <div class="ov-head">
                <div class="ov-head-left">
                    <div class="ov-ico"><i class="bi bi-bar-chart-fill"></i></div>
                    <div>
                        <div class="ov-title">Content Calendar</div>
                        <span class="badge-s ok">On Track</span>
                    </div>
                </div>
                <div class="ov-head-right">
                    <a href="{{ url('/content-calendar') }}" class="ov-go" aria-label="Open Content Calendar">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
 
            <div class="stat-grid" style="margin-top:34px">
                <div class="stat">
                    <div class="ov-ico"><i class="bi bi-layers"></i></div>
                    <div><small>In the Pipeline</small><b>{{ $calendar['pipeline'] }}</b></div>
                </div>
 
                <div class="stat">
                    <div class="ov-ico"><i class="bi bi-eye"></i></div>
                    <div><small>In Review</small><b>{{ $calendar['review'] }}</b></div>
                </div>
 
                <div class="stat">
                    <div class="ov-ico"><i class="bi bi-check-circle"></i></div>
                    <div><small>Approved</small><b>{{ $calendar['approved'] }}</b></div>
                </div>
 
                <div class="stat">
                    <div class="ov-ico"><i class="bi bi-calendar-event"></i></div>
                    <div><small>Published</small><b>{{ $calendar['published'] }}</b></div>
                </div>
            </div>
        </section>
 
        {{-- ========== PROJECT ========== --}}
        <section class="ov-card">
            <div class="ov-head">
                <div class="ov-head-left">
                    <div class="ov-ico"><i class="bi bi-bar-chart-fill"></i></div>
                    <div>
                        <div class="ov-title">Project</div>
                        <span class="badge-s warn">Need Attention</span>
                    </div>
                </div>
                <div class="ov-head-right">
                    <a href="{{ url('/project') }}" class="ov-go" aria-label="Open Project">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
 
            <div class="stat-grid" style="margin-top:34px">
                <div class="stat">
                    <div class="ov-ico"><i class="bi bi-folder2-open"></i></div>
                    <div><small>Open</small><b>{{ $project['open'] }}</b></div>
                </div>
 
                <div class="stat">
                    <div class="ov-ico"><i class="bi bi-calendar2-x"></i></div>
                    <div><small>Past Deadline</small><b>{{ $project['past_deadline'] }}</b></div>
                </div>
 
                <div class="stat">
                    <div class="ov-ico"><i class="bi bi-slash-circle"></i></div>
                    <div><small>Blocked</small><b>{{ $project['blocked'] }}</b></div>
                </div>
 
                <div class="stat">
                    <div class="ov-ico"><i class="bi bi-check-circle"></i></div>
                    <div><small>Done</small><b>{{ $project['done'] }}</b></div>
                </div>
            </div>
        </section>
 
    </div>
 
    {{-- Baris bawah: kiri (Social + Inventory + Promotors) | kanan (Team Scorecards + System) --}}
    <div class="ov-main">
 
        <div class="ov-left">
 
            {{-- ========== SOCIAL MEDIA ========== --}}
            <section class="ov-card">
                <div class="ov-head">
                    <div class="ov-head-left">
                        <div class="ov-ico"><i class="bi bi-bar-chart-fill"></i></div>
                        <div>
                            <div class="ov-title">Social Media</div>
                            <span class="badge-s ok">On Track</span>
                        </div>
                    </div>
                    <div class="ov-head-right">
                        <select class="sel" id="socialPlatform" aria-label="Platform">
                            <option>Instagram</option>
                            <option>TikTok</option>
                            <option>Facebook</option>
                        </select>
                        <a href="{{ url('/social-media') }}" class="ov-go" aria-label="Open Social Media">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
 
                <div class="chart-legend">
                    <span><i style="background:#e6e6e6"></i>Target</span>
                    <span><i style="background:var(--red)"></i>Actual</span>
                </div>
 
                <div class="ov-chart-scroll">
                    <div class="ov-chart-inner">
                        <div class="social-cv">
                            <canvas id="socialBar"></canvas>
                        </div>
                    </div>
                </div>
 
                <div class="tabs" id="socialTabs">
                    <button class="on" data-k="impressions">Impressions</button>
                    <button data-k="reach">Reach</button>
                    <button data-k="engagement">Engagement</button>
                    <button data-k="posts">Posts</button>
                </div>
            </section>
 
            <div class="ov-pair">
 
                {{-- ========== INVENTORY ========== --}}
                <section class="ov-card">
                    <div class="ov-head">
                        <div class="ov-head-left">
                            <div class="ov-ico"><i class="bi bi-bar-chart-fill"></i></div>
                            <div>
                                <div class="ov-title">Inventory</div>
                                <span class="badge-s warn">Need Attention</span>
                            </div>
                        </div>
                        <div class="ov-head-right">
                            <a href="{{ url('/inventory') }}" class="ov-go" aria-label="Open Inventory">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
 
                    <div class="inv-top">
                        <div class="box">
                            <small>Products</small>
                            <b>{{ $inventory['products'] }}</b>
                        </div>
 
                        <div class="box">
                            <small>Units on hand</small>
                            <b>{{ $inventory['units'] }}</b>
                        </div>
 
                        <div class="box">
                            <small>Stock value</small>
                            <b>Rp {{ number_format($inventory['value'], 0, ',', '.') }}</b>
                        </div>
 
                        <div class="box alert">
                            <span class="dot"></span>
                            <small>To reorder</small>
                            <b>{{ $inventory['reorder'] }} <span>SKU</span></b>
                        </div>
                    </div>
 
                    <div class="inv-h">
                        <span>Merchandise Inventory</span>
                        <small>{{ $inventory['reorder'] }} Needs Reorder</small>
                    </div>
 
                    @foreach($items as $it)
                        <div class="item">
                            <div>
                                <b>{{ $it['name'] }}</b>
                                <span class="tag {{ $it['status'] }}">{{ $it['label'] }}</span>
                                <small>{{ $it['meta'] }}</small>
                            </div>
 
                            <div class="qty">
                                {{ $it['qty'] }}
                                <span>/ {{ $it['max'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </section>
 
                {{-- ========== PROMOTORS ========== --}}
                <section class="ov-card colf">
                    <div class="ov-head">
                        <div class="ov-head-left">
                            <div class="ov-ico"><i class="bi bi-bar-chart-fill"></i></div>
                            <div>
                                <div class="ov-title">Promotors</div>
                                <span class="badge-s ok">On Track</span>
                            </div>
                        </div>
                        <div class="ov-head-right">
                            <a href="{{ url('/promotors') }}" class="ov-go" aria-label="Open Promotors">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
 
                    <div class="pm-top">
                        <div class="pm-box">
                            <div class="k">
                                ACTIVE SPRINT
                                <i style="width:8px;height:8px;border-radius:50%;background:var(--green);display:inline-block"></i>
                            </div>
                            <b>{{ $promotors['sprint'] }}</b>
                            <small>{{ $promotors['range'] }}</small>
                        </div>
 
                        <div class="pm-box">
                            <div class="k">
                                <span>ACTIVE PROMOTERS</span>
                                <span>{{ $promotors['active'] }}</span>
                            </div>
                            <b>{{ $promotors['active'] }} Members</b>
                            <small>{{ $promotors['names'] }}</small>
                        </div>
                    </div>
 
                    <div class="pm-chart">
                        <div class="k">ACCOUNT SUBMISSIONS &amp; VERIFICATION</div>
 
                        <div class="chart-legend">
                            <span><i style="background:var(--blue)"></i>Instagram</span>
                            <span><i style="background:var(--green)"></i>TikTok</span>
                        </div>
 
                        <div class="cv">
                            <canvas id="promoBar"></canvas>
                        </div>
                    </div>
                </section>
 
            </div>
        </div>
 
        <div class="ov-right">
 
            {{-- ========== TEAM SCORECARDS ========== --}}
            <section class="ov-card team">
                <div class="ov-head">
                    <div class="ov-head-left">
                        <div class="ov-ico"><i class="bi bi-people"></i></div>
                        <div>
                            <div class="ov-title">Team Scorecards</div>
                            <span class="badge-s warn">Need Attention</span>
                        </div>
                    </div>
                    <div class="ov-head-right">
                        <a href="{{ url('/team-scorecards') }}" class="ov-go" aria-label="Open Team Scorecards">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
 
                <div class="gauge">
                    <canvas id="teamGauge"></canvas>
                    <div class="mid">
                        <span>Total</span>
                        <b>{{ $team['total'] }}</b>
                    </div>
                </div>
 
                <hr>
 
                <h4>Team Overview</h4>
 
                <div class="prog">
                    <div class="row">
                        <span>People</span>
                        <span>{{ $team['people'] }}/{{ $team['people_max'] }}</span>
                    </div>
                    <div class="bar">
                        <div class="track">
                            <i style="width:{{ $pct($team['people'],$team['people_max']) }}%"></i>
                        </div>
                        <span class="pill w">{{ $pct($team['people'],$team['people_max']) }}%</span>
                    </div>
                </div>
 
                <div class="prog">
                    <div class="row">
                        <span>Below 80%</span>
                        <span>{{ $team['below80'] }}/{{ $team['people_max'] }} People</span>
                    </div>
                    <div class="bar">
                        <div class="track">
                            <i class="r" style="width:{{ $pct($team['below80'],$team['people_max']) }}%"></i>
                        </div>
                        <span class="pill r">{{ $pct($team['below80'],$team['people_max']) }}%</span>
                    </div>
                </div>
 
                <div class="prog">
                    <div class="row">
                        <span>Awaiting Review</span>
                        <span>{{ $team['awaiting'] }}/{{ $team['people_max'] }} People</span>
                    </div>
                    <div class="bar">
                        <div class="track">
                            <i class="o" style="width:{{ $pct($team['awaiting'],$team['people_max']) }}%"></i>
                        </div>
                        <span class="pill o">{{ $pct($team['awaiting'],$team['people_max']) }}%</span>
                    </div>
                </div>
            </section>
 
            {{-- ========== SYSTEM ========== --}}
            <section class="ov-card sys-card">
                <div class="ov-head">
                    <div class="ov-head-left">
                        <div class="ov-ico"><i class="bi bi-bar-chart-fill"></i></div>
                        <div>
                            <div class="ov-title">System</div>
                            <span class="badge-s warn">Need Attention</span>
                        </div>
                    </div>
                </div>
 
                <a href="{{ url('/ai-assistant') }}" class="sys-item">
                    <div class="ov-ico"><i class="bi bi-terminal"></i></div>
                    <div class="txt">AI Assistant<small>AI Assistant</small></div>
                    <i class="bi bi-arrow-right"></i>
                </a>
 
                <a href="{{ url('/agent-office') }}" class="sys-item">
                    <div class="ov-ico"><i class="bi bi-robot"></i></div>
                    <div class="txt">Agent Office<small>AI Assistant</small></div>
                    <i class="bi bi-arrow-right"></i>
                </a>
 
                <a href="{{ url('/integrations') }}" class="sys-item">
                    <div class="ov-ico"><i class="bi bi-arrow-repeat"></i></div>
                    <div class="txt">Integrations<small>AI Assistant</small></div>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </section>
 
        </div>
    </div>
</div>
 
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
 
<script>
(() => {
    const isMobile = window.innerWidth <= 768;
 
    Chart.defaults.color = '#a1a1aa';
    Chart.defaults.font.family = "'Inter', system-ui, sans-serif";
    Chart.defaults.font.size = isMobile ? 13 : 12;
 
    /* ---------------------------------------------------------
       Ukuran ASLI (layout) sebuah elemen.
       Chart.js mengukur container dengan getBoundingClientRect,
       yang ikut mengecil bila ada skala/zoom di wrapper layout,
       sehingga canvas jadi lebih kecil dari kotaknya.
       Di sini ukuran dikoreksi memakai elemen probe 100px.
    --------------------------------------------------------- */
    const layoutSize = el => {
        const probe = document.createElement('i');
        probe.style.cssText = 'position:absolute;visibility:hidden;pointer-events:none;width:100px;height:0';
        el.appendChild(probe);
        const z = probe.getBoundingClientRect().width / 100 || 1;
        probe.remove();
 
        const r = el.getBoundingClientRect();
        return { w: Math.round(r.width / z), h: Math.round(r.height / z) };
    };
 
    /* Buat chart dengan ukuran manual, ikut berubah saat kotaknya berubah */
    const make = (id, cfg) => {
        const canvas = document.getElementById(id);
        const box = canvas.parentElement;
        const s = layoutSize(box);
 
        canvas.width = s.w;
        canvas.height = s.h;
        canvas.style.width = s.w + 'px';
        canvas.style.height = s.h + 'px';
 
        cfg.options = Object.assign({}, cfg.options, {
            responsive: false,
            maintainAspectRatio: false
        });
 
        const chart = new Chart(canvas, cfg);
 
        const fit = () => {
            const n = layoutSize(box);
            if (n.w < 1 || n.h < 1) return;
            if (n.w !== Math.round(chart.width) || n.h !== Math.round(chart.height)) {
                chart.resize(n.w, n.h);
            }
        };
 
        if ('ResizeObserver' in window) new ResizeObserver(fit).observe(box);
        window.addEventListener('load', fit);
        window.addEventListener('orientationchange', fit);
        setTimeout(fit, 250);
 
        return chart;
    };
 
    // Muat ulang saat pindah antara mobile <-> desktop
    window.addEventListener('resize', () => {
        if ((window.innerWidth <= 768) !== isMobile) location.reload();
    });
 
    // ---------- Donut Marketing Performance ----------
    make('marketingDonut', {
        type: 'doughnut',
        data: {
            datasets: [{
                data: @json([$marketing['on_target'], $marketing['under_90'], $marketing['not_scored']]),
                backgroundColor: ['#22c985', '#f5b72b', '#e8e8e8'],
                borderWidth: 0,
                borderRadius: isMobile ? 8 : 20,
                spacing: isMobile ? 3 : 4
            }]
        },
        options: {
            rotation: 20,
            cutout: isMobile ? '80%' : '74%',
            layout: { padding: 4 },
            plugins: {
                legend: { display: false }
            }
        }
    });
 
    // ---------- Gauge Team Scorecards ----------
    make('teamGauge', {
        type: 'doughnut',
        data: {
            datasets: [{
                data: @json([$team['people'] - $team['below80'] - $team['awaiting'], $team['below80'], $team['awaiting']]),
                backgroundColor: ['#f2f2f2', '#e11d1d', '#ffa500'],
                borderWidth: 0,
                borderRadius: isMobile ? 10 : 20,
                spacing: 3
            }]
        },
        options: {
            rotation: -110,
            circumference: 220,
            cutout: '84%',
            layout: { padding: 6 },
            plugins: {
                legend: { display: false },
                tooltip: { enabled: false }
            }
        }
    });
 
    // ---------- Bar Social Media ----------
    const social = @json($social);
 
    const fmt = v =>
        v === 0
            ? '0'
            : (v / 1000).toString().replace('.', ',') + (v % 1000 ? ' k' : 'k');
 
    const socialChart = make('socialBar', {
        type: 'bar',
        data: {
            labels: @json($socialLabels),
            datasets: [
                {
                    label: 'Target',
                    data: social.impressions.target,
                    backgroundColor: '#e6e6e6',
                    borderRadius: 3
                },
                {
                    label: 'Actual',
                    data: social.impressions.actual,
                    backgroundColor: '#c8262b',
                    borderRadius: 3
                }
            ]
        },
        options: {
            barPercentage: .9,
            categoryPercentage: isMobile ? .8 : .75,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { color: '#3d3d44' },
                    ticks: {
                        font: { size: isMobile ? 12 : 13 },
                        autoSkip: false,
                        maxRotation: 0
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255,255,255,.06)' },
                    border: { display: false },
                    ticks: {
                        stepSize: isMobile ? 1000 : 500,
                        font: { size: 12 },
                        callback: fmt
                    }
                }
            }
        }
    });
 
    const tabs = document.querySelectorAll('#socialTabs button');
 
    tabs.forEach(btn => btn.addEventListener('click', () => {
        tabs.forEach(b => b.classList.remove('on'));
        btn.classList.add('on');
 
        const d = social[btn.dataset.k];
 
        socialChart.data.datasets[0].data = d.target;
        socialChart.data.datasets[1].data = d.actual;
 
        socialChart.update();
    }));
 
    document.getElementById('socialPlatform').addEventListener('change', () => {});
 
    // ---------- Bar Promotors ----------
    make('promoBar', {
        type: 'bar',
        data: {
            labels: @json($promoNames),
            datasets: [
                {
                    label: 'Instagram',
                    data: @json($promoIg),
                    backgroundColor: '#3b82f6',
                    borderRadius: 3
                },
                {
                    label: 'TikTok',
                    data: @json($promoTt),
                    backgroundColor: '#22c985',
                    borderRadius: 3
                }
            ]
        },
        options: {
            barPercentage: .9,
            categoryPercentage: isMobile ? .75 : .55,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { color: '#3d3d44' },
                    ticks: {
                        font: { size: isMobile ? 13 : 12 }
                    }
                },
                y: {
                    display: false,
                    beginAtZero: true
                }
            }
        }
    });
 
})();
</script>
 
@endsection
