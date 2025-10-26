<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/medis', function () {
    return view('medis');
});
Route::get('/artikel', function () {
    return view('artikel');
});
Route::get('/inovasi', function () {
    return view('inovasi');
});
Route::get('/admin', function () {
    return view('login.index');
});
Route::get('/admin/dashboard', function () {
    return view('admin.index');
});

Route::get('/admin/kategori', function () {
    return view('admin.kategori.index');
})->name('admin.kategori');
Route::get('/admin/users', function () {
    return view('admin.user.index');
})->name('admin.users');
Route::get('/admin/poli', function () {
    return view('admin.poli.index');
})->name('admin.poli');
Route::get('/admin/dokter', function () {
    return view('admin.dokter.index');
})->name('admin.dokter');
Route::get('/admin/berita', function () {
    return view('admin.berita.index');
})->name('admin.berita');