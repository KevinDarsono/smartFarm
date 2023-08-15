<form action="{{ route('lands.devices.update', ['land' => $land->id, 'device' => $device->id]) }}" id="form"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" name="name" id="name"
                    class="form-control  @error('name') is-invalid @enderror" placeholder="Contoh: Node 1"
                    value="{{ $device->name }}">
                @error('name')
                    @include('layouts.components.invalid_feedback', [
                        'message' => $message,
                    ])
                @enderror
            </div>
        </div>
    </div>
    <div class="d-block text-right card-footer">
        <button id="deleteButton" class="mr-2 border-0 btn-lg btn-transition btn btn-outline-danger">Hapus</button>
        <input type="submit" value="Simpan" class="btn btn-success">
    </div>
</form>

@push('js')
    <script>
        $('#deleteButton').click(function(e) {
            e.preventDefault();
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
                    $.ajax({
                        url: "{{ route('lands.devices.destroy', ['land' => $land->id, 'device' => $device->id]) }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: "DELETE"
                        },
                        success: function(data) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            ).then(function() {
                                window.location.href = "{{ route('lands.devices.index', ['land' => $land->id, 'device' => $device->id]) }}";
                            })
                        }
                    });
                }
            })
        })
    </script>
@endpush
