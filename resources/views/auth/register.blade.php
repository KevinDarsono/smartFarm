@extends('layouts.app')
@section('meta_title', 'Admin Login')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 app-page-title bg-transparent">
                <div class="">
                    <div class="page-title-heading justify-content-center">
                        <div class="page-title-icon">
                            <i class="bi bi-box-arrow-in-right icon-gradient bg-mean-fruit">
                            </i>
                        </div>
                        <div>
                            Register
                            <div class="page-title-subheading">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center align-items-center">
            <div class="col-md-4">
                <div class="card">

                    <div class="card-body">
                        <form method="POST" action="{{ route('auth.register.check') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-12 col-form-label"><strong>{{ __('Username') }}</strong></label>

                                <div class="col-md-12">
                                    <input id="name" type="text"
                                           class="form-control @error('text') is-invalid @enderror" name="name"
                                           value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-12 col-form-label"><strong>{{ __('E-Mail Address') }}</strong></label>

                                <div class="col-md-12">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-12 col-form-label"><strong>{{ __('Password') }}</strong></label>

                                <div class="col-md-12">
                                    <input id="password" type="text"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
