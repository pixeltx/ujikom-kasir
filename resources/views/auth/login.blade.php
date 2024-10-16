@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 92.3vh; background-color: #59b0e8;">
    <div class="card" style="width: 450px; height: 320px;">
        <div class="card-body">
            <h3 class="text-center mb-4">{{ __('Login') }}</h3>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter Email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter Password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Log In') }}
                    </button>
                </div>

                <div class="text-center">
                    <small>
                        @if (Route::has('password.request'))
                            <a class="btn btn-link p-0" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </small>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
