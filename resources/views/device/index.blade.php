@extends('layouts.farmer.detail-base')
@section('meta_title', 'Manage Lahan')
@section('page_title', 'Lahan')
@section('page_title_sub', 'Manage Lahan')
@section('page_title_icon')
    <i class="metismenu-icon bi bi-columns-gap"></i>
@endsection
@breadcrumbs([
    'Lahan' => route('lands.index'),
    $land->name => route('lands.show', $land->id),
    'Devices',
])


@section('content')
    <div class="d-flex justify-content-end mb-2">
        <a href="{{ route('lands.devices.create', $land->id) }}" title="Tambah" class="btn btn-primary action-btn">Tambah</a>
    </div>
    <div class="section-body">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="table-responsive">
                    <table style="width: 100%" class="align-middle mb-0 table-hover table data-table" id="devices">
                        <thead>
                            <tr>
                                <th>Device ID</th>
                                <th>Nama</th>
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

@section('js')
    <script>
        {{-- $('#devices').on('click', 'tbody tr', function() {
            var id = $(this).attr('id');
            window.location.href = "{{ route('devices.show', ':id') }}".replace(':id', id);
        }); --}}

        $(document).ready(function() {
            $("#devices").dataTable({
                language: {
                    emptyTable: "Tidak ada Device"
                },
                processing: true,
                servierSide: true,
                responsive: true,
                ajax: '{{ route('lands.devices.index', $land->id) }}',
                columnDefs: [{
                    "width": "20%",
                    "targets": -1
                }],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name',

                    },
                ]
            })
        })

        function del(param) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $('#' + param).submit();
                }
            })
        }

        // on table row clicked
        $('#devices').on('click', 'tbody tr', function() {
            var id = $(this).attr('id');
            window.location.href = "{{ route('lands.devices.show', ['land' => $land->id, 'device' => ':id']) }}"
                .replace(':id', id);
        });
    </script>
@endsection
