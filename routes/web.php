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
