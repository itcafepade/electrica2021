@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    <img src="{{ asset('imgs/logo.png') }}" class="img-fluid">
                    <h1 class="text-center pb-3 pt-3">
                        {{ __('auth.Login') }}
                    </h1>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row mt-0 mb-0">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-right">{{ __('auth.email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mt-0 mb-0">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right g-0">{{ __('auth.Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mt-0 mb-0">
                            <div class="col-md-6 offset-md-4 mt-0 mb-0">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label mb-0 mt-0" for="remember">
                                        {{ __('auth.remember') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mt-0 mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary text-white">
                                    {{ __('auth.Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('auth.Forgot') }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
