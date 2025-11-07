@extends('layouts.app')

@section('title', 'Manajemen Dokter')
@section('breadcrumb', 'Dokter')

@section('content')
@include('admin.dokter.alpine-index')
@endsection