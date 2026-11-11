<?php

use Illuminate\Support\Facades\Route;

// ==========================================
// RUTE UTAMA & MENU UTAMA (TODAY & PERFORMANCE)
// ==========================================
Route::get('/', function () {
    return view('pages.my-work');
});

Route::get('/my-work', function () {
    return view('pages.my-work');
});

Route::get('/overview', function () {
    return view('pages.overview');
});

Route::get('/marketing-performance', function () {
    return view('pages.marketing-performance');
});

Route::get('/social-media', function () {
    return view('pages.social-media');
});

Route::get('/team-scorecards', function () {
    return view('pages.team-scorecard');
});

Route::get('/content-calendar', function () {
    return view('pages.content-calendar');
});


// ==========================================
// RUTE OPERATIONS: PROJECTS
// ==========================================
// 1. Rute Statis / Form Create (Wajib di atas rute parameter {id})
Route::get('/projects', function () {
    return view('pages.projects');
})->name('projects.index');

Route::get('/operations/projects', function () {
    return view('pages.projects');
})->name('operations.projects.index');

Route::get('/projects/create', function () {
    return view('pages.project-create');
})->name('projects.create');

Route::get('/operations/projects/create', function () {
    return view('pages.project-create');
})->name('operations.projects.create');

// 2. Rute Dinamis dengan parameter {id} (Wajib di bawah rute statis)
Route::get('/projects/{id}', function ($id) {
    return view('pages.project-detail', compact('id'));
})->name('projects.show');

Route::get('/operations/projects/{id}', function ($id) {
    return view('pages.project-detail', compact('id'));
})->name('operations.projects.show');


// ==========================================
// RUTE OPERATIONS: INVENTORY
// ==========================================
// 1. Rute Statis / Form Create Inventory
Route::get('/inventory', function () {
    return view('pages.inventory');
})->name('inventory.index');

Route::get('/operations/inventory', function () {
    return view('pages.inventory');
})->name('operations.inventory.index');

Route::get('/inventory/create', function () {
    return view('pages.inventory-create');
})->name('inventory.create');

Route::get('/operations/inventory/create', function () {
    return view('pages.inventory-create');
})->name('operations.inventory.create');


// ==========================================
// RUTE OPERATIONS LAINNYA
// ==========================================
Route::get('/promotors', function () {
    return view('pages.promotors');
});