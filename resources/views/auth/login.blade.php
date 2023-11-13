@extends('layouts.mainBody')

@section('title', 'Login')

@section('content')
<h3>Login</h3>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="d-flex justify-content-center">
            <div class="rounded p-2 w-50" style="background-color: #ffffff3c">

                <!-- Email Address -->
                <div class="mb-2">
                    <label for="email" class="mb-1">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-2">
                    <label for="password" class="mb-1">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Login button -->
                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('register'))
                        <a class="underline text-sm" href="{{ route('register') }}">
                            {{ __('Don\'t have an account?') }}
                        </a>
                    @endif

                    <x-primary-button class="ml-3">
                        {{ __('Login') }}
                    </x-primary-button>
                </div>
            </div>
    </form>

@endsection
