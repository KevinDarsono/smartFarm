@extends('admin.layouts.base')

@section('meta_title', 'Admin Dashboard')
@section('page_title', 'Dashboard')
@section('page_title_sub', 'Welcome to Dashboard')
@section('page_title_icon')
    <i class="metismenu-icon bi bi-house-door"></i>
@endsection


@section('content')

    @include('layouts.components.block_row')

@endsection
