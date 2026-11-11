@extends('layouts.app')
 
@section('title', 'Marketing Performance | Java Global Futures')
 
@section('content')
 
@php
    // ---------- Icons (stroke, 24x24) ----------
    $icons = [
        'megaphone' => '<path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>',
        'users'     => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'list'      => '<path d="m3 17 2 2 4-4"/><path d="m3 7 2 2 4-4"/><path d="M13 6h8"/><path d="M13 12h8"/><path d="M13 18h8"/>',
        'check'     => '<circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/>',
        'file'      => '<path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><path d="M14 2v6h6"/>',
        'shield'    => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/>',
        'coins'     => '<circle cx="8" cy="8" r="6"/><path d="M18.09 10.37A6 6 0 1 1 10.34 18"/><path d="M7 6h1v4"/><path d="m16.71 13.88.7.71-2.82 2.82"/>',
        'share'     => '<circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><path d="m8.59 13.51 6.83 3.98"/><path d="m15.41 6.51-6.82 3.98"/>',
        'line'      => '<path d="M3 3v16a2 2 0 0 0 2 2h16"/><path d="m19 9-5 5-4-4-3 3"/>',
        'bars'      => '<path d="M12 20V10"/><path d="M18 20V4"/><path d="M6 20v-4"/>',
        'calc'      => '<rect width="16" height="20" x="4" y="2" rx="2"/><path d="M8 6h8"/><path d="M16 14v4"/><path d="M8 10h.01M12 10h.01M16 10h.01M8 14h.01M12 14h.01M8 18h.01M12 18h.01"/>',
        'trend'     => '<path d="m22 7-8.5 8.5-5-5L2 17"/><path d="M16 7h6v6"/>',
    ];
 
    // ---------- Data ----------
    $sections = $sections ?? [
        ['title' => 'Budget & Advertising Performance', 'scroll' => true, 'cards' => [
            ['Ad Spend','megaphone','-4.9%','Rp 464.164','Rp 1.001.001','46.4%',46,'red'],
            ['CPL','users','-75.4%','Rp 464.164','Rp 1.001.001','215.7%',95,'red'],
            ['CPR','list','+49.0%','Rp 3.893.296','Rp 2.052.052','52.7%',99,'green'],
            ['CPA','check','+49.0%','Rp 3.893.296','Rp 2.052.052','52.7%',99,'green'],
        ]],
        ['title' => 'Acquisition Performance', 'scroll' => false, 'cards' => [
            ['Leads','users','-4.9%','Rp 464.164','Rp 1.001.001','46.4%',46,'red'],
            ['Registration','file','-75.4%','Rp 464.164','Rp 1.001.001','215.7%',95,'red'],
            ['Real Account Registration','shield','+49.0%','Rp 3.893.296','Rp 2.052.052','52.7%',99,'green'],
        ]],
        ['title' => 'Conversion Performance', 'scroll' => true, 'cards' => [
            ['FTD','coins','-6.8%','Rp 464.000','Rp 1.000.000','46.4%',46,'red'],
            ['Leads to Reg. Rate','share','-12.6%','Rp 954.000','Rp 1.000.000','95.4%',95,'red'],
            ['Reg. to FTD Rate','line','+18.5%','Rp 2.985.000','Rp 3.000.000','99.5%',99,'green'],
            ['Leads to FTD Rate','bars','+24.7%','Rp 3.482.500','Rp 3.500.000','99.5%',99,'green'],
        ]],
        ['title' => 'Deposit & Revenue Performance', 'scroll' => false, 'cards' => [
            ['FTD Amount','coins','-3.2%','Rp 556.800','Rp 1.200.000','46.4%',46,'red'],
            ['Deposit per FTD','calc','-15.8%','Rp 858.600','Rp 900.000','95.4%',95,'red'],
            ['ROAS (Deposit per Ad Spend)','trend','+12.4%','Rp 2.487.500','Rp 2.500.000','99.5%',99,'green'],
        ]],
    ];
 
    $against = $against ?? [
        ['Leads',100,'g'],['Ad Spend',100,'g'],['Return on Ad Spend',99,'y'],['Revenue / Deposit',99,'y'],
        ['FTD Rate',98,'y'],['Registrations',94,'y'],['First Time Deposits',92,'y'],
        ['Cost Per Leads',63,'r'],['Cost Per Acquisition',58,'r'],
    ];
 
    $agColor = ['g' => '#4caf50', 'y' => '#f5b335', 'r' => '#b91c1c'];
 
    $funnel = $funnel ?? [
        ['Leads', '2.010', 100, null, null],
        ['Registrations', '468', 23.3, '23,3%', 'convert from leads'],
        ['First Deposit', '55', 3, '11,8%', 'convert from registrations'],
    ];
 
    $weeks = $weeks ?? [
        ['Week 1', 560, 563, 66.64],
        ['Week 2', 460, 462, 54.74],
        ['Week 3', 520, 523, 61.64],
        ['Week 4', 460, 462, 53.64],
    ];
 
    $tabs = ['Leads','Registrations','First Time Deposits','Ad Spend','Revenue / Deposit','Cost Per Lead','Cost Per Acquisition','FTD Rate','Return on Ad Spend'];
@endphp
 
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
 
<style>
/* =====================================================
   MARKETING PERFORMANCE
   Selaras dengan My Work & Overview:
   token, font, ukuran heading, padding halaman, kartu, banner.
   Tanpa zoom di halaman; ukuran sudah dalam px asli.
===================================================== */
 
/* ---------- TOKENS & BASE ---------- */
.mp-page, .mp-page * { box-sizing: border-box; }
 
.mp-page {
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
    min-width: 0;
    margin: 0 auto;
    padding: 24px 0 56px;
    font-family: 'Inter', system-ui, sans-serif;
    font-size: 14px;
    line-height: 1.5;
    color: #f4f4f5;
    -webkit-font-smoothing: antialiased;
}
 
.mp-page h1, .mp-page h2, .mp-page h3, .mp-page p, .mp-page b { margin: 0; font-family: inherit; }
.mp-page a { text-decoration: none; color: inherit; }
.mp-page button { font-family: inherit; color: inherit; cursor: pointer; }
.mp-page a:focus-visible, .mp-page button:focus-visible, .mp-page [role="button"]:focus-visible { outline: 2px solid #fff; outline-offset: 2px; }
 
/* ---------- HEADING ---------- */
.mp-page .mp-heading {
    width: 100%;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 18px;
    margin-bottom: 22px;
}
.mp-page .mp-title { margin: 0 0 8px; font-size: 22.3px; font-weight: 600; line-height: 1.2; color: #f4f4f5; }
.mp-page .mp-sub { max-width: 780px; font-size: 14.6px; font-weight: 500; line-height: 1.5; color: var(--muted); }
 
.mp-page .mp-actions { display: flex; flex-wrap: wrap; gap: 10px; }
.mp-page .mp-btn {
    padding: 8px 14px;
    font-size: 13px;
    font-weight: 500;
    color: #fff;
    background: var(--inner);
    border: 1px solid var(--line-strong);
    border-radius: 8px;
    transition: background .2s var(--ease), border-color .2s var(--ease);
}
.mp-page .mp-btn:hover { border-color: #55555d; }
.mp-page .mp-btn.mp-month { width: 120px; display: flex; justify-content: space-between; align-items: center; }
.mp-page .mp-btn.mp-month svg { width: 14px; height: 14px; }
.mp-page .mp-btn.mp-red,
.mp-page .mp-btn.mp-sm { background: var(--red-deep); border-color: var(--red-deep); }
.mp-page .mp-btn.mp-red:hover,
.mp-page .mp-btn.mp-sm:hover { background: #8f1c20; border-color: #8f1c20; }
.mp-page .mp-btn.mp-sm { font-weight: 600; }
 
/* ---------- ATTENTION BANNER (sama persis dengan My Work) ---------- */
.mp-page .mp-banner {
    zoom: .75;
    display: flex;
    align-items: center;
    gap: 10px;
    height: 48px;
    padding: 0 20px;
    margin-bottom: 36px;
    font-size: 17px;
    font-weight: 500;
    color: #fff;
    background: #a31c1c;
    border-radius: 6px;
    transition: background .2s var(--ease);
}
.mp-page .mp-banner:hover { background: #8f1717; color: #fff; }
.mp-page .mp-banner svg { width: 20px; height: 20px; flex-shrink: 0; }
.mp-page .mp-banner-arrow { margin-left: auto; }
 
/* ---------- PANEL (= .ov-card / .section-content) ---------- */
.mp-page .mp-panel {
    min-width: 0;
    margin-top: 20px;
    padding: 22px;
    color: #fff;
    background: var(--card);
    border: 1px solid var(--line);
    border-radius: var(--r-lg);
    box-shadow: 0 8px 24px rgba(0,0,0,.25);
}
.mp-page .mp-panel h2 { margin: 0 2px 18px; font-size: 17px; font-weight: 600; line-height: 1.25; letter-spacing: -.01em; }
 
/* ---------- ANALYSIS TOGGLE ---------- */
.mp-page .mp-analysis-head {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 6px 16px;
    padding: 0 2px;
    font-size: 15px;
    font-weight: 600;
    text-align: left;
    background: none;
    border: 0;
}
.mp-page .mp-analysis-title { display: flex; align-items: center; gap: 10px; }
.mp-page .mp-analysis-chevron { width: 16px; height: 16px; flex-shrink: 0; transition: transform .25s var(--ease); }
.mp-page .mp-analysis-head[aria-expanded="false"] .mp-analysis-chevron { transform: rotate(-90deg); }
.mp-page .mp-analysis-head small { font-size: 12px; font-weight: 500; color: var(--muted); }
 
/* ---------- KPI CARDS ---------- */
.mp-page .mp-cards { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; }
 
.mp-page .mp-cards.mp-scroll {
    display: flex;
    overflow-x: auto;
    padding-bottom: 12px;
    scroll-snap-type: x mandatory;
    scrollbar-width: thin;
    scrollbar-color: #5a5a5a transparent;
}
.mp-page .mp-cards.mp-scroll::-webkit-scrollbar { height: 6px; }
.mp-page .mp-cards.mp-scroll::-webkit-scrollbar-thumb { background: #5a5a5a; border-radius: 9999px; }
.mp-page .mp-cards.mp-scroll .mp-card { flex: 0 0 calc((100% - 28px) / 3); min-width: 240px; scroll-snap-align: start; }
 
.mp-page .mp-card {
    min-width: 0;
    padding: 18px;
    background: var(--inner);
    border: 1px solid var(--line);
    border-radius: var(--r-md);
    transition: border-color .2s var(--ease);
}
.mp-page .mp-card:hover { border-color: var(--line-strong); }
 
.mp-page .mp-card-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; }
.mp-page .mp-card-name { display: flex; align-items: center; gap: 12px; min-width: 0; font-size: 14px; font-weight: 600; line-height: 1.25; }
.mp-page .mp-icon {
    width: 38px; height: 38px;
    flex: none;
    display: grid; place-items: center;
    color: #fff;
    background: rgba(255,255,255,.07);
    border-radius: 10px;
}
.mp-page .mp-icon svg { width: 18px; height: 18px; }
 
.mp-page .mp-delta { padding: 4px 10px; font-size: 12px; font-weight: 600; white-space: nowrap; border-radius: 6px; }
.mp-page .mp-delta.mp-red { background: #fde8e8; color: #d32030; }
.mp-page .mp-delta.mp-green { background: #e6f6ea; color: #3fa356; }
 
.mp-page .mp-value { margin-top: 14px; font-size: 20px; font-weight: 700; letter-spacing: -.02em; }
 
.mp-page .mp-track { height: 8px; width: 100%; margin-top: 12px; border-radius: 9999px; background: #e8e8e8; }
.mp-page .mp-fill { height: 100%; border-radius: 9999px; }
.mp-page .mp-fill.mp-red { background: #c8202a; }
.mp-page .mp-fill.mp-green { background: #4caf50; }
 
.mp-page .mp-meta { display: flex; align-items: center; margin-top: 14px; font-size: 12px; line-height: 1.4; }
.mp-page .mp-meta .mp-red { color: #e0434b; }
.mp-page .mp-meta .mp-green { color: #4caf50; }
.mp-page .mp-meta b { font-weight: 600; }
.mp-page .mp-m-actual { padding-right: 12px; }
.mp-page .mp-m-target { padding: 0 12px; color: #e5e5e5; border-left: 1px solid #52525b; border-right: 1px solid #52525b; }
.mp-page .mp-m-target b { color: #fff; }
.mp-page .mp-m-pct { margin-left: auto; padding-left: 12px; text-align: right; }
.mp-page .mp-m-pct b { font-size: 14px; }
 
.mp-page .mp-edit { display: inline-block; margin-top: 16px; font-size: 12px; font-weight: 500; text-decoration: underline; text-underline-offset: 2px; }
 
/* ---------- ANALYSIS ---------- */
.mp-page .mp-two { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; margin-top: 18px; }
.mp-page .mp-two[hidden] { display: none; }
 
.mp-page .mp-box { min-width: 0; padding: 20px; background: var(--inner); border: 1px solid var(--line); border-radius: var(--r-md); }
.mp-page .mp-box h3 { font-size: 16px; font-weight: 600; }
.mp-page .mp-box .mp-desc { margin-top: 6px; font-size: 13px; line-height: 1.45; color: #d4d4d8; }
 
.mp-page .mp-ag { display: flex; flex-direction: column; gap: 10px; margin-top: 20px; }
.mp-page .mp-ag-row { display: flex; align-items: center; gap: 12px; }
.mp-page .mp-ag-label { width: 140px; flex-shrink: 0; text-align: right; font-size: 13px; font-weight: 600; }
.mp-page .mp-ag-track { position: relative; flex: 1; height: 12px; background: #ececec; }
.mp-page .mp-ag-fill { height: 100%; }
.mp-page .mp-ag-line { position: absolute; left: 66.67%; top: -2px; bottom: -2px; width: 1px; background: #1a1a1d; }
.mp-page .mp-ag-val { width: 44px; font-size: 13px; font-weight: 600; }
.mp-page .mp-ag-axis { position: relative; height: 16px; margin: 10px 56px 0 152px; font-size: 12px; font-weight: 600; }
.mp-page .mp-ag-axis span { position: absolute; transform: translateX(-50%); }
 
.mp-page .mp-fn-wrap { display: flex; flex-direction: column; gap: 10px; margin-top: 20px; }
.mp-page .mp-fn-head { display: flex; justify-content: space-between; margin-bottom: 6px; font-size: 14px; font-weight: 600; }
.mp-page .mp-fn-track { height: 18px; border-radius: 4px; background: #ececec; overflow: hidden; }
.mp-page .mp-fn-fill { height: 100%; border-radius: 4px; background: linear-gradient(90deg, #1357c8, #2f7cf0, #5aa2ff); }
.mp-page .mp-chip-row { display: flex; align-items: center; gap: 10px; padding: 4px 0; font-size: 13px; }
.mp-page .mp-chev { font-size: 12px; }
.mp-page .mp-chip { padding: 2px 8px; font-weight: 600; color: #1d3a8a; background: #e4ecff; border-radius: 4px; }
 
/* ---------- MONTH OVER MONTH ---------- */
.mp-page .mp-mom h2 { margin: 0; }
.mp-page .mp-mom .mp-hint { margin-top: 6px; font-size: 13px; font-weight: 500; color: var(--muted); }
 
.mp-page .mp-tabs {
    display: flex;
    gap: 8px;
    margin-top: 14px;
    padding-bottom: 6px;
    overflow-x: auto;
    scrollbar-width: thin;
    scrollbar-color: #5a5a5a transparent;
}
.mp-page .mp-tab {
    flex-shrink: 0;
    padding: 6px 12px;
    font-size: 13px;
    background: transparent;
    border: 1px solid #555;
    border-radius: 6px;
    transition: border-color .2s var(--ease), background .2s var(--ease);
}
.mp-page .mp-tab:hover { border-color: #8a8a93; }
.mp-page .mp-tab.mp-active { font-weight: 500; color: #1d4ed8; background: #dbe7ff; border-color: #3b82f6; }
 
.mp-page .mp-up-row { display: flex; align-items: center; flex-wrap: wrap; gap: 10px; margin-top: 14px; font-size: 13px; }
.mp-page .mp-up { padding: 4px 10px; font-weight: 600; color: #2f8a44; background: #e6f6ea; border: 1px solid #3fa356; border-radius: 6px; }
 
.mp-page .mp-mom-wrap { margin-top: 18px; padding: 0 12px 0 44px; }
.mp-page .mp-mom-plot { position: relative; margin-top: 64px; cursor: ew-resize; user-select: none; }
.mp-page .mp-mom-plot svg { display: block; width: 100%; height: 140px; }
.mp-page .mp-y-labels {
    position: absolute;
    left: -44px; top: 1px;
    width: 38px; height: 129px;
    display: flex; flex-direction: column; justify-content: space-between;
    text-align: right;
    font-size: 11px; font-weight: 600; line-height: 14px;
}
.mp-page .mp-dot { position: absolute; top: 0; bottom: 0; width: 2px; background: #3b82f6; transform: translateX(-50%); pointer-events: none; z-index: 21; }
.mp-page .mp-dot::after {
    content: '';
    position: absolute; top: 35%; left: 50%;
    width: 12px; height: 12px;
    background: #3b82f6; border: 2px solid #fff; border-radius: 50%;
    transform: translate(-50%, -50%);
}
.mp-page .mp-tip1 {
    position: absolute; top: 35%;
    width: 170px;
    margin-top: -18px;
    padding: 8px 12px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 6px 14px rgba(0,0,0,.35);
    transform: translate(-50%, -100%);
    pointer-events: none;
    z-index: 20;
    transition: left .05s ease-out;
}
.mp-page .mp-tip1 .mp-d { font-size: 12px; line-height: 1.2; color: #3b82f6; }
.mp-page .mp-tip1 .mp-t { margin-top: 4px; font-size: 14px; font-weight: 600; line-height: 1.2; color: #171717; }
.mp-page .mp-tip1 .mp-r { display: flex; justify-content: space-between; gap: 10px; margin-top: 8px; font-size: 12px; line-height: 1.2; color: #737373; }
.mp-page .mp-tip1 .mp-r + .mp-r { margin-top: 4px; }
.mp-page .mp-tip1 .mp-neg { color: #ef4444; }
.mp-page .mp-x-labels { display: flex; justify-content: space-between; margin-top: 6px; font-size: 12px; font-weight: 600; }
.mp-page .mp-mom-gap { height: 24px; }
 
/* ---------- WEEKLY PACING ---------- */
.mp-page .mp-pace-head { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
.mp-page .mp-pace-head h2 { margin: 0; }
.mp-page .mp-pace-head p { margin-top: 6px; font-size: 13px; font-weight: 500; color: var(--muted); }
 
.mp-page .mp-chart-title { display: flex; align-items: center; justify-content: space-between; margin-top: 22px; font-size: 13px; font-weight: 600; }
.mp-page .mp-legend { display: flex; gap: 16px; font-size: 12px; }
.mp-page .mp-legend span { display: flex; align-items: center; gap: 6px; }
.mp-page .mp-legend i { width: 10px; height: 10px; display: inline-block; border-radius: 50%; }
.mp-page .mp-legend .mp-red { background: var(--red-deep); }
.mp-page .mp-legend .mp-grey { background: #dcdcdc; }
 
.mp-page .mp-chart-scroll { overflow-x: auto; scrollbar-width: thin; scrollbar-color: #5a5a5a transparent; }
.mp-page .mp-chart-inner { min-width: 0; }
.mp-page .mp-chart { display: flex; margin-top: 10px; }
.mp-page .mp-rot { width: 28px; display: flex; align-items: center; justify-content: center; }
.mp-page .mp-rot span { transform: rotate(-90deg); white-space: nowrap; font-size: 12px; font-weight: 600; }
.mp-page .mp-yax { width: 36px; height: 140px; display: flex; flex-direction: column; justify-content: space-between; text-align: right; font-size: 11px; font-weight: 600; }
.mp-page .mp-yax.mp-wide { width: 68px; }
.mp-page .mp-plot { position: relative; flex: 1; display: flex; height: 140px; margin-left: 8px; border-bottom: 1px solid #a3a3a3; border-left: 1px solid #a3a3a3; }
.mp-page .mp-col { flex: 1; display: flex; align-items: flex-end; justify-content: center; }
.mp-page .mp-grp { position: relative; display: flex; align-items: flex-end; gap: 6px; }
.mp-page .mp-bw { display: flex; flex-direction: column; align-items: center; }
.mp-page .mp-bw span { font-size: 11px; font-weight: 600; }
.mp-page .mp-nowrap { white-space: nowrap; }
.mp-page .mp-bar { width: 28px; }
.mp-page .mp-bar.mp-grey { background: #e0e0e0; }
.mp-page .mp-bar.mp-red { background: var(--red-deep); }
.mp-page .mp-wk-labels { display: flex; margin: 6px 0 0 105px; font-size: 12px; font-weight: 600; }
.mp-page .mp-wk-labels span { flex: 1; text-align: center; }
 
.mp-page .mp-grp.mp-tooltip-trigger { cursor: pointer; }
.mp-page .mp-tip2 {
    display: none;
    position: absolute; right: -4px; bottom: 8px;
    z-index: 10;
    width: 190px;
    padding: 10px 12px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 6px 14px rgba(0,0,0,.35);
}
.mp-page .mp-grp.mp-tooltip-trigger.is-active .mp-tip2 { display: block; }
.mp-page .mp-t-title { font-size: 13px; font-weight: 600; line-height: 1.2; color: #171717; }
.mp-page .mp-t-body { margin-top: 6px; font-size: 12px; line-height: 1.4; color: #262626; }
.mp-page .mp-t-sub { margin-top: 8px; font-size: 11px; line-height: 1.4; color: #737373; }
 
/* ---------- WEEK SUMMARY ---------- */
.mp-page .mp-weeks { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px; margin-top: 20px; }
.mp-page .mp-week-card {
    min-width: 0;
    padding: 18px;
    font-size: 13px;
    font-weight: 500;
    background: var(--card);
    border: 1px solid var(--line);
    border-radius: var(--r-lg);
    box-shadow: 0 8px 24px rgba(0,0,0,.25);
}
.mp-page .mp-wc-head { display: flex; align-items: center; justify-content: space-between; }
.mp-page .mp-pace { padding: 2px 8px; font-size: 11px; font-weight: 600; color: #000; background: #fff; border-radius: 4px; }
.mp-page .mp-wc-row { display: flex; justify-content: space-between; gap: 10px; margin-top: 12px; }
.mp-page .mp-wc-row .mp-r { text-align: right; }
 
/* =====================================================
   TABLET
===================================================== */
@media (max-width: 1100px) {
    .mp-page .mp-title { font-size: 20.8px; }
    .mp-page .mp-sub { font-size: 13.1px; }
    .mp-page .mp-cards:not(.mp-scroll) { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .mp-page .mp-weeks { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}
@media (max-width: 900px) {
    .mp-page .mp-two { grid-template-columns: 1fr; }
}
 
/* =====================================================
   MOBILE
===================================================== */
@media (max-width: 768px) {
    .mp-page { padding: 84px 16px 40px; font-size: 16px; }
 
    .mp-page .mp-heading { flex-direction: column; align-items: stretch; gap: 16px; margin-bottom: 22px; }
    .mp-page .mp-title { font-size: 33px; margin-bottom: 8px; }
    .mp-page .mp-sub { max-width: 100%; font-size: 19px; line-height: 1.55; }
 
    .mp-page .mp-actions { width: 100%; }
    .mp-page .mp-btn { flex: 1 1 auto; padding: 12px 14px; font-size: 16px; text-align: center; }
    .mp-page .mp-btn.mp-month { width: auto; }
    .mp-page .mp-btn.mp-month svg { width: 16px; height: 16px; }
    .mp-page .mp-btn.mp-sm { flex: none; padding: 10px 16px; }
 
    .mp-page .mp-panel { margin-top: 18px; padding: 18px; }
    .mp-page .mp-panel h2 { margin: 0 2px 16px; font-size: 21px; }
    .mp-page .mp-analysis-head { font-size: 20px; }
    .mp-page .mp-analysis-head small { font-size: 15px; }
 
    /* KPI: semua kategori menjadi carousel horizontal */
    .mp-page .mp-cards,
    .mp-page .mp-cards.mp-scroll {
        display: flex;
        flex-wrap: nowrap;
        gap: 12px;
        width: 100%;
        padding: 0 0 12px;
        overflow-x: auto;
        overflow-y: hidden;
        overscroll-behavior-x: contain;
        -webkit-overflow-scrolling: touch;
        scroll-snap-type: x mandatory;
        direction: ltr;
    }
    .mp-page .mp-cards .mp-card,
    .mp-page .mp-cards.mp-scroll .mp-card { flex: 0 0 260px; width: 260px; min-width: 260px; max-width: 260px; scroll-snap-align: start; padding: 16px; }
 
    .mp-page .mp-card-name { font-size: 14px; }
    .mp-page .mp-icon { width: 40px; height: 40px; }
    .mp-page .mp-icon svg { width: 20px; height: 20px; }
    .mp-page .mp-delta { padding: 5px 8px; font-size: 13px; }
    .mp-page .mp-value { font-size: 26px; }
    .mp-page .mp-meta { display: grid; grid-template-columns: 1fr 1fr; gap: 12px 16px; font-size: 16px; }
    .mp-page .mp-m-actual { padding: 0; }
    .mp-page .mp-m-target { padding: 0; border: 0; }
    .mp-page .mp-m-pct { grid-column: 1 / -1; margin: 0; padding: 0; text-align: left; }
    .mp-page .mp-m-pct b { font-size: 19px; }
    .mp-page .mp-edit { font-size: 16px; }
 
    .mp-page .mp-box { padding: 18px 16px; }
    .mp-page .mp-box h3 { font-size: 21px; }
    .mp-page .mp-box .mp-desc { font-size: 15px; }
    .mp-page .mp-ag-row { flex-wrap: wrap; gap: 4px 12px; }
    .mp-page .mp-ag-label { width: 100%; text-align: left; font-size: 16px; }
    .mp-page .mp-ag-track { height: 16px; }
    .mp-page .mp-ag-val { width: 48px; font-size: 16px; }
    .mp-page .mp-ag-axis { height: 20px; margin: 10px 60px 0 0; font-size: 14px; }
    .mp-page .mp-fn-head { font-size: 18px; }
    .mp-page .mp-chip-row { font-size: 16px; }
 
    .mp-page .mp-mom .mp-hint,
    .mp-page .mp-pace-head p { font-size: 16px; }
    .mp-page .mp-tab { padding: 8px 14px; font-size: 16px; }
    .mp-page .mp-up-row { font-size: 16px; }
    .mp-page .mp-mom-wrap { padding: 0 6px 0 48px; }
    .mp-page .mp-y-labels { left: -48px; width: 40px; font-size: 13px; }
    .mp-page .mp-tip1 { width: 180px; }
    .mp-page .mp-tip1 .mp-t { font-size: 17px; }
    .mp-page .mp-tip1 .mp-d, .mp-page .mp-tip1 .mp-r { font-size: 14px; }
    .mp-page .mp-x-labels { font-size: 13px; }
 
    .mp-page .mp-chart-title { font-size: 17px; }
    .mp-page .mp-legend { font-size: 14px; }
    .mp-page .mp-chart-scroll { width: 100%; }
    .mp-page .mp-chart-inner { min-width: 560px; }
    .mp-page .mp-tip2 { width: 220px; }
    .mp-page .mp-t-title { font-size: 15px; }
    .mp-page .mp-t-body { font-size: 14px; }
    .mp-page .mp-t-sub { font-size: 13px; }
 
    .mp-page .mp-weeks { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
    .mp-page .mp-week-card { padding: 16px; font-size: 17px; }
    .mp-page .mp-pace { font-size: 13px; }
}
 
@media (max-width: 600px) {
    .mp-page .mp-weeks { grid-template-columns: 1fr; }
}
 
@media (max-width: 480px) {
    .mp-page { padding: 84px 14px 36px; }
    .mp-page .mp-title { font-size: 31px; }
    .mp-page .mp-sub { font-size: 18px; }
    .mp-page .mp-panel { padding: 16px; }
}
 
@media (max-width: 360px) {
    .mp-page { padding-left: 12px; padding-right: 12px; }
    .mp-page .mp-title { font-size: 28px; }
    .mp-page .mp-sub { font-size: 17px; }
    .mp-page .mp-panel { padding: 14px; }
}
 
@media (prefers-reduced-motion: reduce) {
    .mp-page *, .mp-page *::before { transition: none !important; }
}
</style>
 
<div class="mp-page">
 
    {{-- PAGE HEADING --}}
    <div class="mp-heading">
        <div>
            <h1 class="mp-title">Marketing Performance</h1>
            <p class="mp-sub">Marketing performance from the latest synchronised data</p>
        </div>
 
        <div class="mp-actions">
            <button type="button" class="mp-btn mp-month">Nov 2026
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 6 6 6-6 6"/></svg>
            </button>
            <button type="button" class="mp-btn">Board Dossier</button>
            <button type="button" class="mp-btn mp-red">Export As ▾</button>
        </div>
    </div>
 
    {{-- ATTENTION BANNER --}}
    <a href="#" class="mp-banner">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path d="M12 3 2.8 20h18.4L12 3Z"/>
            <path d="M12 9v5M12 17h.01" stroke-linecap="round"/>
        </svg>
        <span>1 item needs attention</span>
        <svg class="mp-banner-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path d="M5 12h14M13 6l6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </a>
 
    {{-- KPI SECTIONS --}}
    @foreach($sections as $s)
        <section class="mp-panel">
            <h2>{{ $s['title'] }}</h2>
 
            <div class="mp-cards {{ $s['scroll'] ? 'mp-scroll' : '' }}">
                @foreach($s['cards'] as [$name, $ic, $delta, $actual, $target, $pct, $bar, $tone])
                    <div class="mp-card">
                        <div class="mp-card-top">
                            <div class="mp-card-name">
                                <span class="mp-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">{!! $icons[$ic] !!}</svg>
                                </span>
                                <span>{{ $name }}</span>
                            </div>
                            <span class="mp-delta mp-{{ $tone }}">{{ $tone === 'red' ? '↙' : '↗' }} {{ $delta }}</span>
                        </div>
 
                        <p class="mp-value">{{ $actual }}</p>
 
                        <div class="mp-track">
                            <div class="mp-fill mp-{{ $tone }}" style="width: {{ $bar }}%"></div>
                        </div>
 
                        <div class="mp-meta">
                            <div class="mp-m-actual mp-{{ $tone }}">Actual<br><b>{{ $actual }}</b></div>
                            <div class="mp-m-target">Target<br><b>{{ $target }}</b></div>
                            <div class="mp-m-pct mp-{{ $tone }}"><b>{{ $pct }}</b><br>vs target</div>
                        </div>
 
                        <a href="#" class="mp-edit">Edit figures</a>
                    </div>
                @endforeach
            </div>
        </section>
    @endforeach
 
    {{-- FULL PERFORMANCE ANALYSIS --}}
    <section class="mp-panel">
        <button type="button" class="mp-analysis-head" aria-expanded="true" aria-controls="mp-analysis-body">
            <span class="mp-analysis-title">
                <svg class="mp-analysis-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m6 9 6 6 6-6"/>
                </svg>
                Full performance analysis
            </span>
            <small>Against target · Funnel · Month over month · Weekly pacing</small>
        </button>
 
        <div id="mp-analysis-body" class="mp-two">
            {{-- Against target --}}
            <div class="mp-box">
                <h3>Against target</h3>
                <p class="mp-desc">Distance from 100% of target. Right of the line beat it, left of it fell short.<br>Monitored metrics are left out — they have no target to be measured against.</p>
 
                <div class="mp-ag">
                    @foreach($against as [$label, $v, $c])
                        <div class="mp-ag-row">
                            <span class="mp-ag-label">{{ $label }}</span>
                            <div class="mp-ag-track">
                                <div class="mp-ag-fill" style="width: {{ round(($v - 50) / 75 * 100, 2) }}%; background: {{ $agColor[$c] }}"></div>
                                <i class="mp-ag-line"></i>
                            </div>
                            <span class="mp-ag-val">{{ $v }}%</span>
                        </div>
                    @endforeach
                </div>
 
                <div class="mp-ag-axis">
                    <span style="left:0">50%</span>
                    <span style="left:33.33%">75%</span>
                    <span style="left:66.67%">100%</span>
                    <span style="left:100%">125%</span>
                </div>
            </div>
 
            {{-- Funnel --}}
            <div class="mp-box">
                <h3>Acquisition funnel</h3>
                <p class="mp-desc">Each stage against the one before it. Bar length is the count, not the rate.</p>
 
                <div class="mp-fn-wrap">
                    @foreach($funnel as [$lbl, $n, $w, $chip, $chipText])
                        @if($chip)
                            <p class="mp-chip-row">
                                <span class="mp-chev">⌄</span>
                                <span class="mp-chip">{{ $chip }}</span>
                                {{ $chipText }}
                            </p>
                        @endif
 
                        <div>
                            <div class="mp-fn-head">
                                <span>{{ $lbl }}</span>
                                <span>{{ $n }}</span>
                            </div>
                            <div class="mp-fn-track">
                                <div class="mp-fn-fill" style="width: {{ $w }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
 
    {{-- MONTH OVER MONTH --}}
    <section class="mp-panel mp-mom">
        <h2>Month over month</h2>
        <p class="mp-hint">9 of 9 metrics have enough history to show a direction</p>
 
        <div class="mp-tabs" id="mp-tabs">
            @foreach($tabs as $i => $t)
                <button type="button" class="mp-tab {{ $i === 0 ? 'mp-active' : '' }}">{{ $t }}</button>
            @endforeach
        </div>
 
        <div class="mp-up-row">
            <span class="mp-up">↗ Up 30.1%</span>
            <span>Jun 2026 to Sep 2026</span>
        </div>
 
        <div class="mp-mom-wrap">
            <div class="mp-mom-plot" id="momPlotArea">
                <div class="mp-y-labels">
                    <span>3rb</span>
                    <span>2rb</span>
                    <span>1rb</span>
                    <span>500</span>
                    <span>0</span>
                </div>
 
                <svg viewBox="0 0 760 170" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="mpMomFill" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#3b82f6" stop-opacity="0.65"/>
                            <stop offset="50%" stop-color="#2563eb" stop-opacity="0.25"/>
                            <stop offset="100%" stop-color="#1d4ed8" stop-opacity="0.0"/>
                        </linearGradient>
                    </defs>
 
                    @foreach([10,45,80,115,150] as $y)
                        <line x1="0" x2="760" y1="{{ $y }}" y2="{{ $y }}" stroke="#2e2e33" stroke-dasharray="2 4"/>
                    @endforeach
 
                    <path d="M4 52 C 90 56, 170 72, 255 64 C 340 56, 420 30, 510 33 C 600 36, 680 18, 752 12 L 752 150 L 4 150 Z" fill="url(#mpMomFill)"/>
                    <path d="M4 52 C 90 56, 170 72, 255 64 C 340 56, 420 30, 510 33 C 600 36, 680 18, 752 12" fill="none" stroke="#60a5fa" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"/>
 
                    <line x1="255" x2="255" y1="0" y2="165" stroke="#71717a" stroke-dasharray="3 3" vector-effect="non-scaling-stroke"/>
                    <line x1="510" x2="510" y1="0" y2="165" stroke="#71717a" stroke-dasharray="3 3" vector-effect="non-scaling-stroke"/>
                </svg>
 
                <div class="mp-dot" id="momIndicator"></div>
 
                <div class="mp-tip1" id="momTooltip" style="left: 47.4%;">
                    <p class="mp-d" id="tipDate">July 31</p>
                    <p class="mp-t" id="tipLeads">Leads: 1bn</p>
                    <p class="mp-r"><span>Previous period</span><span id="tipPrev">2bn</span></p>
                    <p class="mp-r"><span>Change</span><span id="tipChange" class="mp-neg">-50%</span></p>
                </div>
            </div>
 
            <div class="mp-x-labels">
                <span>June 26</span>
                <span>July 26</span>
                <span>August 26</span>
                <span>September 26</span>
            </div>
        </div>
        <div class="mp-mom-gap"></div>
    </section>
 
    {{-- WEEKLY PACING --}}
    <section class="mp-panel">
        <div class="mp-pace-head">
            <div>
                <h2>Weekly pacing</h2>
                <p>Track progress throughout the month</p>
            </div>
            <button type="button" class="mp-btn mp-sm">Nov 2026</button>
        </div>
 
        <div class="mp-chart-title">
            <span>Leads & Ad Spend</span>
            <div class="mp-legend">
                <span><i class="mp-grey"></i> Leads</span>
                <span><i class="mp-red"></i> Ad Spend</span>
            </div>
        </div>
 
        <div class="mp-chart-scroll">
            <div class="mp-chart-inner">
                <div class="mp-chart">
                    <div class="mp-rot"><span>Ad spend (Rp)</span></div>
                    <div class="mp-yax mp-wide">
                        <span>Rp 80 Jt</span>
                        <span>Rp 60 Jt</span>
                        <span>Rp 40 Jt</span>
                        <span>Rp 20 Jt</span>
                        <span>Rp 0</span>
                    </div>
 
                    <div class="mp-plot">
                        @foreach($weeks as $i => [$wk, $a, $b, $sp])
                            <div class="mp-col">
                                <div
                                    class="mp-grp {{ $i === 1 ? 'mp-tooltip-trigger' : '' }}"
                                    @if($i === 1)
                                        role="button"
                                        tabindex="0"
                                        aria-expanded="false"
                                        aria-label="Show Week 2 details"
                                    @endif
                                >
                                    @if($i === 1)
                                        <div class="mp-tip2">
                                            <p class="mp-t-title">{{ $wk }}</p>
                                            <p class="mp-t-body">Leads {{ $b }}<br>Target {{ $a }}</p>
                                            <p class="mp-t-sub">
                                                Ad spend Rp {{ number_format($sp * 1000000, 0, '.', ',') }}<br>
                                                100% of the week's target - on space
                                            </p>
                                        </div>
                                    @endif
 
                                    <div class="mp-bw">
                                        <span>{{ $a }}</span>
                                        <div class="mp-bar mp-grey" style="height: {{ round($a / 600 * 105) }}px"></div>
                                    </div>
 
                                    <div class="mp-bw">
                                        <span class="mp-nowrap">Rp {{ number_format($sp * 1000000, 0, ',', '.') }}</span>
                                        <div class="mp-bar mp-red" style="height: {{ round($sp / 80 * 120) }}px"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
 
                <div class="mp-wk-labels">
                    @foreach($weeks as $w)
                        <span>{{ $w[0] }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
 
    {{-- WEEK SUMMARY --}}
    <div class="mp-weeks">
        @foreach([1,2,3,4] as $n)
            <div class="mp-week-card">
                <div class="mp-wc-head">
                    <b>Week {{ $n }}</b>
                    <span class="mp-pace">On pace</span>
                </div>
 
                <div class="mp-wc-row">
                    <span>Leads</span>
                    @if($n < 4)
                        <span class="mp-r">563<br>of 560</span>
                    @endif
                </div>
 
                <div class="mp-wc-row">
                    <span>Ad spend</span>
                    <span class="mp-r">Rp 66.640.000<br>of Rp 200.000.000</span>
                </div>
 
                <div class="mp-wc-row">
                    <span>FTD</span>
                    @if($n < 4)
                        <span class="mp-r">15<br>of 17</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
 
</div>
 
{{-- JAVASCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
 
    // Reset setiap kategori KPI ke posisi paling kiri saat halaman dibuka/dipulihkan.
    function resetKpiScroll() {
        document.querySelectorAll('.mp-page .mp-cards').forEach(function (container) {
            container.scrollLeft = 0;
        });
    }
 
    requestAnimationFrame(function () {
        requestAnimationFrame(resetKpiScroll);
    });
 
    window.addEventListener('pageshow', function () {
        requestAnimationFrame(function () {
            requestAnimationFrame(resetKpiScroll);
        });
    });
 
    // Buka/tutup Full performance analysis.
    var head = document.querySelector('.mp-analysis-head');
    if (head) {
        head.addEventListener('click', function () {
            var body = document.getElementById(head.getAttribute('aria-controls'));
            var open = head.getAttribute('aria-expanded') === 'true';
 
            head.setAttribute('aria-expanded', String(!open));
 
            if (body) {
                body.hidden = open;
            }
        });
    }
 
    // Tab Month over month.
    var tabs = document.querySelectorAll('#mp-tabs .mp-tab');
    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            tabs.forEach(function (item) {
                item.classList.remove('mp-active');
            });
 
            tab.classList.add('mp-active');
        });
    });
 
    // Interactive Draggable / Hoverable Month over Month Chart
    var momPlot = document.getElementById('momPlotArea');
    var momIndicator = document.getElementById('momIndicator');
    var momTooltip = document.getElementById('momTooltip');
    var tipDate = document.getElementById('tipDate');
    var tipLeads = document.getElementById('tipLeads');
    var tipPrev = document.getElementById('tipPrev');
    var tipChange = document.getElementById('tipChange');
 
    if (momPlot && momIndicator && momTooltip) {
        function updateChartPosition(clientX) {
            var rect = momPlot.getBoundingClientRect();
            var x = clientX - rect.left;
            var pct = x / rect.width;
 
            // Clamp percentage between 3% and 97% to keep tooltip inside bounds
            pct = Math.max(0.03, Math.min(0.97, pct));
            var percentStr = (pct * 100).toFixed(2) + '%';
 
            momIndicator.style.left = percentStr;
            momTooltip.style.left = percentStr;
 
            // Interpolate dynamic dates (June 1 to September 30)
            var startTimestamp = new Date(2026, 5, 1).getTime();
            var endTimestamp = new Date(2026, 8, 30).getTime();
            var currentTimestamp = startTimestamp + pct * (endTimestamp - startTimestamp);
            var currentDate = new Date(currentTimestamp);
 
            var options = { day: 'numeric', month: 'long' };
            tipDate.textContent = currentDate.toLocaleDateString('en-US', options);
 
            // Dynamically calculate simulated metrics based on cursor position
            var leadsVal = (1 + pct * 1.8).toFixed(1) + 'bn';
            var prevVal = (1.5 + pct * 1.2).toFixed(1) + 'bn';
            var changeNum = Math.round((pct - 0.5) * 60);
            var changeStr = (changeNum >= 0 ? '+' : '') + changeNum + '%';
 
            tipLeads.textContent = 'Leads: ' + leadsVal;
            tipPrev.textContent = prevVal;
            tipChange.textContent = changeStr;
 
            if (changeNum < 0) {
                tipChange.className = 'mp-neg';
                tipChange.style.color = '#ef4444';
            } else {
                tipChange.className = '';
                tipChange.style.color = '#22c55e';
            }
        }
 
        var isDragging = false;
 
        momPlot.addEventListener('mousedown', function (e) {
            isDragging = true;
            updateChartPosition(e.clientX);
        });
 
        window.addEventListener('mousemove', function (e) {
            if (!isDragging) return;
            updateChartPosition(e.clientX);
        });
 
        window.addEventListener('mouseup', function () {
            isDragging = false;
        });
 
        // Touch support for mobile devices
        momPlot.addEventListener('touchstart', function (e) {
            isDragging = true;
            if (e.touches.length > 0) {
                updateChartPosition(e.touches[0].clientX);
            }
        });
 
        window.addEventListener('touchmove', function (e) {
            if (!isDragging) return;
            if (e.touches.length > 0) {
                updateChartPosition(e.touches[0].clientX);
            }
        });
 
        window.addEventListener('touchend', function () {
            isDragging = false;
        });
 
        // Set default initial position at 47.4%
        updateChartPosition(momPlot.getBoundingClientRect().left + momPlot.offsetWidth * 0.474);
    }
 
    // Tooltip Week 2 hanya muncul ketika grafik diklik.
    var tooltipTrigger = document.querySelector('.mp-tooltip-trigger');
 
    if (tooltipTrigger) {
        function toggleWeekTooltip() {
            var active = tooltipTrigger.classList.toggle('is-active');
            tooltipTrigger.setAttribute('aria-expanded', String(active));
        }
 
        tooltipTrigger.addEventListener('click', function (event) {
            event.stopPropagation();
            toggleWeekTooltip();
        });
 
        tooltipTrigger.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                toggleWeekTooltip();
            }
        });
 
        document.addEventListener('click', function (event) {
            if (!tooltipTrigger.contains(event.target)) {
                tooltipTrigger.classList.remove('is-active');
                tooltipTrigger.setAttribute('aria-expanded', 'false');
            }
        });
    }
});
</script>
 
@endsection
 