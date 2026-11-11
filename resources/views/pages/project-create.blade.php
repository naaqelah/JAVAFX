{{-- resources/views/pages/project-create.blade.php --}}
@extends('layouts.app')

@php
    $backUrl = $backUrl ?? url('/projects');
    $storeUrl = $storeUrl ?? '#';
    $overdueMessage = $overdueMessage ?? '1 overdue: test collab';
    
    $teamMembers = [
        'All' => [
            'Abraham Partogi Liem Silaen',
            'Amabel Eugenia',
            'Ezra Judah',
            'Jason Judah Pakasi',
            'Yudi T. Sinambela',
            'Lidia Wulan',
            'Meyva Linda',
            'Reinhart Okta Putra',
            'Stephanie Jodie'
        ],
        'Creative' => [],
        'Podcast' => [],
        'Ads' => [],
        'Corporate' => [],
        'Campaign' => [],
    ];
@endphp

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap">
<style>
    .pcr, .pcr *{box-sizing:border-box}
    .pcr{zoom:.75; font-family:'Inter',system-ui,sans-serif;color:#fff;font-size:15px;line-height:1.4;padding:18px 0 48px}
    .pcr h1, .pcr h2, .pcr p, .pcr b{margin:0;font-family:inherit}
    .pcr a{text-decoration:none;color:inherit}

    /* Back link */
    .pcr-back{display:inline-flex;align-items:center;gap:8px;font-size:15px;color:#fff;font-weight:500;margin-bottom:24px;cursor:pointer}
    .pcr-back:hover{color:#ccc}

    /* Title */
    .pcr h1{font-size:26px;font-weight:600;margin-bottom:20px}

    /* Alert banner */
    .pcr-alert{display:flex;align-items:center;gap:12px;background:#dbeafe;color:#1e3a8a;border-radius:8px;height:52px;padding:0 20px;font-size:15px;font-weight:500;margin-bottom:26px}
    .pcr-alert i{font-size:18px}

    /* Form Layout Grid */
    .pcr-grid-3{display:grid;grid-template-columns:2fr 1fr 1fr;gap:20px;margin-bottom:22px}
    .pcr-group{display:flex;flex-direction:column;gap:8px}
    .pcr-label{font-size:13px;font-weight:500;color:#ddd}
    .pcr-label span{color:#e03131}

    .pcr-input, .pcr-select, .pcr-textarea{display:block;width:100%;background:#141414;border:1px solid #444;border-radius:6px;color:#fff;font-size:14px;font-family:inherit;outline:none;padding:0 14px}
    .pcr-input{height:46px}
    .pcr-select{height:46px;cursor:pointer;appearance:none;-webkit-appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23aaa' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:calc(100% - 14px) center;padding-right:36px}
    .pcr-textarea{height:90px;padding:12px 14px;resize:vertical}
    
    .pcr-input::placeholder, .pcr-textarea::placeholder{color:#777}

    /* Team section */
    .pcr-section-title{font-size:14px;font-weight:500;color:#fff;margin:28px 0 12px;display:flex;align-items:center;gap:8px}
    
    /* Checkbox Chips Grid */
    .pcr-team-grid{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:16px}
    .pcr-checkbox-chip{display:inline-flex;align-items:center;gap:10px;background:#181818;border:1px solid #333;border-radius:6px;padding:10px 14px;cursor:pointer;font-size:13px;user-select:none;transition:border-color .15s}
    .pcr-checkbox-chip:hover{border-color:#555}
    .pcr-checkbox-chip input[type="checkbox"]{accent-color:#a31c1c;width:16px;height:16px;cursor:pointer}

    /* Filter Pills */
    .pcr-filter-wrap{display:flex;flex-wrap:wrap;gap:8px;margin-top:16px}
    .pcr-filter-pill{background:#181818;border:1px solid #333;color:#ccc;padding:7px 16px;border-radius:20px;font-size:13px;font-weight:500;display:inline-flex;align-items:center;gap:6px;cursor:pointer}
    .pcr-filter-pill.active{background:#fff;color:#141414;border-color:#fff}
    .pcr-filter-pill span{background:#333;color:#fff;font-size:11px;padding:1px 6px;border-radius:10px}
    .pcr-filter-pill.active span{background:#141414;color:#fff}

    /* Actions bottom */
    .pcr-actions{display:flex;justify-content:flex-end;gap:12px;margin-top:40px}
    .pcr-btn{height:44px;display:inline-flex;align-items:center;justify-content:center;border-radius:6px;padding:0 22px;font-size:14px;font-weight:500;cursor:pointer}
    .pcr-cancel{background:transparent;border:1px solid #555;color:#fff}
    .pcr-cancel:hover{background:rgba(255,255,255,.05)}
    .pcr-submit{background:#a31c1c;border:0;color:#fff}
    .pcr-submit:hover{background:#b82222}
</style>

<div class="pcr">
    {{-- Back Link --}}
    <a href="{{ $backUrl }}" class="pcr-back">
        <i class="bi bi-arrow-left"></i> Back to project
    </a>

    <h1>Create New Project</h1>

    <form action="{{ $storeUrl }}" method="POST">
        @csrf

        {{-- Overdue Alert Banner --}}
        <div class="pcr-alert">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span>{{ $overdueMessage }}</span>
        </div>

        {{-- Row 1: Name, Category, Deadline --}}
        <div class="pcr-grid-3">
            <div class="pcr-group">
                <label class="pcr-label" for="projectName">Project name <span>*</span></label>
                <input type="text" class="pcr-input" id="projectName" name="name" placeholder="Enter project name" required autocomplete="off">
            </div>
            <div class="pcr-group">
                <label class="pcr-label" for="projectCategory">Category <span>*</span></label>
                <select class="pcr-select" id="projectCategory" name="category" required>
                    <option value="" disabled selected>Select category</option>
                    <option value="Web">Web</option>
                    <option value="Content Production">Content Production</option>
                    <option value="Social Media">Social Media</option>
                    <option value="Brand Identity">Brand Identity</option>
                    <option value="Partnerships">Partnerships</option>
                    <option value="Video Production">Video Production</option>
                    <option value="Podcast">Podcast</option>
                </select>
            </div>
            <div class="pcr-group">
                <label class="pcr-label" for="projectDeadline">Deadline <span>*</span></label>
                <input type="text" class="pcr-input" id="projectDeadline" name="deadline" placeholder="mm/dd/yyyy" onfocus="this.type='date'" onblur="if(!this.value)this.type='text'" required>
            </div>
        </div>

        {{-- Row 2: Description --}}
        <div class="pcr-group" style="margin-bottom:22px;">
            <label class="pcr-label" for="projectDesc">What is this project for? <i>(optional)</i></label>
            <textarea class="pcr-textarea" id="projectDesc" name="description" placeholder="Brief description of this project"></textarea>
        </div>

        {{-- Row 3: People working on it --}}
        <div class="pcr-section-title">
            <i class="bi bi-people"></i> People working on it with you (optional)
        </div>

        <div class="pcr-team-grid">
            @foreach($teamMembers['All'] as $member)
                <label class="pcr-checkbox-chip">
                    <input type="checkbox" name="members[]" value="{{ $member }}">
                    <span>{{ $member }}</span>
                </label>
            @endforeach
        </div>

        {{-- Filter category pills --}}
        <div class="pcr-filter-wrap">
            <button type="button" class="pcr-filter-pill active"><i class="bi bi-grid-3x3"></i> All <span>3</span></button>
            <button type="button" class="pcr-filter-pill"><i class="bi bi-lightbulb"></i> Creative <span>0</span></button>
            <button type="button" class="pcr-filter-pill"><i class="bi bi-mic"></i> Podcast <span>1</span></button>
            <button type="button" class="pcr-filter-pill"><i class="bi bi-megaphone"></i> Ads <span>0</span></button>
            <button type="button" class="pcr-filter-pill"><i class="bi bi-briefcase"></i> Corporate <span>1</span></button>
            <button type="button" class="pcr-filter-pill"><i class="bi bi-arrow-repeat"></i> Campaign <span>1</span></button>
        </div>

        {{-- Actions --}}
        <div class="pcr-actions">
            <a href="{{ $backUrl }}" class="pcr-btn pcr-cancel">Cancel</a>
            <button type="submit" class="pcr-btn pcr-submit">+ Add Project</button>
        </div>
    </form>
</div>
@endsection