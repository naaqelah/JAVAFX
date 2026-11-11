@extends('layouts.app')

@php
    $project = $project ?? [
        'name' => 'Test collab2',
        'status' => 'in_progress',
        'deadline' => '11 Oct 2026',
        'category' => 'Podcast',
        'members' => [
            ['initials' => 'JS', 'name' => 'Jason Judah Pakasi'],
            ['initials' => 'AP', 'name' => 'Abraham Partogi Liem Silaen'],
            ['initials' => 'AE', 'name' => 'Amabel Eugenia'],
            ['initials' => 'EJ', 'name' => 'Ezra Judah'],
        ],
        'progress_percent' => 33,
        'completed_tasks' => 1,
        'total_tasks' => 3
    ];
@endphp

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap">
<style>
    .pdt, .pdt *{box-sizing:border-box}
    .pdt{zoom:.75; font-family:'Inter',system-ui,sans-serif;color:#fff;font-size:15px;line-height:1.4;padding:18px 0 48px}
    .pdt h1, .pdt h2, .pdt p, .pdt b{margin:0;font-family:inherit}
    .pdt a{text-decoration:none;color:inherit}

    .pdt-top-bar{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px}
    .pdt-breadcrumb{font-size:18px;color:#aaa;display:flex;align-items:center;gap:8px}
    .pdt-breadcrumb span{color:#fff;font-weight:600}
    .pdt-btn-del{background:#a31c1c;border:0;color:#fff;padding:10px 18px;border-radius:7px;font-size:14px;font-weight:500;display:inline-flex;align-items:center;gap:8px;cursor:pointer}
    .pdt-btn-del:hover{background:#b82222}

    .pdt-hero{background:#181818;border:1px solid #333;border-radius:12px;padding:28px 32px;display:flex;align-items:center;justify-content:space-between;gap:24px;margin-bottom:32px}
    .pdt-hero-left h1{font-size:26px;font-weight:600;margin-bottom:12px;display:flex;align-items:center;gap:14px}
    .pdt-badge-prog{background:#ffb92e;color:#222;font-size:12px;padding:4px 10px;border-radius:4px;font-weight:600;text-transform:uppercase}
    
    .pdt-meta{display:flex;align-items:center;gap:20px;font-size:14px;color:#aaa;margin-bottom:20px}
    .pdt-meta div{display:flex;align-items:center;gap:6px}

    .pdt-team{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
    .pdt-avatar-chip{background:#2a2a2a;border:1px solid #444;border-radius:20px;padding:4px 12px 4px 4px;display:inline-flex;align-items:center;gap:8px;font-size:13px}
    .pdt-avatar-circle{width:26px;height:26px;background:#3a3a3a;border-radius:50%;display:grid;place-items:center;font-size:11px;font-weight:600;color:#fff}
    .pdt-add-people{background:transparent;border:1px dashed #666;border-radius:20px;padding:5px 14px;font-size:13px;color:#ccc;cursor:pointer;display:inline-flex;align-items:center;gap:6px}
    .pdt-add-people:hover{background:rgba(255,255,255,.05)}

    .pdt-progress-box{display:flex;align-items:center;gap:18px;text-align:right}
    .pdt-progress-box .num{font-size:28px;font-weight:700;color:#fff;line-height:1.1}
    .pdt-progress-box .sub{font-size:13px;color:#888}
    .pdt-ring{width:64px;height:64px;border-radius:50%;background:conic-gradient(#35b765 33%, #333 0);display:grid;place-items:center}
    .pdt-ring-inner{width:52px;height:52px;background:#181818;border-radius:50%;display:grid;place-items:center;font-size:12px;font-weight:600}

    .pdt-section-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px}
    .pdt-section-head h2{font-size:18px;font-weight:600}
    .pdt-btn-add-item{background:transparent;border:1px solid #555;color:#fff;padding:8px 16px;border-radius:6px;font-size:13px;font-weight:500;display:inline-flex;align-items:center;gap:6px;cursor:pointer}
    .pdt-btn-add-item:hover{background:rgba(255,255,255,.05)}

    .pdt-task-card{background:#181818;border:1px solid #333;border-radius:8px;padding:18px 20px;margin-bottom:14px}
    .pdt-task-header{display:flex;align-items:center;gap:12px;flex-wrap:wrap}
    .pdt-task-checkbox{width:20px;height:20px;background:#a31c1c;border-radius:4px;display:grid;place-items:center;color:#fff;font-size:12px}
    .pdt-task-title{font-size:15px;font-weight:600}
    .pdt-task-badge-med{background:#ca8a04;color:#fff;font-size:11px;padding:2px 8px;border-radius:4px;font-weight:500}
    .pdt-task-info{font-size:12px;color:#999;display:flex;align-items:center;gap:14px;margin-left:auto}
    .pdt-task-status-pill{background:#1e4620;color:#35b765;border:1px solid #35b765;font-size:11px;padding:3px 10px;border-radius:4px;font-weight:500}
    .pdt-task-status-blue{background:#1e3a8a;color:#60a5fa;border:1px solid #3b82f6;font-size:11px;padding:3px 10px;border-radius:4px;font-weight:500}
    .pdt-btn-edit{background:transparent;border:1px solid #555;color:#fff;padding:4px 10px;border-radius:4px;font-size:12px;cursor:pointer}
    .pdt-task-actions-icon{color:#888;font-size:16px;cursor:pointer}

    .pdt-content-box{background:#141414;border:1px solid #2a2a2a;border-radius:6px;padding:14px;margin-top:14px}
    .pdt-content-box-label{font-size:12px;color:#888;margin-bottom:8px;font-weight:500;text-transform:uppercase;letter-spacing:.5px}
    .pdt-content-tools{display:flex;gap:8px;margin-bottom:12px}
    .pdt-sub-btn{background:#222;border:1px solid #444;color:#fff;padding:5px 12px;border-radius:4px;font-size:12px;display:inline-flex;align-items:center;gap:6px;cursor:pointer}

    .pdt-inner-item{background:#1a1a1a;border:1px solid #333;border-radius:6px;padding:10px 14px;display:flex;align-items:center;gap:12px;margin-top:8px}
    .pdt-inner-icon{width:32px;height:32px;background:#2a2a2a;border-radius:4px;display:grid;place-items:center;color:#ccc}

    .pdt-notes-input{width:100%;background:#141414;border:1px solid #444;border-radius:6px;color:#fff;padding:12px;font-size:13px;resize:vertical;min-height:50px;margin-top:8px;outline:none}
    .pdt-notes-input:focus{border-color:#a31c1c}

    .pdt-bottom-bar{background:#181818;border:1px solid #333;border-radius:8px;padding:16px 20px;display:flex;align-items:center;gap:14px;margin-top:24px}
    .pdt-input-text{flex:1;height:42px;background:#141414;border:1px solid #444;border-radius:6px;padding:0 14px;color:#fff;font-size:13px;outline:none}
    .pdt-input-date{width:160px;height:42px;background:#141414;border:1px solid #444;border-radius:6px;padding:0 10px;color:#fff;font-size:13px}
    .pdt-select-prio{width:120px;height:42px;background:#141414;border:1px solid #444;border-radius:6px;padding:0 10px;color:#fff;font-size:13px}
    .pdt-btn-add{background:#a31c1c;border:0;color:#fff;height:42px;padding:0 18px;border-radius:6px;font-size:13px;font-weight:500;display:inline-flex;align-items:center;gap:6px;cursor:pointer}
</style>

<div class="pdt">
    <div class="pdt-top-bar">
        <div class="pdt-breadcrumb">
            <a href="{{ url('/projects') }}" style="color:#aaa;">Projects</a> 
            <i class="bi bi-chevron-right" style="font-size:12px;"></i> 
            <span>{{ $project['name'] }} (ID: {{ $id ?? 1 }})</span>
        </div>
        <button type="button" class="pdt-btn-del"><i class="bi bi-trash"></i>Delete project</button>
    </div>

    <div class="pdt-hero">
        <div class="pdt-hero-left">
            <h1>
                {{ $project['name'] }} 
                <span class="pdt-badge-prog">In progress</span>
            </h1>
            <div class="pdt-meta">
                <div><i class="bi bi-calendar"></i> Deadline 11 Oct 2026</div>
                <div><i class="bi bi-tag"></i> Podcast</div>
                <div><i class="bi bi-people"></i> 4 people</div>
            </div>
            <div class="pdt-team">
                @foreach($project['members'] as $m)
                    <div class="pdt-avatar-chip">
                        <div class="pdt-avatar-circle">{{ $m['initials'] }}</div>
                        <span>{{ $m['name'] }}</span>
                    </div>
                @endforeach
                <button type="button" class="pdt-add-people"><i class="bi bi-plus"></i>Add people</button>
            </div>
        </div>

        <div class="pdt-progress-box">
            <div>
                <div class="num">{{ $project['progress_percent'] }}%</div>
                <div class="sub">{{ $project['completed_tasks'] }} of {{ $project['total_tasks'] }} tasks completed</div>
            </div>
            <div class="pdt-ring">
                <div class="pdt-ring-inner">33%</div>
            </div>
        </div>
    </div>

    <div class="pdt-section-head">
        <h2>Tasks checklist</h2>
        <button type="button" class="pdt-btn-add-item"><i class="bi bi-plus-lg"></i>Add Checklist item</button>
    </div>

    <div class="pdt-task-card">
        <div class="pdt-task-header">
            <div class="pdt-task-checkbox"><i class="bi bi-check"></i></div>
            <div class="pdt-task-title">Test 1</div>
            <span class="pdt-task-badge-med">Medium</span>
            <div class="pdt-task-info">
                <span><i class="bi bi-calendar"></i> Deadline 8 Jan 2027, 22:29</span>
                <span><i class="bi bi-clock"></i> Submitted 31 Oct 2026, 19:46</span>
                <span class="pdt-task-status-pill">Submitted on time</span>
                <button type="button" class="pdt-btn-edit"><i class="bi bi-pencil"></i> Edit</button>
                <i class="bi bi-three-dots-vertical pdt-task-actions-icon"></i>
                <i class="bi bi-chevron-up" style="cursor:pointer;"></i>
            </div>
        </div>

        <div class="pdt-content-box">
            <div class="pdt-content-box-label">Content</div>
            <div class="pdt-content-tools">
                <button type="button" class="pdt-sub-btn"><i class="bi bi-plus"></i> New content</button>
                <button type="button" class="pdt-sub-btn"><i class="bi bi-link-45deg"></i> Link content</button>
            </div>
            
            <div class="pdt-inner-item">
                <div class="pdt-inner-icon"><i class="bi bi-instagram"></i></div>
                <div style="flex:1;">
                    <div style="font-weight:600; font-size:14px;">Test 1</div>
                    <div style="font-size:12px; color:#aaa; margin-top:2px;">Instagram · Video · Jason Judah Pakasi &nbsp;·&nbsp; <span style="color:#35b765;">Idea</span> › Scheduling › Drafting › In review › Approved › Published</div>
                </div>
                <button type="button" style="background:transparent; border:1px solid #555; color:#ff4d4d; padding:4px 10px; border-radius:4px; font-size:12px; cursor:pointer;">Unlink</button>
            </div>
        </div>

        <div class="pdt-content-box" style="margin-top:12px;">
            <div class="pdt-content-box-label">Evidence</div>
            <button type="button" class="pdt-sub-btn" style="margin-bottom:8px;"><i class="bi bi-plus"></i> Add Evidence</button>
            
            <div class="pdt-inner-item">
                <div class="pdt-inner-icon"><i class="bi bi-file-earmark-image"></i></div>
                <div style="flex:1;">
                    <div style="font-weight:600; font-size:13px;">screenshot_2026-10-31_19-46-00.png</div>
                    <div style="font-size:11px; color:#888;">Uploaded by Jason Judah Pakasi · 31 Oct 2026, 19:46 · 245 KB</div>
                </div>
                <button type="button" style="background:transparent; border:1px solid #555; color:#fff; padding:4px 10px; border-radius:4px; font-size:12px; display:inline-flex; align-items:center; gap:4px; cursor:pointer;"><i class="bi bi-eye"></i> View</button>
                <i class="bi bi-three-dots-vertical" style="color:#888; cursor:pointer; margin-left:6px;"></i>
            </div>
        </div>

        <div style="margin-top:14px;">
            <label style="font-size:12px; color:#888; display:block; margin-bottom:4px;">Task notes (optional)</label>
            <textarea class="pdt-notes-input" placeholder="Add notes here..."></textarea>
            <div style="display:flex; justify-content:flex-end; font-size:11px; color:#888; margin-top:4px;">
                Last updated 31 Oct 2026, 19:46 by Jason Judah Pakasi
            </div>
        </div>
    </div>

    <div class="pdt-task-card">
        <div class="pdt-task-header">
            <div class="pdt-task-checkbox" style="background:#555;"><i class="bi bi-dash"></i></div>
            <div class="pdt-task-title">Test 2</div>
            <span class="pdt-task-badge-med">Medium</span>
            <div class="pdt-task-info">
                <span><i class="bi bi-calendar"></i> Deadline 8 Jan 2027, 22:29</span>
                <span><i class="bi bi-clock"></i> Submitted 31 Oct 2026, 19:46</span>
                <span class="pdt-task-status-blue">In Progres</span>
                <button type="button" class="pdt-btn-edit"><i class="bi bi-pencil"></i> Edit</button>
                <i class="bi bi-three-dots-vertical pdt-task-actions-icon"></i>
                <i class="bi bi-chevron-down" style="cursor:pointer;"></i>
            </div>
        </div>
    </div>

    <div class="pdt-task-card">
        <div class="pdt-task-header">
            <div class="pdt-task-checkbox" style="background:#555;"><i class="bi bi-dash"></i></div>
            <div class="pdt-task-title">Test 3</div>
            <span class="pdt-task-badge-med">Medium</span>
            <div class="pdt-task-info">
                <span><i class="bi bi-calendar"></i> Deadline 8 Jan 2027, 22:29</span>
                <span><i class="bi bi-clock"></i> Submitted 31 Oct 2026, 19:46</span>
                <span class="pdt-task-status-blue">In Progres</span>
                <button type="button" class="pdt-btn-edit"><i class="bi bi-pencil"></i> Edit</button>
                <i class="bi bi-three-dots-vertical pdt-task-actions-icon"></i>
                <i class="bi bi-chevron-down" style="cursor:pointer;"></i>
            </div>
        </div>
    </div>

    <div class="pdt-bottom-bar">
        <input type="text" class="pdt-input-text" placeholder="Add a checklist item">
        <input type="datetime-local" class="pdt-input-date" value="2027-01-08T22:29">
        <select class="pdt-select-prio">
            <option>Medium</option>
            <option>High</option>
            <option>Low</option>
        </select>
        <button type="button" class="pdt-btn-add"><i class="bi bi-plus-lg"></i> Add</button>
    </div>
    
    <div style="font-size:12px; color:#888; margin-top:8px; display:flex; align-items:center; gap:6px;">
        <i class="bi bi-info-circle"></i> Checklist item will be added to the bottom of the list.
    </div>
</div>
@endsection