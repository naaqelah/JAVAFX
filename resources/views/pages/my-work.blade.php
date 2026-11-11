@extends('layouts.app')
 
@section('title', 'My Work | Java Global Futures')
 
@section('content')
 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
 
<style>
    /* =========================================
       TOKENS & BASE (selaras dengan halaman Promotors)
    ========================================= */
    .mw, .mw * { box-sizing: border-box; }
 
    .mw {
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
 
    .mw h1, .mw h2, .mw p, .mw b { margin: 0; font-family: inherit; }
    .mw a { text-decoration: none; color: inherit; }
    .mw button { font-family: inherit; }
    .mw a:focus-visible, .mw button:focus-visible { outline: 2px solid #fff; outline-offset: 2px; }
 
    /* =========================================
       HEADING
    ========================================= */
    .mw .page-heading {
        width: 100%;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 18px;
        margin-bottom: 22px;
    }
 
    .mw .page-title {
        margin: 0 0 8px;
        font-size: 22.3px;
        font-weight: 600;
        line-height: 1.2;
        color: #f4f4f5;
    }
 
    .mw .page-subtitle {
        max-width: 780px;
        margin: 0;
        font-size: 14.6px;
        font-weight: 500;
        line-height: 1.5;
        color: var(--muted);
    }
 
    .mw .page-summary {
        min-width: 190px;
        margin-left: auto;
        flex-shrink: 0;
        text-align: right;
    }
 
    .mw .summary-title {
        font-size: 15px;
        font-weight: 600;
        color: #f4f4f5;
    }
 
    .mw .summary-date {
        display: inline-block;
        margin: 7px 0;
        padding: 4px 10px;
        font-size: 12.5px;
        color: #d4d4d8;
        background: var(--inner);
        border: 1px solid var(--line);
        border-radius: 7px;
    }
 
    .mw .summary-description {
        margin-top: 2px;
        font-size: 13.5px;
        line-height: 1.45;
        color: var(--muted);
    }
 
    /* =========================================
       BANNER PERHATIAN (sama persis dengan Promotors)
       zoom .75 = skala yang sama dengan halaman lain
    ========================================= */
    .mw .attention-banner {
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
    .mw .attention-banner:hover { background: #8f1717; color: #fff; }
    .mw .attention-banner svg { width: 20px; height: 20px; flex-shrink: 0; }
    .mw .banner-arrow { margin-left: auto; }
 
    /* =========================================
       SECTION (judul + kartu)
    ========================================= */
    .mw .work-section { width: 100%; min-width: 0; margin-top: 24px; }
 
    .mw .section-heading {
        min-height: 34px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0;
        font-size: 19px;
        font-weight: 600;
        letter-spacing: -.01em;
        text-align: left;
        color: #f4f4f5;
        background: transparent;
        border: 0;
        cursor: pointer;
    }
    .mw .section-heading svg { width: 18px; height: 18px; flex-shrink: 0; transition: transform .2s var(--ease); }
    .mw .section-heading[aria-expanded="false"] svg { transform: rotate(-90deg); }
 
    .mw .section-content {
        width: 100%;
        min-width: 0;
        margin-top: 12px;
        overflow: hidden;
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: var(--r-lg);
        box-shadow: 0 8px 24px rgba(0,0,0,.25);
    }
    .mw .section-content[hidden] { display: none !important; }
 
    /* =========================================
       TABEL (sama dengan tabel Promotors)
    ========================================= */
    .mw .table-scroll {
        width: 100%;
        min-width: 0;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
 
    .mw .work-table {
        width: 100%;
        min-width: 650px;
        border-collapse: collapse;
        border-spacing: 0;
        font-size: 14px;
        text-align: left;
        color: #f4f4f5;
        background: transparent;
    }
 
    .mw .work-table thead { background: var(--inner); }
 
    .mw .work-table th {
        height: 46px;
        padding: 0 20px;
        font-size: 13px;
        font-weight: 500;
        white-space: nowrap;
        color: var(--muted);
        background: var(--inner);
        border-bottom: 1px solid var(--line);
    }
 
    .mw .work-table td {
        height: 56px;
        padding: 12px 20px;
        font-size: 14px;
        color: #f4f4f5;
        vertical-align: middle;
        border-bottom: 1px solid var(--line);
        transition: background .2s var(--ease);
    }
 
    .mw .work-table th:first-child,
    .mw .work-table td:first-child { width: 64px; text-align: center; }
 
    .mw .work-table tbody tr:hover td { background: rgba(255,255,255,.03); }
    .mw .work-table tbody tr:last-child td { border-bottom: 0; }
 
    .mw .work-table td.empty-state {
        padding: 34px;
        text-align: center;
        color: var(--muted);
    }
 
    .mw .work-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        font-size: 14px;
        font-weight: 500;
        white-space: nowrap;
        color: #60a5fa;
    }
    .mw .work-action:hover { color: #93c5fd; }
    .mw .work-action svg { width: 16px; height: 16px; }
 
    /* =========================================
       KARTU MOBILE (desktop: disembunyikan)
    ========================================= */
    .mw .mobile-work-list,
    .mw .mobile-empty-card { display: none; }
 
    .mw .mobile-work-card {
        padding: 16px 14px;
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: var(--r-md);
    }
    .mw .mobile-work-card + .mobile-work-card { margin-top: 12px; }
 
    .mw .mobile-card-top,
    .mw .mobile-card-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }
 
    .mw .mobile-card-index { font-size: 13px; font-weight: 600; letter-spacing: .05em; color: var(--muted); }
 
    .mw .mobile-card-type {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        font-size: 13px;
        font-weight: 600;
        color: #d4d4d8;
        background: var(--inner);
        border: 1px solid var(--line-strong);
        border-radius: 999px;
    }
 
    .mw .mobile-card-name {
        margin: 12px 0 14px;
        font-size: 18px;
        font-weight: 600;
        line-height: 1.4;
        color: #f4f4f5;
        overflow-wrap: anywhere;
    }
 
    .mw .mobile-card-assignee { font-size: 15px; color: var(--muted); }
    .mw .mobile-card-assignee strong { font-weight: 500; color: #e5e7eb; }
 
    .mw .mobile-card-review {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 16px;
        font-weight: 600;
        white-space: nowrap;
        color: #60a5fa;
    }
    .mw .mobile-card-review:hover { color: #93c5fd; }
    .mw .mobile-card-review svg { width: 18px; height: 18px; }
 
    .mw .mobile-empty-card {
        padding: 30px 16px;
        text-align: center;
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: var(--r-md);
    }
    .mw .mobile-empty-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        color: #4ade80;
        background: rgba(34,201,133,.12);
        border-radius: 50%;
    }
    .mw .mobile-empty-icon svg { width: 25px; height: 25px; }
    .mw .mobile-empty-title { font-size: 19px; font-weight: 600; color: #f4f4f5; }
    .mw .mobile-empty-text { margin-top: 6px; font-size: 15px; line-height: 1.5; color: var(--muted); }
 
    /* =========================================
       TABLET
    ========================================= */
    @media (max-width: 1100px) {
        .mw .page-title { font-size: 20.8px; }
        .mw .page-subtitle { font-size: 13.1px; }
    }
 
    /* =========================================
       MOBILE: tabel berubah menjadi kartu
    ========================================= */
    @media (max-width: 768px) {
        .mw { padding: 84px 16px 40px; font-size: 16px; }
 
        .mw .page-heading { flex-direction: column; align-items: stretch; gap: 16px; margin-bottom: 22px; }
        .mw .page-title { font-size: 33px; margin-bottom: 8px; }
        .mw .page-subtitle { max-width: 100%; font-size: 19px; line-height: 1.55; }
 
        .mw .page-summary {
            width: 100%;
            min-width: 0;
            margin: 0;
            padding: 16px;
            display: grid;
            grid-template-columns: 1fr auto;
            align-items: center;
            gap: 8px 10px;
            text-align: left;
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: var(--r-md);
        }
        .mw .summary-title { grid-column: 1; font-size: 17px; }
        .mw .summary-date { grid-column: 2; grid-row: 1; margin: 0; font-size: 14px; }
        .mw .summary-description { grid-column: 1 / -1; margin-top: 2px; font-size: 15px; }
 
        .mw .work-section { margin-top: 24px; }
        .mw .section-heading { min-height: 44px; font-size: 21px; }
        .mw .section-heading svg { width: 22px; height: 22px; }
 
        .mw .desktop-work-table { display: none; }
        .mw .mobile-work-list,
        .mw .mobile-empty-card { display: block; }
 
        /* kartu berdiri sendiri, tanpa bingkai ganda */
        .mw .section-content {
            margin-top: 10px;
            overflow: visible;
            background: transparent;
            border: 0;
            border-radius: 0;
            box-shadow: none;
        }
    }
 
    @media (max-width: 480px) {
        .mw { padding: 84px 14px 36px; }
        .mw .page-title { font-size: 31px; }
        .mw .page-subtitle { font-size: 18px; }
        .mw .summary-title { font-size: 16px; }
        .mw .summary-description { font-size: 14px; }
        .mw .section-heading { font-size: 20px; }
        .mw .mobile-card-name { font-size: 17px; }
        .mw .mobile-card-assignee { font-size: 14px; }
        .mw .mobile-card-review { font-size: 15px; }
    }
 
    @media (max-width: 360px) {
        .mw { padding-left: 12px; padding-right: 12px; }
        .mw .page-title { font-size: 28px; }
        .mw .page-subtitle { font-size: 17px; }
        .mw .page-summary { padding: 14px; }
        .mw .mobile-card-bottom { align-items: flex-start; }
    }
 
    @media (prefers-reduced-motion: reduce) {
        .mw *, .mw *::before { transition: none !important; }
    }
</style>
 
 
<div class="mw">
 
    {{-- PAGE HEADING --}}
    <div class="page-heading">
        <div>
            <h1 class="page-title">My Work</h1>
 
            <p class="page-subtitle">
                What needs your attention right now, across your KPIs, content and projects
            </p>
        </div>
 
        <div class="page-summary">
            <div class="summary-title">
                Reinhart’s work today
            </div>
 
            <span class="summary-date">Oct 2026</span>
 
            <div class="summary-description">
                1 Content item needs your attention
            </div>
        </div>
    </div>
 
    {{-- ATTENTION BANNER --}}
    <a href="#need-review" class="attention-banner">
        <svg viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="1.8">
            <path d="M12 3 2.8 20h18.4L12 3Z"/>
            <path d="M12 9v5M12 17h.01"
                  stroke-linecap="round"/>
        </svg>
 
        <span>1 item needs attention</span>
 
        <svg class="banner-arrow"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="1.8">
            <path d="M5 12h14M13 6l6 6-6 6"
                  stroke-linecap="round"
                  stroke-linejoin="round"/>
        </svg>
    </a>
 
    {{-- NEED YOUR REVIEW --}}
    <section class="work-section" id="need-review">
 
        <button
            class="section-heading"
            type="button"
            aria-expanded="true"
            aria-controls="review-content"
        >
            <svg viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2">
                <path d="m6 9 6 6 6-6"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
 
            Need Your Review (1)
        </button>
 
        <div class="section-content" id="review-content">
 
            @php
                $reviewItems = [
                    ['Camera and lighting rig', 'Evidence', 'Jason'],
                    ['Exhibition booth install', 'Evidence', 'Jason'],
                    ['Exhibition booth install', 'Evidence', 'Jason'],
                    ['Market Open Short Film', 'Content', 'Jason'],
                    ['Partnership Announcement', 'Content', 'Michelle'],
                ];
            @endphp
 
            {{-- DESKTOP TABLE --}}
            <div class="table-scroll desktop-work-table">
                <table class="work-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Content Item</th>
                            <th>Type</th>
                            <th>Assigned Person</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
 
                    <tbody>
                        @foreach($reviewItems as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}.</td>
                                <td>{{ $item[0] }}</td>
                                <td>{{ $item[1] }}</td>
                                <td>{{ $item[2] }}</td>
                                <td>
                                    <a href="#" class="work-action">
                                        Review
 
                                        <svg viewBox="0 0 24 24"
                                             fill="none"
                                             stroke="currentColor"
                                             stroke-width="1.8">
                                            <path d="M5 12h14M13 6l6 6-6 6"
                                                  stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
 
            {{-- MOBILE STACKED CARDS --}}
            <div class="mobile-work-list">
                @foreach($reviewItems as $index => $item)
                    <article class="mobile-work-card">
 
                        <div class="mobile-card-top">
                            <span class="mobile-card-index">
                                ITEM {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
 
                            <span class="mobile-card-type">
                                {{ $item[1] }}
                            </span>
                        </div>
 
                        <div class="mobile-card-name">
                            {{ $item[0] }}
                        </div>
 
                        <div class="mobile-card-bottom">
                            <span class="mobile-card-assignee">
                                Assigned: <strong>{{ $item[2] }}</strong>
                            </span>
 
                            <a href="#" class="mobile-card-review">
                                Review
 
                                <svg viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.8">
                                    <path d="M5 12h14M13 6l6 6-6 6"
                                          stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </div>
 
                    </article>
                @endforeach
            </div>
 
        </div>
    </section>
 
    {{-- NEEDS ACTION --}}
    <section class="work-section">
 
        <button
            class="section-heading"
            type="button"
            aria-expanded="true"
            aria-controls="action-content"
        >
            <svg viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2">
                <path d="m6 9 6 6 6-6"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
 
            Needs action (0)
        </button>
 
        <div class="section-content" id="action-content">
 
            {{-- DESKTOP TABLE --}}
            <div class="table-scroll desktop-work-table">
                <table class="work-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Content Type</th>
                            <th>Content Name</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
 
                    <tbody>
                        <tr>
                            <td colspan="5" class="empty-state">
                                No pending actions at the moment.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
 
            {{-- MOBILE EMPTY STATE --}}
            <div class="mobile-empty-card">
                <div class="mobile-empty-icon">
                    <svg viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path d="m5 12 4 4L19 6"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </div>
 
                <div class="mobile-empty-title">
                    All caught up!
                </div>
 
                <div class="mobile-empty-text">
                    No pending actions at the moment.
                </div>
            </div>
 
        </div>
    </section>
 
</div>
 
{{-- JAVASCRIPT COLLAPSE --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
 
    document.querySelectorAll(
        '.mw .section-heading'
    ).forEach(function (button) {
 
        button.addEventListener('click', function () {
 
            const targetId = button.getAttribute('aria-controls');
            const content = document.getElementById(targetId);
 
            if (!content) return;
 
            const isExpanded =
                button.getAttribute('aria-expanded') === 'true';
 
            button.setAttribute(
                'aria-expanded',
                String(!isExpanded)
            );
 
            content.hidden = isExpanded;
 
        });
 
    });
 
});
</script>
 
@endsection
 
