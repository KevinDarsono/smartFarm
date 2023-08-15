@extends('admin.layouts.base')

@section('meta_title', 'Edit User')
@section('page_title', 'Edit User')
@section('page_title_icon')
    <i class="metismenu-icon bi bi-people"></i>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <form action="{{ route('users.update', $edit->id) }}" method="post" id="form" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" name="name" id="name" value="{{ $edit["name"] }}"
                                           class="form-control  @error('name') is-invalid @enderror">
                                    @error('name')
                                    @include('layouts.components.invalid_feedback', ['message' => $message])
                                    @enderror

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" value="{{ $edit["email"] }}"
                                           class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                    @include('layouts.components.invalid_feedback', ['message' => $message])
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                {{-- <a href="{{ route('users.index') }}" class="btn btn-danger mr-5">Cancel</a> --}}
                                <input type="submit" value="Add" class="btn btn-success">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $('.clone').hide();
        $("#btn-success").click(function () {
            var lsthmtl = $(".clone").html();
            $(".increment").after(lsthmtl);
        });
        $("body").on("click", "#btn-remove", function () {
            $(this).parents(".hdtuto").remove();
        });

    </script>
@endsection
