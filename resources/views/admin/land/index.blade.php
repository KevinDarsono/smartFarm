@extends('admin.layouts.base')
@section('meta_title', 'Manage Lahan')
@section('page_title', 'Lahan')
@section('page_title_sub', 'Manage Lahan')
@section('page_title_icon')
<i class="metismenu-icon bi bi-columns-gap"></i>
@endsection

@section('content')

<style>
    th.dt-center,
    td.dt-center {
        text-align: center;
    }
</style>
<div class="section-body">
    <div class="main-card mb-3 card">
        <div class="card-body">
            <a href="{{route('lands.create')}}" title="Tambah" class="btn btn-primary action-btn">Tambah</a>
            <div class="table-responsive">
                <table style="width: 100%" class="align-middle mb-0 table-hover table data-table" id="lands">
                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Pemilik</th>
                            <th>Deskripsi</th>
                            <th class="no-sort action">Action</th>
                            <th class="d-none hidden">Updated at</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        $("#lands").dataTable({
            processing: true,
            servierSide: true,
            responsive: true,
            ajax: '{{ route('lands.index') }}',
            columnDefs: [
            {"width": "20%", "targets": -1}
            ],
            columns: [
            {data: 'id', name: 'name'},
            {data: 'name', name: 'name'},
            {data: 'data_relasi', name: 'user.name'},
            {data: 'description', name: 'description'},
            // {data: 'name', name: 'name'},
            // {data: 'role', name: 'role'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        })
    })
</script>
@endpush
