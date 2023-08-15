@extends('layouts.farmer.base')
@section('meta_title', 'Manage Lahan')
@section('page_title', 'Lahan')
@section('page_title_sub', 'Manage Lahan')
@section('page_title_icon')
    <i class="metismenu-icon bi bi-columns-gap"></i>
@endsection
@section('page_title_buttons')
    <div class="d-flex justify-content-end">
        <a href="{{ route('lands.create') }}" title="Tambah" class="btn btn-primary action-btn">Tambah</a>
    </div>
@endsection
@section('content')
    <div class="section-body">
        <div class="row">
            @foreach ($lands as $land)
                @livewire('components.land-card', ['land' => $land])
            @endforeach
        </div>
    </div>

    {{-- <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="table-responsive">
                    <table style="width: 100%" class="align-middle mb-0 table-hover table data-table" id="lands">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th class="d-none hidden">Updated at</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div> --}}
@endsection

@section('js')
    <script>
        $('#lands').on('click', 'tbody tr', function() {
            var id = $(this).attr('id');
            window.location.href = "{{ route('lands.show', ':id') }}".replace(':id', id);
        });

        $(document).ready(function() {
            $("#lands").dataTable({
                processing: true,
                servierSide: true,
                responsive: true,
                ajax: '{{ route('lands.index') }}',
                columnDefs: [{
                    "width": "20%",
                    "targets": -1
                }],
                columns: [{
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'name',
                        name: 'name',

                    },
                    {
                        data: 'description',
                        name: 'description'
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
    </script>
@endsection
