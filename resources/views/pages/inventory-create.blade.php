{{-- resources/views/pages/inventory-create.blade.php --}}
@extends('layouts.app')

@php
    $backUrl = $backUrl ?? url('/inventory');
    $storeUrl = $storeUrl ?? '#';
    $boardDossierUrl = $boardDossierUrl ?? '#';
    $exportUrl = $exportUrl ?? '#';
@endphp

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap">
<style>
    .inv-c, .inv-c *{box-sizing:border-box}
    .inv-c{zoom:.75; font-family:'Inter',system-ui,sans-serif;color:#fff;font-size:15px;line-height:1.4;padding:14px 0 56px}
    .inv-c h1, .inv-c h2, .inv-c p, .inv-c b{margin:0;font-family:inherit}
    .inv-c a{text-decoration:none;color:inherit}

    /* Top bar & back link */
    .inv-c-top-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px}
    .inv-c-back{display:inline-flex;align-items:center;gap:8px;font-size:15px;color:#aaa;font-weight:500;cursor:pointer}
    .inv-c-back:hover{color:#fff}

    .inv-c-actions-top{display:flex;align-items:center;gap:12px}
    .inv-c-btn-top{background:#181818;border:1px solid #444;color:#fff;padding:8px 16px;border-radius:6px;font-size:13px;font-weight:500;display:inline-flex;align-items:center;gap:8px;cursor:pointer}
    .inv-c-btn-top.red{background:#a31c1c;border-color:#a31c1c}

    /* Title */
    .inv-c h1{font-size:26px;font-weight:600;margin-bottom:6px}
    .inv-c .sub-title{font-size:15px;color:#aaa;margin-bottom:32px}

    /* Form Fields Grid */
    .inv-c-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:24px}
    .inv-c-group{display:flex;flex-direction:column;gap:8px}
    .inv-c-label{font-size:13px;font-weight:500;color:#ddd}
    .inv-c-label span{color:#e03131}

    .inv-c-input, .inv-c-select{display:block;width:100%;background:#141414;border:1px solid #444;border-radius:6px;color:#fff;font-size:14px;font-family:inherit;outline:none;padding:0 14px;height:48px}
    .inv-c-select{cursor:pointer;appearance:none;-webkit-appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23aaa' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:calc(100% - 14px) center;padding-right:36px}
    .inv-c-input::placeholder{color:#666}

    .inv-c-group-full{display:flex;flex-direction:column;gap:8px;margin-bottom:24px}
</style>

<div class="inv-c">
    {{-- Top Row: Back & Header Actions --}}
    <div class="inv-c-top-row">
        <a href="{{ $backUrl }}" class="inv-c-back">
            <i class="bi bi-arrow-left"></i> Back to inventory
        </a>
        <div class="inv-c-actions-top">
            <a href="{{ $boardDossierUrl }}" class="inv-c-btn-top"><i class="bi bi-calculator"></i> Board Dossier</a>
            <a href="{{ $exportUrl }}" class="inv-c-btn-top red"><i class="bi bi-file-earmark-arrow-up"></i> Export As <i class="bi bi-chevron-down"></i></a>
        </div>
    </div>

    <h1>Add new item</h1>
    <div class="sub-title">Enter the item details to add it to your inventory.</div>

    <form action="{{ $storeUrl }}" method="POST">
        @csrf

        {{-- Row 1: SKU & KPI --}}
        <div class="inv-c-grid-2">
            <div class="inv-c-group">
                <label class="inv-c-label" for="skuCode">SKU <span>*</span></label>
                <input type="text" class="inv-c-input" id="skuCode" name="sku" placeholder="Enter SKU code" required autocomplete="off">
            </div>
            <div class="inv-c-group">
                <label class="inv-c-label" for="kpiSelect1">KPI <span>*</span></label>
                <select class="inv-c-select" id="kpiSelect1" name="kpi_1" required>
                    <option value="" disabled selected>Choose a KPI</option>
                    <option value="Operational">Operational</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Finance">Finance</option>
                </select>
            </div>
        </div>

        {{-- Row 2: Person (Full width) --}}
        <div class="inv-c-group-full">
            <label class="inv-c-label" for="personSelect1">Person <span>*</span></label>
            <select class="inv-c-select" id="personSelect1" name="person_1" required>
                <option value="" disabled selected>Choose somebody</option>
                <option value="Reinhart Okta Putra">Reinhart Okta Putra</option>
                <option value="Jason Judah Pakasi">Jason Judah Pakasi</option>
                <option value="Abraham Partogi Liem Silaen">Abraham Partogi Liem Silaen</option>
                <option value="Amabel Eugenia">Amabel Eugenia</option>
            </select>
        </div>

        {{-- Row 3: Person & KPI --}}
        <div class="inv-c-grid-2">
            <div class="inv-c-group">
                <label class="inv-c-label" for="personSelect2">Person <span>*</span></label>
                <select class="inv-c-select" id="personSelect2" name="person_2" required>
                    <option value="" disabled selected>Choose somebody</option>
                    <option value="Reinhart Okta Putra">Reinhart Okta Putra</option>
                    <option value="Jason Judah Pakasi">Jason Judah Pakasi</option>
                    <option value="Abraham Partogi Liem Silaen">Abraham Partogi Liem Silaen</option>
                </select>
            </div>
            <div class="inv-c-group">
                <label class="inv-c-label" for="kpiSelect2">KPI <span>*</span></label>
                <select class="inv-c-select" id="kpiSelect2" name="kpi_2" required>
                    <option value="" disabled selected>Choose a KPI</option>
                    <option value="Operational">Operational</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Finance">Finance</option>
                </select>
            </div>
        </div>

        {{-- Row 4: Person (Full width) --}}
        <div class="inv-c-group-full">
            <label class="inv-c-label" for="personSelect3">Person <span>*</span></label>
            <select class="inv-c-select" id="personSelect3" name="person_3" required>
                <option value="" disabled selected>Choose somebody</option>
                <option value="Reinhart Okta Putra">Reinhart Okta Putra</option>
                <option value="Jason Judah Pakasi">Jason Judah Pakasi</option>
                <option value="Abraham Partogi Liem Silaen">Abraham Partogi Liem Silaen</option>
            </select>
        </div>
    </form>
</div>
@endsection