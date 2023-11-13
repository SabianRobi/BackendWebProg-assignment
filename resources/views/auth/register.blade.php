@extends('layouts.mainBody')

@section('title', 'Register')

@section('content')
<h3>Register</h3>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="d-flex justify-content-center">
            <div class="rounded p-2 w-50" style="background-color: #ffffff3c">
                <!-- Name -->
                <div class="mb-2">
                    <label for="name" class="mb-1">Name</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="mb-2">
                    <label for="email" class="mb-1">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" autocomplete="email">
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
                        name="password" autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-2">
                    <label for="password_confirmation" class="mb-1">Confirm password</label>
                    <input id="password_confirmation" type="password"
                        class="form-control @error('password_confirmation') is-invalid @enderror"
                        name="password_confirmation">
                    @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Register button -->
                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="ml-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </div>
        </div>
    </form>
@endsection
