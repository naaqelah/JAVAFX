{{-- resources/views/operations/content-calendar.blade.php --}}
@extends('layouts.app')

@php
    // ====== DATA (timpa dari controller: return view('operations.content-calendar', compact(...))) ======
    $selectedMonth = $selectedMonth ?? 'October 2026';
    $months        = $months ?? ['October 2026', 'September 2026', 'August 2026', 'July 2026'];
    $attention     = $attention ?? 1;
    $attentionUrl  = $attentionUrl ?? '#';

    // URL tujuan form
    $createAction   = $createAction ?? '';
    $scheduleAction = $scheduleAction ?? '#';

    // urutan kolom board
    $columns = [
        'idea'      => ['label' => 'IDEA',      'icon' => 'bi-lightbulb'],
        'drafting'  => ['label' => 'DRAFTING',  'icon' => 'bi-file-earmark-text'],
        'review'    => ['label' => 'IN REVIEW', 'icon' => 'bi-clock'],
        'approved'  => ['label' => 'APPROVED',  'icon' => 'bi-check-circle'],
        'scheduled' => ['label' => 'SCHEDULED', 'icon' => 'bi-calendar3'],
        'published' => ['label' => 'PUBLISHED', 'icon' => 'bi-megaphone'],
    ];

    $cards = $cards ?? [
        ['id' => 1,  'status' => 'drafting',  'title' => 'October Teaser Series',         'platform' => 'TT', 'owner' => 'Bella',    'date' => '16',   'full_date' => '16 Oct', 'image' => null, 'time' => '10:00'],
        ['id' => 2,  'status' => 'drafting',  'title' => 'Analyst Interview Rupiah Outlook', 'platform' => 'TT', 'owner' => 'Jason', 'date' => '17',   'full_date' => '17 Oct', 'image' => null, 'time' => '14:00'],
        ['id' => 3,  'status' => 'drafting',  'title' => 'project dashboard',             'platform' => 'TT', 'owner' => 'Reinhart', 'date' => '24',   'full_date' => '24 Oct', 'draft_empty' => true, 'time' => '10:00'],
        ['id' => 4,  'status' => 'review',    'title' => 'Partnership Announcement',      'platform' => 'IG', 'owner' => 'Michelle', 'date' => '7',    'full_date' => '7 Oct',  'image' => null, 'asset' => true, 'time' => '11:00'],
        ['id' => 5,  'status' => 'review',    'title' => 'Market Open Short Film',        'platform' => 'YT', 'owner' => 'Jason',    'date' => '8',    'full_date' => '8 Oct',  'image' => null, 'asset' => true, 'time' => '09:00'],
        ['id' => 6,  'status' => 'approved',  'title' => 'Acquisition Campaign Creative', 'platform' => 'TT', 'owner' => 'Jodie',    'date' => '11',   'full_date' => '11 Oct', 'image' => null, 'time' => '13:00'],
        ['id' => 7,  'status' => 'scheduled', 'title' => 'Weekend Campaign Reel',         'platform' => 'TT', 'owner' => 'Kevin',    'date' => '4',    'full_date' => '4 Oct',  'image' => null, 'time' => '14:00'],
        ['id' => 8,  'status' => 'scheduled', 'title' => 'October Campaign Shoot Package','platform' => 'TT', 'owner' => 'Jason',    'date' => '27',   'full_date' => '27 Oct', 'image' => null, 'time' => '09:00'],
        ['id' => 9,  'status' => 'published', 'title' => 'September Promo Launch',        'platform' => 'TT', 'owner' => 'Jodie',    'date' => '2',    'full_date' => '2 Sept', 'image' => null, 'time' => '10:00'],
        ['id' => 10, 'status' => 'published', 'title' => 'Trading Psychology Podcast — Ep. 4', 'platform' => 'TT', 'owner' => 'Jason', 'date' => '10', 'full_date' => '10 Sept', 'image' => null],
    ];
    $grouped = collect($cards)->groupBy('status');
@endphp

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap">
<style>
    .cc, .cc *{box-sizing:border-box}
    .cc{zoom:.75;
        font-family:'Inter',system-ui,sans-serif;color:#fff;font-size:15px;line-height:1.35;padding:18px 0 48px}
    .cc h1,.cc h2,.cc p,.cc b{margin:0;font-family:inherit}
    .cc a{text-decoration:none;color:inherit}
    .cc button,.cc select{font-family:inherit}

    /* judul + bulan */
    .cc .top{display:flex;justify-content:space-between;align-items:flex-end;gap:16px;flex-wrap:wrap;margin-bottom:22px}
    .cc .top h1{font-size:25px;font-weight:500;line-height:1.2;margin-bottom:8px}
    .cc .top .sub{font-size:15px;font-weight:500}
    .cc .month{position:relative;background:#3a3a3a;border:1px solid #777;border-radius:8px;height:44px}
    .cc .month select{appearance:none;-webkit-appearance:none;background:transparent;color:#fff;border:0;height:100%;padding:0 48px 0 22px;font-size:16px;font-weight:500;cursor:pointer;min-width:180px}
    .cc .month select option{color:#000}
    .cc .month i{position:absolute;right:16px;top:50%;transform:translateY(-50%);pointer-events:none}

    /* banner */
    .cc .alert{display:flex;align-items:center;gap:10px;background:#a31c1c;border-radius:6px;height:47px;padding:0 20px;font-size:16px;font-weight:500;margin-bottom:32px}
    .cc .alert .lead{font-size:19px}.cc .alert .go{margin-left:auto;font-size:19px}

    /* panel */
    .cc .panel{border:1px solid #cfcfcf;border-radius:10px;padding:30px 30px 34px}
    .cc .panel-head{display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;padding:0 2px;margin-bottom:24px;min-height:48px}
    .cc .panel-head h2{font-size:26px;font-weight:500}
    .cc .tools{display:flex;gap:20px}
    .cc .tb{display:inline-flex;align-items:center;gap:9px;height:45px;padding:0 15px;border-radius:6px;font-size:17px;font-weight:500;color:#fff;background:#2b2b2b;border:0;cursor:pointer}
    .cc .tb.on{background:#b3202a}
    .cc .tb.new{background:#fff;color:#222;padding:0 16px}
    .cc .tb i{font-size:19px}
    .cc hr{border:0;border-top:1px solid #bdbdbd;margin:0 0 24px}

    /* board */
    .cc .board{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:6px;align-items:start}
    .cc .col{background:#222;border-radius:7px;padding-bottom:12px;min-width:0}
    .cc .col-h{display:flex;align-items:center;gap:10px;background:#565656;border-radius:7px;height:46px;padding:0 16px;font-size:16.5px;font-weight:500;letter-spacing:.2px;white-space:nowrap;overflow:hidden}
    .cc .col-h i{font-size:20px}
    .cc .col-h .n{margin-left:auto}
    .cc .col-b{padding:12px 14px 0;display:flex;flex-direction:column;gap:12px}

    /* idea kosong */
    .cc .empty{border:1.5px dashed #fff;border-radius:3px;min-height:205px;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:10px 18px;gap:2px}
    .cc .empty i{font-size:32px;margin-bottom:6px}
    .cc .empty b{font-size:11px;font-weight:600}
    .cc .empty span{font-size:10.5px;color:#d0d0d0;line-height:1.25}

    /* kartu board */
    .cc .card{background:#1a1a1a;border:1px solid #c9c9c9;border-radius:4px;padding:10px 11px 11px;position:relative;cursor:pointer;transition:border-color .15s}
    .cc .card:hover{border-color:#a31c1c}
    .cc .card h3{margin:0;font-size:14.5px;font-weight:600;line-height:1.2;padding-right:36px}
    .cc .tag{position:absolute;top:12px;right:10px;border:1px solid #ddd;border-radius:2px;font-size:8px;line-height:1;padding:2px 5px;letter-spacing:.2px}
    .cc .meta{font-size:11px;margin-top:5px}
    .cc .thumb{margin-top:8px;height:82px;border-radius:2px;overflow:hidden;background:linear-gradient(135deg,#3a3a3a,#555);display:grid;place-items:center;color:#8a8a8a;font-size:26px}
    .cc .thumb img{width:100%;height:100%;object-fit:cover;display:block}
    .cc .act{display:flex;align-items:center;gap:6px;margin-top:10px}
    .cc .sq{width:27px;height:22px;border:1px solid #ddd;border-radius:3px;background:transparent;color:#fff;display:grid;place-items:center;font-size:13px;cursor:pointer;padding:0}
    .cc .sq:hover{background:#333}
    .cc .del{margin-left:auto;color:#e11d1d;font-size:14px;background:none;border:0;cursor:pointer;padding:0}
    .cc .pill{display:inline-flex;align-items:center;gap:5px;font-size:11px;line-height:1;padding:6px 8px;border-radius:3px;white-space:nowrap}
    .cc .pill.blue{background:#dbeafe;color:#2f7de0}
    .cc .pill.gray{background:#dcdcdc;color:#7a7a7a}
    .cc .pill.dark{background:#6a6a6a;color:#fff}
    .cc .pill.line{background:#2a2a2a;border:1px solid #666;color:#fff;font-size:10px;padding:5px 12px}
    .cc .pill.green{background:#35b765;color:#fff;font-size:11.5px;padding:6px 9px}
    .cc .stack{display:flex;flex-direction:column;align-items:flex-start;gap:7px;margin-top:8px}
    .cc .row2{display:flex;gap:8px;margin-top:8px}
    .cc .row2 .pill{flex:1;justify-content:center}

    /* ================= TAMPILAN CALENDAR VIEW ================= */
    .cc .cal-nav-row{display:flex;align-items:center;justify-content:flex-end;gap:6px;margin-bottom:16px}
    .cc .cal-month-pill{background:#282828;border:1px solid #555;color:#fff;height:38px;padding:0 16px;border-radius:6px;display:inline-flex;align-items:center;gap:8px;font-weight:500;font-size:14px}
    .cc .cal-arrow-btn{background:#282828;border:1px solid #555;color:#fff;width:38px;height:38px;border-radius:6px;display:grid;place-items:center;cursor:pointer;font-size:14px}
    .cc .cal-arrow-btn:hover{background:#3a3a3a}

    .cc .cal-grid-box{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:6px}
    .cc .cal-hdr-day{text-align:left;padding-left:4px;font-weight:600;font-size:12px;color:#999;padding-bottom:10px;letter-spacing:.5px}
    
    .cc .cal-day-cell{background:#202020;border:1px solid #333;border-radius:6px;min-height:115px;padding:10px;display:flex;flex-direction:column;gap:6px}
    .cc .cal-day-cell.dimmed{background:#171717;border-color:#242424;opacity:.45}
    .cc .cal-num{font-size:13px;font-weight:600;color:#777}
    .cc .cal-day-cell:not(.dimmed) .cal-num{color:#ccc}

    /* Kartu Kalender dengan background soft sesuai warna titik status */
    .cc .cal-card-item{border-radius:4px;padding:7px 9px;font-size:12px;cursor:pointer;transition:all .15s;border:1px solid transparent}
    .cc .cal-card-item.status-published { background: rgba(53, 183, 101, 0.18); border-color: rgba(53, 183, 101, 0.4); }
    .cc .cal-card-item.status-scheduled { background: rgba(59, 130, 246, 0.18); border-color: rgba(59, 130, 246, 0.4); }
    .cc .cal-card-item.status-approved  { background: rgba(217, 119, 6, 0.18); border-color: rgba(217, 119, 6, 0.4); }
    .cc .cal-card-item.status-drafting  { background: rgba(136, 136, 136, 0.18); border-color: rgba(136, 136, 136, 0.4); }
    .cc .cal-card-item:hover{filter:brightness(1.2)}
    
    .cc .cal-card-title{font-weight:600;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-bottom:3px}
    .cc .cal-card-sub{display:flex;align-items:center;gap:6px;font-size:11px;color:#ddd}
    .cc .cal-circle{width:6px;height:6px;border-radius:50%;display:inline-block;flex:none}

    .cc .cal-bottom-hint{margin-top:16px;font-size:12px;color:#888;text-align:left}

    @media(max-width:1100px){.cc .board{grid-template-columns:repeat(6,200px)}.cc .board-wrap{overflow-x:auto}}

    /* ================= MODAL: CREATE CONTENT IDEA ================= */
    :root{--ccm-left:260px}
    @media (max-width:1100px){:root{--ccm-left:240px}}
    @media (max-width:768px){:root{--ccm-left:0px}}

    .ccm, .ccm *{box-sizing:border-box}
    .ccm{position:fixed;top:0;right:0;bottom:0;left:var(--ccm-left,0);z-index:9999;display:none;overflow-y:auto;padding:24px;
        background:rgba(0,0,0,.6);-webkit-backdrop-filter:blur(6px);backdrop-filter:blur(6px);
        font-family:'Inter',system-ui,sans-serif;color:#fff;align-items:center;justify-content:center}
    .ccm.is-open{display:flex;animation:ccmFade .18s ease-out}
    @keyframes ccmFade{from{opacity:0}to{opacity:1}}
    body.ccm-lock{overflow:hidden}

    .ccm-dialog{position:relative;margin:auto;width:100%;max-width:720px;background:#242424;border-radius:12px;padding:32px 34px 24px;box-shadow:0 20px 60px rgba(0,0,0,.6)}
    .ccm-close{position:absolute;top:24px;right:26px;width:34px;height:34px;display:grid;place-items:center;background:none;border:0;border-radius:6px;color:#fff;font-size:22px;cursor:pointer;padding:0}
    .ccm-close:hover{background:rgba(255,255,255,.08)}

    .ccm-head h2{margin:0;font-size:22px;font-weight:600;line-height:1.2;color:#fff}
    .ccm-head p{margin:6px 0 0;font-size:14px;color:#aaa}

    .ccm-group{margin-top:20px}
    .ccm-label{display:block;margin-bottom:6px;font-size:13px;font-weight:500;color:#ddd}
    .ccm-label span{color:#e03131}
    .ccm-subtext{display:block;margin-top:6px;font-size:12px;color:#888}

    .ccm-input, .ccm-textarea{display:block;width:100%;border:1px solid #555;border-radius:6px;background:#1a1a1a;color:#fff;font-size:14px;font-family:inherit;outline:none;padding:0 14px}
    .ccm-input{height:46px}
    .ccm-textarea{height:80px;padding:12px 14px;resize:vertical}

    /* Custom Dropdown Platform */
    .ccm-select-wrap{position:relative;border:1px solid #555;border-radius:6px;background:#1a1a1a;cursor:pointer}
    .ccm-select-display{height:46px;display:flex;align-items:center;justify-content:space-between;padding:0 16px;font-size:14px;color:#fff;user-select:none}
    .ccm-select-display i{font-size:16px;color:#aaa;transition:transform .2s}
    .ccm-select-wrap.is-active .ccm-select-display i{transform:rotate(90deg)}

    .ccm-dropdown-list{position:absolute;top:calc(100% + 4px);left:0;right:0;background:#222;border:1px solid #555;border-radius:6px;display:none;z-index:50;box-shadow:0 10px 25px rgba(0,0,0,.5);overflow:hidden}
    .ccm-select-wrap.is-active .ccm-dropdown-list{display:block}
    .ccm-dropdown-item{padding:12px 16px;font-size:14px;color:#fff;cursor:pointer;transition:background .1s}
    .ccm-dropdown-item:hover, .ccm-dropdown-item.selected{background:#a31c1c;color:#fff}

    .ccm-row2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
    .ccm-field-icon{position:relative}
    .ccm-field-icon i{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#888;font-size:16px;pointer-events:none}
    .ccm-field-icon input{padding-left:42px}

    .ccm-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:28px}
    .ccm-btn{height:42px;display:inline-flex;align-items:center;justify-content:center;gap:6px;border-radius:6px;padding:0 18px;font-size:14px;font-weight:500;cursor:pointer}
    .ccm-cancel{background:transparent;border:1px solid #555;color:#fff}
    .ccm-cancel:hover{background:rgba(255,255,255,.08)}
    .ccm-submit{background:#a31c1c;border:1px solid #a31c1c;color:#fff}
    .ccm-submit:hover{background:#c0262b}

    /* ================= MODAL: DETAIL / REVIEW CARD ================= */
    .ccd{position:fixed;top:0;right:0;bottom:0;left:var(--ccm-left,0);z-index:9999;display:none;overflow-y:auto;padding:24px;
        background:rgba(0,0,0,.65);-webkit-backdrop-filter:blur(6px);backdrop-filter:blur(6px);
        font-family:'Inter',system-ui,sans-serif;color:#fff;align-items:center;justify-content:center}
    .ccd.is-open{display:flex;animation:ccmFade .18s ease-out}
    .ccd-dialog{position:relative;margin:auto;width:100%;max-width:820px;background:#1e1e1e;border-radius:12px;padding:32px;box-shadow:0 25px 50px rgba(0,0,0,.7);max-height:90vh;overflow-y:auto}
    .ccd-close{position:absolute;top:24px;right:24px;width:34px;height:34px;display:grid;place-items:center;background:none;border:0;border-radius:6px;color:#fff;font-size:22px;cursor:pointer}
    .ccd-close:hover{background:rgba(255,255,255,.08)}

    .ccd-top-head h2{margin:0;font-size:22px;font-weight:600}
    .ccd-top-meta{margin:6px 0 20px;font-size:13px;color:#aaa}

    .ccd-card-box{background:#141414;border:1px solid #333;border-radius:8px;padding:16px;margin-bottom:12px}
    .ccd-card-box-top{display:flex;align-items:center;justify-content:between;gap:12px}
    .ccd-card-box-icon{width:48px;height:48px;background:#2a2a2a;border-radius:6px;display:grid;place-items:center;font-size:20px;color:#ccc;flex:none}
    .ccd-card-box-info{flex:1;min-width:0}
    .ccd-card-box-info b{display:block;font-size:15px;color:#fff}
    .ccd-card-box-info span{font-size:12px;color:#999}

    .ccd-section-title{font-size:15px;font-weight:600;margin:22px 0 10px;color:#ddd}
    .ccd-history{background:#141414;border:1px solid #333;border-radius:8px;padding:18px;margin-bottom:20px}
    .ccd-history-head{display:flex;align-items:center;gap:10px;margin-bottom:12px}
    .ccd-round-badge{width:26px;height:26px;background:#a31c1c;border-radius:50%;display:grid;place-items:center;font-size:12px;font-weight:600}
    .ccd-badge-status{background:#2a2a2a;color:#ccc;font-size:11px;padding:3px 8px;border-radius:4px}

    .ccd-reason-label{display:block;font-size:13px;color:#bbb;margin-bottom:6px}
    .ccd-textarea{width:100%;height:80px;background:#141414;border:1px solid #444;border-radius:6px;color:#fff;padding:10px;font-size:13px;resize:vertical;outline:none}
    .ccd-textarea:focus{border-color:#a31c1c}

    .ccd-actions{display:flex;align-items:center;justify-content:flex-end;gap:12px;margin-top:20px}
    .ccd-btn-schedule{background:#a31c1c;color:#fff;border:0;border-radius:6px;height:40px;padding:0 18px;font-size:14px;font-weight:500;cursor:pointer;display:inline-flex;align-items:center;gap:6px}
    .ccd-btn-schedule:hover{background:#b82222}
    .ccd-btn-sendback{background:transparent;color:#fff;border:1px solid #555;border-radius:6px;height:40px;padding:0 18px;font-size:14px;font-weight:500;cursor:pointer;display:inline-flex;align-items:center;gap:6px}
    .ccd-btn-sendback:hover{background:rgba(255,255,255,.08)}
</style>

<div class="cc">

    <div class="top">
        <div>
            <h1>Content Calendar</h1>
            <div class="sub">Editorial pipeline from idea to published</div>
        </div>
        <form method="GET" class="month">
            <select name="month" onchange="this.form.submit()">
                @foreach($months as $m)
                    <option value="{{ $m }}" @selected($m === $selectedMonth)>{{ $m }}</option>
                @endforeach
            </select>
            <i class="bi bi-chevron-down"></i>
        </form>
    </div>

    @if($attention > 0)
        <a href="{{ $attentionUrl }}" class="alert">
            <i class="bi bi-exclamation-triangle lead"></i>{{ $attention }} item{{ $attention > 1 ? 's' : '' }} needs attention
            <i class="bi bi-arrow-right go"></i>
        </a>
    @endif

    <div class="panel">
        <div class="panel-head">
            <h2>Content calendar</h2>
            <div class="tools">
                {{-- Tombol Toggle Board & Calendar --}}
                <button type="button" class="tb {{ session('active_view', 'board') === 'board' ? 'on' : '' }}" id="btnViewBoard"><i class="bi bi-layout-three-columns"></i>Board</button>
                <button type="button" class="tb {{ session('active_view', 'board') === 'calendar' ? 'on' : '' }}" id="btnViewCalendar"><i class="bi bi-calendar3"></i>Calendar</button>
                <button type="button" class="tb new js-open-new"><i class="bi bi-plus-lg"></i>New</button>
            </div>
        </div>
        <hr>

        {{-- ================= KANBAN BOARD VIEW ================= --}}
        <div id="boardViewContainer" style="{{ session('active_view', 'board') === 'calendar' ? 'display:none;' : 'display:block;' }}">
            <div class="board-wrap">
            <div class="board" id="kanbanBoard">
                @foreach($columns as $key => $col)
                    @php $items = $grouped->get($key, collect()); @endphp
                    <div class="col" data-column="{{ $key }}">
                        <div class="col-h"><i class="bi {{ $col['icon'] }}"></i>{{ $col['label'] }}<span class="n">{{ $items->count() }}</span></div>
                        <div class="col-b">

                            @if($items->isEmpty() && $key === 'idea')
                                <div class="empty">
                                    <i class="bi bi-lightbulb"></i>
                                    <b>Nothing here yet</b>
                                    <span>Drop a card or click + New to add a new idea.</span>
                                </div>
                            @endif

                            @foreach($items as $c)
                                <div class="card js-open-detail" 
                                     data-id="{{ $c['id'] }}"
                                     data-title="{{ $c['title'] }}"
                                     data-owner="{{ $c['owner'] }}"
                                     data-platform="{{ $c['platform'] ?? 'IG' }}"
                                     data-date="{{ $c['full_date'] ?? '29 September 2026' }}"
                                     data-asset="{{ !empty($c['asset']) ? 'true' : 'false' }}">
                                    <h3>{{ $c['title'] }}</h3>
                                    <span class="tag">{{ $c['platform'] }}</span>
                                    <div class="meta">{{ $c['owner'] }}@if(!empty($c['full_date'])) · {{ $c['full_date'] }}@endif</div>

                                    @unless(!empty($c['draft_empty']))
                                        <div class="thumb">
                                            @if(!empty($c['image']))<img src="{{ $c['image'] }}" alt="{{ $c['title'] }}">@else<i class="bi bi-image"></i>@endif
                                        </div>
                                    @endunless

                                    @switch($key)
                                        @case('drafting')
                                            @if(!empty($c['draft_empty']))
                                                <div class="row2">
                                                    <a href="#" class="pill line">Edit</a>
                                                    <a href="#" class="pill line">+ Add creative</a>
                                                </div>
                                                <div class="stack"><button type="button" class="pill dark">Submit for review</button></div>
                                            @endif
                                            <div class="act">
                                                <button type="button" class="sq js-move-right" title="Move forward"><i class="bi bi-arrow-right"></i></button>
                                                <button type="button" class="del" title="Delete"><i class="bi bi-trash3"></i></button>
                                            </div>
                                            @break

                                        @case('review')
                                            <div class="stack">
                                                @if(!empty($c['asset']))
                                                    <span class="pill blue" style="width:100%"><i class="bi bi-box-arrow-up-right"></i>Full Asset - Master file</span>
                                                @endif
                                                <span class="pill gray">Waiting for manager</span>
                                            </div>
                                            <div class="act">
                                                <span class="pill gray">Review</span>
                                                <button type="button" class="sq js-move-right" title="Move forward"><i class="bi bi-arrow-right"></i></button>
                                            </div>
                                            @break

                                        @case('approved')
                                            <div class="stack"><span class="pill blue"><i class="bi bi-calendar-check"></i>Schedule</span></div>
                                            <div class="act">
                                                <button type="button" class="sq js-move-right" title="Move forward"><i class="bi bi-arrow-right"></i></button>
                                                <button type="button" class="del" title="Delete"><i class="bi bi-trash3"></i></button>
                                            </div>
                                            @break

                                        @case('scheduled')
                                            <div class="act">
                                                <button type="button" class="sq js-move-left" title="Move back"><i class="bi bi-arrow-left"></i></button>
                                                <button type="button" class="pill green js-move-right"><i class="bi bi-arrow-right"></i>Published</button>
                                                <button type="button" class="del" title="Delete"><i class="bi bi-trash3"></i></button>
                                            </div>
                                            @break

                                        @case('published')
                                            <div class="act">
                                                <button type="button" class="sq js-move-left" title="Move back"><i class="bi bi-arrow-left"></i></button>
                                                <button type="button" class="del" title="Delete"><i class="bi bi-trash3"></i></button>
                                            </div>
                                            @break
                                    @endswitch
                                </div>
                            @endforeach

                        </div>
                    </div>
                @endforeach
            </div>
            </div>
        </div>

        {{-- ================= CALENDAR VIEW (DINAMIS DENGAN TOMBOL NAVIGASI BULAN) ================= --}}
        <div id="calendarViewContainer" style="{{ session('active_view', 'board') === 'calendar' ? 'display:block;' : 'display:none;' }}">
            <div class="cal-nav-row">
                <div class="cal-month-pill" id="currentCalendarMonth"><i class="bi bi-calendar"></i> September 2026</div>
                <button type="button" class="cal-arrow-btn" id="prevMonthBtn"><i class="bi bi-chevron-left"></i></button>
                <button type="button" class="cal-arrow-btn" id="nextMonthBtn"><i class="bi bi-chevron-right"></i></button>
            </div>

            <div class="cal-grid-box" id="calendarGridDays">
                {{-- Baris Header Hari --}}
                <div class="cal-hdr-day">MON</div>
                <div class="cal-hdr-day">TUE</div>
                <div class="cal-hdr-day">WED</div>
                <div class="cal-hdr-day">THU</div>
                <div class="cal-hdr-day">FRI</div>
                <div class="cal-hdr-day">SAT</div>
                <div class="cal-hdr-day">SUN</div>
                {{-- Tanggal akan diisi secara dinamis lewat script JavaScript --}}
            </div>
            <div class="cal-bottom-hint">Only scheduled items appear here. Ideas without a date live on the board.</div>
        </div>
    </div>

</div>

{{-- ================= MODAL: CREATE CONTENT IDEA ================= --}}
<div class="ccm" id="createModal" aria-hidden="true">
    <form class="ccm-dialog" id="createForm" method="POST" action="{{ $createAction }}" novalidate role="dialog" aria-modal="true">
        @csrf
        <button type="button" class="ccm-close" data-close aria-label="Close"><i class="bi bi-x-lg"></i></button>
        <div class="ccm-head">
            <h2>Create content idea</h2>
            <p>Add an idea to your content workflow.</p>
        </div>
        <div class="ccm-group">
            <label class="ccm-label" for="contentTitle">Content title <span>*</span></label>
            <input type="text" class="ccm-input" id="contentTitle" name="title" placeholder="e.g. October product teaser" autocomplete="off" required>
        </div>
        
        <div class="ccm-group">
            <label class="ccm-label">Platform <span>*</span></label>
            <div class="ccm-select-wrap" id="platformSelectWrap">
                <div class="ccm-select-display" id="platformDisplay">
                    <span id="platformText">Instagram</span>
                    <i class="bi bi-chevron-right"></i>
                </div>
                <div class="ccm-dropdown-list" id="platformDropdown">
                    <div class="ccm-dropdown-item selected" data-value="Instagram">Instagram</div>
                    <div class="ccm-dropdown-item" data-value="TikTok">Tiktok</div>
                    <div class="ccm-dropdown-item" data-value="YouTube">Youtube</div>
                    <div class="ccm-dropdown-item" data-value="Facebook">Facebook</div>
                    <div class="ccm-dropdown-item" data-value="X">X</div>
                </div>
                <input type="hidden" name="platform" id="platformInput" value="Instagram">
            </div>
        </div>

        <div class="ccm-group">
            <label class="ccm-label" for="contentDesc">Content description <i>(optional)</i></label>
            <textarea class="ccm-textarea" id="contentDesc" name="description" placeholder="Describe the content outline..."></textarea>
        </div>
        <div class="ccm-row2">
            <div class="ccm-group">
                <label class="ccm-label" for="contentOwner">Owner</label>
                <div class="ccm-select-wrap" id="ownerSelectWrap" style="border:1px solid #555; border-radius:6px; background:#1a1a1a;">
                    <div class="ccm-select-display" id="ownerDisplay">
                        <span id="ownerText" style="color:#888;">Select team member</span>
                        <i class="bi bi-chevron-right" style="font-size:14px; color:#aaa;"></i>
                    </div>
                    <div class="ccm-dropdown-list" id="ownerDropdown">
                        <div class="ccm-dropdown-item" data-value="">Select team member</div>
                        <div class="ccm-dropdown-item" data-value="Bella">Bella</div>
                        <div class="ccm-dropdown-item" data-value="Jason">Jason</div>
                        <div class="ccm-dropdown-item" data-value="Reinhart">Reinhart</div>
                        <div class="ccm-dropdown-item" data-value="Michelle">Michelle</div>
                        <div class="ccm-dropdown-item" data-value="Jodie">Jodie</div>
                        <div class="ccm-dropdown-item" data-value="Kevin">Kevin</div>
                    </div>
                    <input type="hidden" name="owner" id="ownerInput" value="">
                </div>
            </div>
            <div class="ccm-group">
                <label class="ccm-label" for="contentDate">Target publish date <i>(optional)</i></label>
                <div class="ccm-field-icon">
                    <i class="bi bi-calendar"></i>
                    <input type="date" class="ccm-input" id="contentDate" name="date">
                </div>
            </div>
        </div>
        <div class="ccm-actions">
            <button type="button" class="ccm-btn ccm-cancel" data-close>Cancel</button>
            <button type="submit" class="ccm-btn ccm-submit">+ Add to board</button>
        </div>
    </form>
</div>

{{-- ================= MODAL: DETAIL / REVIEW CARD ================= --}}
<div class="ccd" id="detailModal" aria-hidden="true">
    <div class="ccd-dialog" role="dialog" aria-modal="true">
        <button type="button" class="ccd-close" data-close-detail aria-label="Close"><i class="bi bi-x-lg"></i></button>

        <div class="ccd-top-head">
            <h2 id="detTitle">Partnership Announcement</h2>
            <div class="ccd-top-meta" id="detMeta">Michelle · IG · 29 September 2026</div>
        </div>

        <div class="ccd-card-box">
            <div class="ccd-card-box-top" style="display:flex; align-items:center; gap:12px;">
                <div class="ccd-card-box-icon"><i class="bi bi-image"></i></div>
                <div class="ccd-card-box-info">
                    <b id="detBoxTitle">Partnership Announcement</b>
                    <span id="detBoxSub">Michelle · 23 Sept, 19:00</span>
                </div>
            </div>
        </div>

        <div class="ccd-card-box" id="detAssetBox">
            <div class="ccd-card-box-top" style="display:flex; align-items:center; gap:12px;">
                <div class="ccd-card-box-icon"><i class="bi bi-box-arrow-up-right"></i></div>
                <div class="ccd-card-box-info">
                    <b style="color:#3b82f6;">Full asset — master file</b>
                    <span>drive.google.com</span>
                </div>
            </div>
        </div>

        <div class="ccd-section-title"><i class="bi bi-clock-history"></i> Review history</div>
        <div class="ccd-history">
            <div class="ccd-history-head">
                <div class="ccd-round-badge">1</div>
                <b>Round 1</b>
                <span class="ccd-badge-status">Waiting for a manager</span>
                <span style="margin-left:auto; font-size:12px; color:#888;" id="detHistoryDate">Submitted by Michelle · 23 Sept, 19:00</span>
            </div>
            <p style="font-size:13px; color:#aaa; margin-bottom:12px;">Copy and visual approved by the partner. Ready for your review.</p>
            
            <div class="ccd-card-box" style="background:#1e1e1e; margin-bottom:8px;">
                <div style="display:flex; align-items:center; gap:12px;">
                    <div style="width:36px; height:36px; background:#2a2a2a; border-radius:4px; display:grid; place-items:center;"><i class="bi bi-image"></i></div>
                    <div>
                        <b style="font-size:13px;" id="detHistCardTitle">Partnership Announcement</b>
                        <span style="font-size:11px; color:#888;">Michelle · 23 Sept, 19:00</span>
                    </div>
                </div>
            </div>
        </div>

        <label class="ccd-reason-label" for="detReason">Reason, if you are sending this back</label>
        <textarea class="ccd-textarea" id="detReason" placeholder="Add a reason..."></textarea>
        <span style="display:block; text-align:right; font-size:11px; color:#777; margin-top:4px;">0/500</span>

        <form method="POST" action="{{ $scheduleAction }}" id="scheduleForm" style="display:inline;">
            @csrf
            <div class="ccd-actions">
                <button type="submit" class="ccd-btn-schedule"><i class="bi bi-calendar-check"></i>Schedule</button>
                <button type="button" class="ccd-btn-sendback" id="btnSendBack"><i class="bi bi-send"></i>Send back</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Toggle View Board vs Calendar
    var btnBoard = document.getElementById('btnViewBoard');
    var btnCalendar = document.getElementById('btnViewCalendar');
    var boardContainer = document.getElementById('boardViewContainer');
    var calendarContainer = document.getElementById('calendarViewContainer');

    if (btnBoard && btnCalendar) {
        btnBoard.addEventListener('click', function () {
            btnBoard.classList.add('on');
            btnCalendar.classList.remove('on');
            boardContainer.style.display = 'block';
            calendarContainer.style.display = 'none';
        });

        btnCalendar.addEventListener('click', function () {
            btnCalendar.classList.add('on');
            btnBoard.classList.remove('on');
            calendarContainer.style.display = 'block';
            boardContainer.style.display = 'none';
        });
    }

    // Dynamic Calendar Month Navigation
    const monthsList = [
        { name: "July 2026", year: 2026, month: 6 },
        { name: "August 2026", year: 2026, month: 7 },
        { name: "September 2026", year: 2026, month: 8 },
        { name: "October 2026", year: 2026, month: 9 }
    ];
    let currentMonthIndex = 2; // Mulai di September 2026

    // Contoh data sampel event berdasarkan bulan & tanggal
    const sampleEvents = {
        "September 2026": {
            2: [{ title: "September Promo Launch", owner: "Jodie", platform: "TT", time: "10:00 Published", statusClass: "status-published", dotColor: "#35b765" }],
            4: [{ title: "Weekend Campaign Reel", owner: "Kevin", platform: "TT", time: "14:00 Scheduled", statusClass: "status-scheduled", dotColor: "#3b82f6" }],
            7: [{ title: "Partnership Announcement", owner: "Michelle", platform: "IG", time: "11:00 Drafting", statusClass: "status-drafting", dotColor: "#888" }],
            8: [{ title: "Market Open Short Film", owner: "Jason", platform: "YT", time: "09:00 Published", statusClass: "status-published", dotColor: "#35b765" }],
            10: [{ title: "Trading Psychology Podcast — Ep. 4", owner: "Jason", platform: "TT", time: "Published", statusClass: "status-published", dotColor: "#35b765" }],
            11: [{ title: "Acquisition Campaign Creative", owner: "Jodie", platform: "TT", time: "13:00 Approved", statusClass: "status-approved", dotColor: "#d97706" }]
        },
        "October 2026": {
            16: [{ title: "October Teaser Series", owner: "Bella", platform: "TT", time: "10:00 Drafting", statusClass: "status-drafting", dotColor: "#888" }],
            17: [{ title: "Analyst Interview Rupiah Outlook", owner: "Jason", platform: "TT", time: "14:00 Drafting", statusClass: "status-drafting", dotColor: "#888" }],
            24: [{ title: "Project Dashboard", owner: "Reinhart", platform: "TT", time: "10:00 Drafting", statusClass: "status-drafting", dotColor: "#888" }],
            27: [{ title: "October Campaign Shoot Package", owner: "Jason", platform: "TT", time: "09:00 Published", statusClass: "status-published", dotColor: "#35b765" }]
        }
    };

    function renderCalendar() {
        const currentM = monthsList[currentMonthIndex];
        document.getElementById('currentCalendarMonth').innerHTML = `<i class="bi bi-calendar"></i> ${currentM.name}`;

        const gridBox = document.getElementById('calendarGridDays');
        // Pertahankan header hari (7 elemen pertama)
        const headersHTML = `
            <div class="cal-hdr-day">MON</div>
            <div class="cal-hdr-day">TUE</div>
            <div class="cal-hdr-day">WED</div>
            <div class="cal-hdr-day">THU</div>
            <div class="cal-hdr-day">FRI</div>
            <div class="cal-hdr-day">SAT</div>
            <div class="cal-hdr-day">SUN</div>
        `;

        // Kalkulasi hari dalam bulan
        const firstDayIndex = new Date(currentM.year, currentM.month, 1).getDay();
        // Konversi ke format Senin (0 = Senin, ..., 6 = Minggu)
        const jsFirstDay = (firstDayIndex === 0) ? 6 : firstDayIndex - 1;
        const totalDays = new Date(currentM.year, currentM.month + 1, 0).getDate();
        const prevMonthDays = new Date(currentM.year, currentM.month, 0).getDate();

        let daysHTML = headersHTML;
        const monthEvents = sampleEvents[currentM.name] || {};

        // Hari dari bulan sebelumnya (trailing)
        for (let i = jsFirstDay - 1; i >= 0; i--) {
            let dayNum = prevMonthDays - i;
            daysHTML += `<div class="cal-day-cell dimmed"><div class="cal-num">${dayNum}</div></div>`;
        }

        // Hari di bulan aktif
        for (let d = 1; d <= totalDays; d++) {
            let eventsHtml = '';
            if (monthEvents[d]) {
                monthEvents[d].forEach(ev => {
                    eventsHtml += `
                        <div class="cal-card-item ${ev.statusClass} js-open-detail" 
                             data-title="${ev.title}" data-owner="${ev.owner}" data-platform="${ev.platform}" data-date="${d} ${currentM.name}" data-asset="false">
                            <div class="cal-card-title">${ev.title}</div>
                            <div class="cal-card-sub"><span class="cal-circle" style="background:${ev.dotColor};"></span> ${ev.time}</div>
                        </div>
                    `;
                });
            }
            daysHTML += `
                <div class="cal-day-cell">
                    <div class="cal-num">${d}</div>
                    ${eventsHtml}
                </div>
            `;
        }

        // Hari di awal bulan berikutnya (leading untuk menggenapi grid)
        const totalCellsSoFar = jsFirstDay + totalDays;
        const remainingCells = (totalCellsSoFar % 7 === 0) ? 0 : 7 - (totalCellsSoFar % 7);
        for (let n = 1; n <= remainingCells; n++) {
            daysHTML += `<div class="cal-day-cell dimmed"><div class="cal-num">${n}</div></div>`;
        }

        gridBox.innerHTML = daysHTML;

        // Re-attach event listener untuk modal detail pada kartu yang baru dirender
        gridBox.querySelectorAll('.js-open-detail').forEach(function (card) {
            card.addEventListener('click', function (e) {
                if (e.target.closest('button') || e.target.closest('a')) return;
                openDetailModal(card.dataset);
            });
        });
    }

    document.getElementById('prevMonthBtn').addEventListener('click', function() {
        if (currentMonthIndex > 0) {
            currentMonthIndex--;
            renderCalendar();
        }
    });

    document.getElementById('nextMonthBtn').addEventListener('click', function() {
        if (currentMonthIndex < monthsList.length - 1) {
            currentMonthIndex++;
            renderCalendar();
        }
    });

    // Jalankan render awal saat halaman dimuat
    renderCalendar();

    // Modal Create Idea
    var createModal = document.getElementById('createModal');
    if (createModal) {
        document.body.appendChild(createModal);
        var inputTitle = document.getElementById('contentTitle');

        function openCreate() {
            createModal.classList.add('is-open');
            createModal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('ccm-lock');
            setTimeout(function () { inputTitle.focus(); }, 50);
        }
        function closeCreate() {
            createModal.classList.remove('is-open');
            createModal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('ccm-lock');
        }

        document.querySelectorAll('.js-open-new').forEach(function (btn) {
            btn.addEventListener('click', function (e) { e.preventDefault(); openCreate(); });
        });
        createModal.querySelectorAll('[data-close]').forEach(function (b) { b.addEventListener('click', closeCreate); });
        createModal.addEventListener('mousedown', function (e) { if (e.target === createModal) closeCreate(); });
    }

    // Custom Dropdown Handler
    function setupCustomSelect(wrapId, displayId, textId, inputId, dropdownId) {
        var wrap = document.getElementById(wrapId);
        var display = document.getElementById(displayId);
        var text = document.getElementById(textId);
        var input = document.getElementById(inputId);
        var dropdown = document.getElementById(dropdownId);
        if (!wrap) return;

        display.addEventListener('click', function (e) {
            e.stopPropagation();
            document.querySelectorAll('.ccm-select-wrap').forEach(function(w){
                if(w !== wrap) w.classList.remove('is-active');
            });
            wrap.classList.toggle('is-active');
        });

        dropdown.querySelectorAll('.ccm-dropdown-item').forEach(function (item) {
            item.addEventListener('click', function (e) {
                e.stopPropagation();
                var val = item.getAttribute('data-value');
                text.textContent = item.textContent;
                if(val === "") {
                    text.style.color = "#888";
                } else {
                    text.style.color = "#fff";
                }
                input.value = val;

                dropdown.querySelectorAll('.ccm-dropdown-item').forEach(function (el) {
                    el.classList.remove('selected');
                });
                item.classList.add('selected');
                wrap.classList.remove('is-active');
            });
        });
    }

    setupCustomSelect('platformSelectWrap', 'platformDisplay', 'platformText', 'platformInput', 'platformDropdown');
    setupCustomSelect('ownerSelectWrap', 'ownerDisplay', 'ownerText', 'ownerInput', 'ownerDropdown');

    document.addEventListener('click', function () {
        document.querySelectorAll('.ccm-select-wrap').forEach(function (w) {
            w.classList.remove('is-active');
        });
    });

    // Modal Detail / Review Card Helper
    var detailModal = document.getElementById('detailModal');
    function openDetailModal(data) {
        if (!detailModal) return;
        document.getElementById('detTitle').textContent = data.title;
        document.getElementById('detMeta').textContent = data.owner + ' · ' + data.platform + ' · ' + data.date;
        document.getElementById('detBoxTitle').textContent = data.title;
        document.getElementById('detBoxSub').textContent = data.owner + ' · 23 Sept, 19:00';
        document.getElementById('detHistCardTitle').textContent = data.title;
        
        var assetBox = document.getElementById('detAssetBox');
        if (data.asset === 'true') {
            assetBox.style.display = 'block';
        } else {
            assetBox.style.display = 'none';
        }

        detailModal.classList.add('is-open');
        detailModal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('ccm-lock');
    }

    if (detailModal) {
        document.body.appendChild(detailModal);

        function closeDetail() {
            detailModal.classList.remove('is-open');
            detailModal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('ccm-lock');
        }

        document.querySelectorAll('.js-open-detail').forEach(function (card) {
            card.addEventListener('click', function (e) {
                if (e.target.closest('button') || e.target.closest('a')) return;
                openDetailModal(card.dataset);
            });
        });

        detailModal.querySelectorAll('[data-close-detail]').forEach(function (b) { b.addEventListener('click', closeDetail); });
        detailModal.addEventListener('mousedown', function (e) { if (e.target === detailModal) closeDetail(); });
    }

    // Pindahkan Kartu Antar Kolom Menggunakan Tombol Panah (Left / Right)
    var columnsOrder = ['idea', 'drafting', 'review', 'approved', 'scheduled', 'published'];

    document.querySelectorAll('.js-move-right').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            var card = btn.closest('.card');
            var currentCol = card.closest('.col');
            var currentKey = currentCol.getAttribute('data-column');
            var currentIndex = columnsOrder.indexOf(currentKey);

            if (currentIndex !== -1 && currentIndex < columnsOrder.length - 1) {
                var nextKey = columnsOrder[currentIndex + 1];
                var nextColBody = document.querySelector('.col[data-column="' + nextKey + '"] .col-b');
                
                var emptyPlaceholder = nextColBody.querySelector('.empty');
                if (emptyPlaceholder) emptyPlaceholder.remove();

                nextColBody.appendChild(card);
                updateCounts();
            }
        });
    });

    document.querySelectorAll('.js-move-left').forEach(function (btn) {
        btn.button.addEventListener('click', function (e) {
            e.stopPropagation();
            var card = btn.closest('.card');
            var currentCol = card.closest('.col');
            var currentKey = currentCol.getAttribute('data-column');
            var currentIndex = columnsOrder.indexOf(currentKey);

            if (currentIndex > 0) {
                var prevKey = columnsOrder[currentIndex - 1];
                var prevColBody = document.querySelector('.col[data-column="' + prevKey + '"] .col-b');
                
                prevColBody.appendChild(card);
                updateCounts();
            }
        });
    });

    function updateCounts() {
        columnsOrder.forEach(function (key) {
            var col = document.querySelector('.col[data-column="' + key + '"]');
            var countSpan = col.querySelector('.col-h .n');
            var cardsCount = col.querySelectorAll('.card').length;
            countSpan.textContent = cardsCount;

            var colBody = col.querySelector('.col-b');
            if (key === 'idea' && cardsCount === 0 && !colBody.querySelector('.empty')) {
                var emptyDiv = document.createElement('div');
                emptyDiv.className = 'empty';
                emptyDiv.innerHTML = '<i class="bi bi-lightbulb"></i><b>Nothing here yet</b><span>Drop a card or click + New to add a new idea.</span>';
                colBody.insertBefore(emptyDiv, colBody.firstChild);
            }
        });
    }

    // Global ESC key to close any open modal
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.ccm.is-open, .ccd.is-open').forEach(function (m) {
                m.classList.remove('is-open');
                m.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('ccm-lock');
            });
        }
    });
});
</script>
@endsection