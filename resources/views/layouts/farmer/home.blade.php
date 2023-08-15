@extends('layouts.farmer.base')

@section('meta_title', 'Farmer Home')
@section('page_title', 'Home')
@section('page_title_sub', 'Welcome to Home')
@section('page_title_icon')
    <i class="metismenu-icon bi bi-house-door"></i>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card mb-3 widget-content bg-midnight-bloom">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Total Lahan</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span>{{ $land_count }}</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card mb-3 widget-content bg-midnight-bloom">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Total Device</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span>{{ $device_count }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
