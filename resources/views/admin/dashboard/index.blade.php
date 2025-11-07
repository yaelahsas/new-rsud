@extends('layouts.app')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
@include('admin.dashboard.alpine-index')
@endsection