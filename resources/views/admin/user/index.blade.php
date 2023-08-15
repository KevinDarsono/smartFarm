@extends('admin.layouts.base')
@section('meta_title', 'Manage Users')
@section('page_title', 'Users')
@section('page_title_sub', 'Manage Users')
@section('page_title_icon')
    <i class="metismenu-icon bi bi-people"></i>
@endsection
@section('page_title_buttons')
    <div class="d-flex justify-content-end">
        <a href="{{route('users.create')}}" title="Edit" class="btn btn-primary action-btn">Tambah</a>
    </div>
@endsection
@section('content')
    <div class="section-body">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="table-responsive">
                    <table style="width: 100%" class="align-middle mb-0 table-hover table data-table" id="users">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Role</th>
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
            $("#users").dataTable({
                processing: true,
                servierSide: true,
                responsive: true,
                ajax: '{{ route('users.index') }}',
                columnDefs: [
                    {"width": "20%", "targets": -1}
                ],
                columns: [
                    {data: 'id', name: 'name'},
                    {data: 'name', name: 'name'},
                    {data: 'role', name: 'role'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            })
        })
    </script>
@endpush
