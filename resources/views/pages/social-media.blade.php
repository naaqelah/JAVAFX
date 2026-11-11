{{-- resources/views/performance/social-media.blade.php --}}
@extends('layouts.app')
 
@section('title', 'Social Media | Java Global Futures')

@php
    $period        = $period ?? 'August 2026';
    $selectedMonth = $selectedMonth ?? 'October 2026';
    $months        = $months ?? ['October 2026', 'September 2026', 'August 2026', 'July 2026'];
    $attention     = $attention ?? 1;
 
    // URL tujuan form "Connect" (POST). Kirim dari controller: ->with('connectAction', route('...'))
    $connectAction = $connectAction ?? '';
 
    $kpis = $kpis ?? [
        ['label' => 'Audience',   'value' => '100.480',   'delta' => '+4.2%', 'icon' => 'bi-people'],
        ['label' => 'Impression', 'value' => '1.764.000', 'delta' => '+6.1%', 'icon' => 'bi-bar-chart'],
        ['label' => 'Engagement', 'value' => '5.47%',     'delta' => '+0.8%', 'icon' => 'bi-graph-up'],
    ];
    $channels = $channels ?? [
        ['name' => 'Instagram', 'handle' => '@javafx.id',      'icon' => 'bi-instagram', 'tracked' => true,  'audience' => '50.540', 'growth' => '+3.8%'],
        ['name' => 'TikTok',    'handle' => '@javafx.id',      'icon' => 'bi-tiktok',    'tracked' => true,  'audience' => '36.260', 'growth' => '+7.9%'],
        ['name' => 'Youtube',   'handle' => '@JavaFxOfficial', 'icon' => 'bi-youtube',   'tracked' => true,  'audience' => '13.680', 'growth' => '+4.0%'],
        ['name' => 'Facebook',  'handle' => null,              'icon' => 'bi-facebook',  'tracked' => false, 'connect_url' => '#', 'kind' => 'Page',    'example' => 'https://facebook.com'],
        ['name' => 'X',         'handle' => null,              'icon' => 'bi-twitter-x', 'tracked' => false, 'connect_url' => '#', 'kind' => 'profile', 'example' => 'https://x.com'],
    ];
    $metricRows = [
        ['key' => 'impressions', 'label' => 'Impressions', 'icon' => 'bi-eye'],
        ['key' => 'reach',       'label' => 'Reach',       'icon' => 'bi-bar-chart-fill'],
        ['key' => 'engagement',  'label' => 'Engagement',  'icon' => 'bi-heart'],
        ['key' => 'post',        'label' => 'Post',        'icon' => 'bi-file-earmark-text'],
    ];
@endphp
 
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap">

<style>
    .smp, .smp *{box-sizing:border-box}
    .smp{font-family:'Inter',system-ui,sans-serif;color:#fff;font-size:14px;line-height:1.4;padding:18px 0 40px; max-width: 1440px; margin: 0 auto;}
    .smp h1,.smp h2,.smp p,.smp b{margin:0;font-family:inherit}
    .smp a{text-decoration:none}
 
    /* judul + filter bulan */
    .smp .top{display:flex;justify-content:space-between;align-items:flex-start;gap:16px;margin-bottom:34px}
    .smp .top h1{font-size:18px;font-weight:600;line-height:1.2;color:#fff;margin-bottom:6px}
    .smp .top .sub{font-size:13px;font-weight:400;color:#a1a1aa}
    .smp .month{position:relative}
    .smp .month select{appearance:none;-webkit-appearance:none;background:#161616;color:#fff;border:1px solid #a31c1c;border-radius:6px;
        height:40px;padding:0 48px 0 16px;font:500 13px 'Inter',sans-serif;cursor:pointer;min-width:180px}
    .smp .month i{position:absolute;right:16px;top:50%;transform:translateY(-50%);pointer-events:none;font-size:13px;color:#a1a1aa}
 
    /* banner */
    .smp .alert{display:flex;align-items:center;gap:10px;background:#a31c1c;border-radius:6px;height:48px;padding:0 20px;font-size:15px;font-weight:500;margin-bottom:32px}
    .smp .alert i{font-size:20px}
 
    /* panel */
    .smp .panel-wrap{container-type:inline-size}
    .smp .panel{--u:clamp(11px,1.1cqw,13px);font-size:var(--u);background:#222;border-radius:10px;padding:calc(var(--u)*1.9) calc(var(--u)*1.9) calc(var(--u)*2.3); border:1px solid #2e2e33;}
    .smp .panel-head{display:flex;flex-wrap:nowrap;justify-content:space-between;align-items:center;gap:calc(var(--u)*2);margin-bottom:calc(var(--u)*2.2)}
    .smp .panel-head .hl{flex:1 1 0;min-width:0}
    .smp .panel-head h2{font-size:calc(var(--u)*1.3);font-weight:600;margin-bottom:calc(var(--u)*0.6); color:#f4f4f5;}
    .smp .panel-head p{font-size:calc(var(--u)*1.1);font-weight:400; color:#a1a1aa;}
 
    .smp .kpis{display:flex;gap:calc(var(--u)*.8);flex:0 0 min(60%,660px);min-width:0}
    .smp .kpi{flex:1 1 0;min-width:0;display:flex;align-items:center;gap:calc(var(--u)*.9);background:#141414;border:1px solid #2e2e33;border-radius:6px;padding:calc(var(--u)*.7) calc(var(--u)*.9);min-height:calc(var(--u)*4.8)}
    .smp .kpi>div:last-child{min-width:0}
    .smp .kpi .ico{width:calc(var(--u)*2.2);height:calc(var(--u)*2.2);border-radius:5px;background:#a31c1c;display:grid;place-items:center;font-size:calc(var(--u)*1.15);flex:none;align-self:flex-start;margin-top:calc(var(--u)*.3)}
    .smp .kpi .lbl{font-size:var(--u);color:#a1a1aa;display:flex;gap:4px;align-items:center;white-space:nowrap}
    .smp .kpi .lbl i{font-size:calc(var(--u)*.7)}
    .smp .kpi b{display:block;font-size:calc(var(--u)*1.4);font-weight:600;line-height:1.2;white-space:nowrap;color:#f4f4f5;}
    .smp .kpi .d{font-size:calc(var(--u)*.8);color:#a1a1aa;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .smp .kpi .d em{font-style:normal;color:#22c985;font-weight:600}
 
    /* kartu channel: 5 sejajar di desktop */
    .smp .channels{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:calc(var(--u)*2)}
    .smp .ch{min-width:0;background:#1a1a1a;border:1px solid #2e2e33;border-radius:8px;padding:calc(var(--u)*.95) calc(var(--u)*1);min-height:calc(var(--u)*21.8);display:flex;flex-direction:column;box-shadow:0 0 6px rgba(0,0,0,.2)}
    .smp .ch-head{display:flex;align-items:center;gap:calc(var(--u)*.8);padding-bottom:calc(var(--u)*1.1);border-bottom:1px solid #2e2e33;min-height:calc(var(--u)*6)}
    .smp .ch-logo{width:calc(var(--u)*3.55);height:calc(var(--u)*3.55);border-radius:6px;background:#3d3d44;display:grid;place-items:center;font-size:calc(var(--u)*1.7);flex:none;color:#fff}
    .smp .ch-name{flex:1 1 0;min-width:0;font-size:calc(var(--u)*1.15);font-weight:600;line-height:1.35;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;color:#f4f4f5;}
    .smp .ch-name small{display:block;font-size:calc(var(--u)*1.05);font-weight:400;color:#a1a1aa;overflow:hidden;text-overflow:ellipsis}
    .smp .growth{align-self:flex-start;font-size:calc(var(--u)*.8);color:#22c985;border:1px solid rgba(34,201,133,.3);background:rgba(34,201,133,.08);border-radius:3px;padding:1px calc(var(--u)*.5);white-space:nowrap;flex:none}
    .smp .growth i{margin-right:2px;font-size:calc(var(--u)*.8)}
    .smp .aud{padding:calc(var(--u)*.6) 0 calc(var(--u)*.8);border-bottom:1px solid #2e2e33;margin-bottom:calc(var(--u)*1.1)}
    .smp .aud small{display:block;font-size:calc(var(--u)*1.05);color:#a1a1aa;}
    .smp .aud b{font-size:calc(var(--u)*1.6);font-weight:700;color:#f4f4f5;}
    .smp .row-m{display:flex;align-items:center;gap:calc(var(--u)*.9);font-size:var(--u);margin-bottom:calc(var(--u)*.95);color:#a1a1aa;}
    .smp .row-m i{font-size:calc(var(--u)*1.25);width:calc(var(--u)*1.25);text-align:center}
    .smp .row-m .v{margin-left:auto;font-weight:600;color:#f4f4f5;}
 
    .smp .ch.off .ch-head{min-height:0;padding-bottom:calc(var(--u)*.9)}
    .smp .off-body{flex:1;display:flex;flex-direction:column;align-items:center;text-align:center;padding-top:calc(var(--u)*1.1)}
    .smp .off-ico{width:calc(var(--u)*4.3);height:calc(var(--u)*4.3);border-radius:50%;background:#2e2e33;display:grid;place-items:center;font-size:calc(var(--u)*2);margin-bottom:calc(var(--u)*1.7);color:#a1a1aa;}
    .smp .off-body b{font-size:var(--u);font-weight:600;margin-bottom:2px;color:#f4f4f5;}
    .smp .off-body p{font-size:calc(var(--u)*.95);line-height:1.35;margin-bottom:calc(var(--u)*1.1);color:#a1a1aa;}
    
    .smp .btn-connect{margin-top:auto;display:flex;align-items:center;justify-content:center;gap:6px;width:calc(100% - var(--u)*2);background:#a31c1c;color:#fff;border-radius:4px;font-size:calc(var(--u)*1.1);font-weight:600;height:calc(var(--u)*2.6);white-space:nowrap;overflow:hidden;cursor:pointer;border:0;}
    .smp .btn-connect:hover{background:#8f1717;color:#fff}
    .smp .btn-connect i{font-size:calc(var(--u)*1.3)}
 
    /* catatan */
    .smp .note{display:flex;gap:10px;margin-top:32px;padding:16px 20px;background:#1a1a1d;border:1px solid #2e2e33;border-radius:8px;font-size:13px;line-height:1.5;color:#a1a1aa;}
    .smp .note i{font-size:16px;color:#60a5fa;flex-shrink:0;margin-top:1px;}
    .smp .note b{display:block;font-size:13px;font-weight:600;margin-bottom:2px;color:#f4f4f5;}
    .smp .note p{line-height:1.4}
 
    /* ================= RESPONSIVE / MOBILE OPTIMIZATIONS ================= */
    @media(max-width: 1200px) {
        .smp .channels { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    }

    @media(max-width: 900px) {
        .smp .channels { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media(max-width: 768px) {
        .smp { padding: 12px 12px 30px; }
        .smp .top { flex-direction: column; align-items: stretch; gap: 12px; margin-bottom: 24px; }
        .smp .month select { width: 100%; min-width: 0; }
        .smp .panel-wrap { overflow-x: visible; }
        .smp .panel { --u: 13px; min-width: 0; padding: 16px 14px; }
        .smp .panel-head { flex-direction: column; align-items: stretch; gap: 16px; margin-bottom: 20px; }
        .smp .kpis { flex: none; width: 100%; display: grid; grid-template-columns: 1fr; gap: 10px; }
        .smp .kpi { min-height: auto; padding: 12px; }
        .smp .channels { grid-template-columns: 1fr; gap: 14px; }
        .smp .ch { min-height: auto; padding: 16px; }
        .smp .btn-connect { width: 100%; height: 40px; font-size: 13px; }
        .smp .note { padding: 14px 16px; margin-top: 24px; }
    }
 
    /* ================= MODAL CONNECT (COMPACT) ================= */
    :root{--smpm-left:260px}
    @media (max-width:1100px){:root{--smpm-left:240px}}
    @media (max-width:768px){:root{--smpm-left:0px}}
 
    .smpm, .smpm *{box-sizing:border-box}
    .smpm{position:fixed;top:0;right:0;bottom:0;left:var(--smpm-left,0);z-index:9999;display:none;overflow-y:auto;padding:20px;
        background:rgba(0,0,0,.6);-webkit-backdrop-filter:blur(6px);backdrop-filter:blur(6px);
        font-family:'Inter',system-ui,sans-serif;color:#f4f4f5;align-items:center;justify-content:center}
    .smpm.is-open{display:flex;animation:smpmFade .18s ease-out}
    @keyframes smpmFade{from{opacity:0}to{opacity:1}}
    body.smpm-lock{overflow:hidden}
 
    .smpm-dialog{position:relative;margin:auto;width:100%;max-width:540px;background:#1a1a1d;border:1px solid #2e2e33;border-radius:16px;padding:24px;box-shadow:0 20px 50px rgba(0,0,0,.5)}
    .smpm-close{position:absolute;top:18px;right:20px;width:32px;height:32px;display:grid;place-items:center;background:none;border:0;border-radius:8px;color:#a1a1aa;font-size:18px;cursor:pointer;padding:0}
    .smpm-close:hover{background:rgba(255,255,255,.08);color:#fff}
 
    .smpm-head{display:flex;gap:14px;align-items:flex-start;margin-bottom:20px}
    .smpm-logo{width:44px;height:44px;flex:none;border-radius:8px;background:#222226;border:1px solid #2e2e33;display:grid;place-items:center;font-size:22px;color:#fff}
    .smpm-head h2{margin:0 0 4px;font-size:18px;font-weight:600;color:#f4f4f5;padding-right:30px}
    .smpm-head p{margin:0;font-size:13px;line-height:1.4;color:#a1a1aa}
 
    .smpm-label{display:block;margin-bottom:8px;font-size:13px;font-weight:500;color:#d4d4d8}
    .smpm-field{position:relative;margin-bottom:6px}
    .smpm-field i{position:absolute;left:14px;top:50%;transform:translateY(-50%);font-size:16px;color:#a1a1aa;pointer-events:none}
    .smpm-input{display:block;width:100%;height:44px;border:1px solid #2e2e33;border-radius:8px;background:#222226;color:#f4f4f5;padding:0 14px 0 42px;font-size:13px;font-family:inherit;outline:none}
    .smpm-input::placeholder{color:#71717a}
    .smpm-input:focus{border-color:#a31c1c}
    .smpm-field.is-invalid .smpm-input{border-color:#e03131}
    .smpm-error{display:none;margin-top:4px;font-size:12px;color:#ff8787}
    .smpm-field.is-invalid + .smpm-error{display:block}
 
    .smpm-info{display:flex;gap:12px;margin-top:16px;padding:14px;background:#222226;border:1px solid #2e2e33;border-radius:8px;color:#d4d4d8}
    .smpm-info>i{font-size:16px;color:#60a5fa;line-height:1.2;margin-top:1px}
    .smpm-info b{display:block;font-size:13px;font-weight:600;margin-bottom:2px;color:#f4f4f5}
    .smpm-info p{margin:0;font-size:12px;line-height:1.4;color:#a1a1aa}
    .smpm-info a{color:#60a5fa;text-decoration:none}
    .smpm-info a:hover{text-decoration:underline}
 
    .smpm-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:24px}
    .smpm-btn{height:40px;display:inline-flex;align-items:center;justify-content:center;gap:6px;border-radius:8px;padding:0 16px;font-size:13px;font-weight:600;font-family:inherit;cursor:pointer}
    .smpm-cancel{background:transparent;border:1px solid #2e2e33;color:#a1a1aa}
    .smpm-cancel:hover{background:rgba(255,255,255,.08);color:#fff}
    .smpm-submit{min-width:120px;background:#a31c1c;border:1px solid #a31c1c;color:#fff}
    .smpm-submit:hover{background:#8f1717}
    .smpm-submit i{font-size:16px}
 
    .smpm-foot{margin-top:20px;text-align:center;font-size:11px;color:#71717a}
    .smpm-foot i{margin-right:4px}
 
    @media(max-width:600px){
        .smpm{padding:12px}
        .smpm-dialog{padding:20px 16px}
        .smpm-actions{flex-direction:column-reverse}
        .smpm-actions .smpm-btn{width:100%}
    }
</style>
 
<div class="smp">
    <div class="top">
        <div>
            <h1>Social Media</h1>
            <div class="sub">Audience growth and engagement by channel</div>
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
        <div class="alert"><i class="bi bi-exclamation-triangle"></i>{{ $attention }} item{{ $attention > 1 ? 's' : '' }} needs attention</div>
    @endif
 
    <div class="panel-wrap"><div class="panel">
        <div class="panel-head">
            <div class="hl">
                <h2>{{ $period }} performance</h2>
                <p>Overview of audience, reach and engagement per channel, entered monthly.</p>
            </div>
            <div class="kpis">
                @foreach($kpis as $k)
                    <div class="kpi">
                        <div class="ico"><i class="bi {{ $k['icon'] }}"></i></div>
                        <div>
                            <div class="lbl">{{ $k['label'] }} <i class="bi bi-question-circle"></i></div>
                            <b>{{ $k['value'] }}</b>
                            <div class="d"><i class="bi bi-arrow-up-right" style="font-size:9px"></i> <em>{{ $k['delta'] }}</em> vs. prev month</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
 
        <div class="channels">
            @foreach($channels as $c)
                @if($c['tracked'])
                    <div class="ch">
                        <div class="ch-head">
                            <div class="ch-logo"><i class="bi {{ $c['icon'] }}"></i></div>
                            <div class="ch-name">{{ $c['name'] }}<small>{{ $c['handle'] }}</small></div>
                            <span class="growth"><i class="bi bi-graph-up"></i>{{ $c['growth'] }}</span>
                        </div>
                        <div class="aud"><small>Audience</small><b>{{ $c['audience'] }}</b></div>
                        @foreach($metricRows as $r)
                            <div class="row-m">
                                <i class="bi {{ $r['icon'] }}"></i>{{ $r['label'] }}
                                @isset($c[$r['key']])<span class="v">{{ $c[$r['key']] }}</span>@endisset
                            </div>
                        @endforeach
                    </div>
                @else
                    @php $kind = $c['kind'] ?? 'Page'; @endphp
                    <div class="ch off">
                        <div class="ch-head">
                            <div class="ch-logo"><i class="bi {{ $c['icon'] }}"></i></div>
                            <div class="ch-name">{{ $c['name'] }}</div>
                        </div>
                        <div class="off-body">
                            <div class="off-ico"><i class="bi bi-bar-chart-fill"></i></div>
                            <b>Not tracked this month</b>
                            <p>Add figures to include {{ $c['name'] }}<br>in your monthly report.</p>
                            <a href="{{ $c['connect_url'] ?? '#' }}" class="btn-connect js-connect" role="button"
                                data-channel="{{ strtolower($c['name']) }}"
                                data-name="{{ $c['name'] }}"
                                data-icon="{{ $c['icon'] }}"
                                data-label="{{ $c['name'] }} {{ ucfirst($kind) }} Link"
                                data-desc="Enter your {{ $c['name'] }} {{ $kind }} link to connect and automatically sync monthly performance data."
                                data-hint="Go to your {{ $c['name'] }} {{ $kind }}, then copy the URL from your browser address bar."
                                data-example="{{ $c['example'] ?? '' }}"><i class="bi bi-link-45deg"></i>Connect {{ $c['name'] }}</a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div></div>
 
    <div class="note">
        <i class="bi bi-info-circle"></i>
        <div>
            <b>Where these numbers come from</b>
            <p>Followers, reach, and engagement data are entered manually or imported from a marketing spreadsheet. Direct social media account integration is not yet available and is planned for Phase 2.</p>
        </div>
    </div>
</div>
 
{{-- ================= MODAL: CONNECT ACCOUNT ================= --}}
<div class="smpm" id="connectModal" aria-hidden="true">
    <form class="smpm-dialog" id="connectForm" method="POST" action="{{ $connectAction }}" novalidate
          role="dialog" aria-modal="true" aria-labelledby="connectTitle" aria-describedby="connectDesc">
        @csrf
        <input type="hidden" name="channel" id="connectChannel" value="">
 
        <button type="button" class="smpm-close" data-close aria-label="Close"><i class="bi bi-x-lg"></i></button>
 
        <div class="smpm-head">
            <div class="smpm-logo"><i class="bi bi-facebook" id="connectIcon"></i></div>
            <div>
                <h2 id="connectTitle">Connect Facebook Account</h2>
                <p id="connectDesc">Enter your Facebook Page link to connect and automatically sync monthly performance data.</p>
            </div>
        </div>
 
        <label class="smpm-label" for="connectLink" id="connectLabel">Facebook Page Link</label>
        <div class="smpm-field" id="connectField">
            <i class="bi bi-link-45deg"></i>
            <input type="url" class="smpm-input" id="connectLink" name="link" placeholder="Drop link here..." autocomplete="off" inputmode="url">
        </div>
        <div class="smpm-error" id="connectError">Enter a valid link that starts with https://</div>
 
        <div class="smpm-info">
            <i class="bi bi-info-circle"></i>
            <div>
                <b>How to get your link</b>
                <p id="connectHint">Go to your Facebook Page, then copy the URL from your browser address bar.</p>
                <p>Example : <a href="#" id="connectExample" tabindex="-1">https://facebook.com</a></p>
            </div>
        </div>
 
        <div class="smpm-actions">
            <button type="button" class="smpm-btn smpm-cancel" data-close>Cancel</button>
            <button type="submit" class="smpm-btn smpm-submit"><i class="bi bi-link-45deg"></i>Connect</button>
        </div>
 
        <div class="smpm-foot"><i class="bi bi-lock"></i>Your data is secure. We only access the data you authorize.</div>
    </form>
</div>
 
<script>
document.addEventListener('DOMContentLoaded', function () {
    var modal   = document.getElementById('connectModal');
    if (!modal) return;
 
    document.body.appendChild(modal);
 
    var form    = document.getElementById('connectForm');
    var input   = document.getElementById('connectLink');
    var field   = document.getElementById('connectField');
    var lastFocus = null;
 
    function setText(id, text) { var el = document.getElementById(id); if (el) el.textContent = text; }
 
    function openModal(d) {
        lastFocus = document.activeElement;
 
        setText('connectTitle', 'Connect ' + d.name + ' Account');
        setText('connectDesc', d.desc);
        setText('connectLabel', d.label);
        setText('connectHint', d.hint);
 
        var ex = document.getElementById('connectExample');
        ex.textContent = d.example || '';
        ex.setAttribute('href', d.example || '#');
        ex.setAttribute('target', '_blank');
        ex.setAttribute('rel', 'noopener');
 
        document.getElementById('connectIcon').className = 'bi ' + d.icon;
        document.getElementById('connectChannel').value = d.channel;
 
        input.value = '';
        field.classList.remove('is-invalid');
 
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('smpm-lock');
        setTimeout(function () { input.focus(); }, 50);
    }
 
    function closeModal() {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('smpm-lock');
        if (lastFocus && lastFocus.focus) lastFocus.focus();
    }
 
    document.querySelectorAll('.js-connect').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            openModal(btn.dataset);
        });
    });
 
    modal.querySelectorAll('[data-close]').forEach(function (b) { b.addEventListener('click', closeModal); });
    modal.addEventListener('mousedown', function (e) { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
    });
 
    input.addEventListener('input', function () { field.classList.remove('is-invalid'); });
    form.addEventListener('submit', function (e) {
        var ok = /^https?:\/\/[^\s.]+\.[^\s]{2,}$/i.test(input.value.trim());
        if (!ok) {
            e.preventDefault();
            field.classList.add('is-invalid');
            input.focus();
            return;
        }
        if (!form.getAttribute('action')) {
            e.preventDefault();
            closeModal();
        }
    });
});
</script>
@endsection