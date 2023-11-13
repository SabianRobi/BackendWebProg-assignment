@extends('layouts.mainBody')

@section('title', 'Add label')

@section('scripts')
    @vite(['resources/js/createLabel.js'])
@endsection

@section('content')
    <h3>Add label</h3>
    <form method="POST" action="{{ route('labels.store') }}">
        @csrf

        <div class="d-flex justify-content-center">
            <div class="rounded p-2 w-50" style="background-color: #ffffff3c">

                @if (Session::has('label_created'))
                    <div class="alert alert-success" role="alert">
                        Label ({{ Session::get('label_created') }}) created!
                    </div>
                @endif

                <!-- Name -->
                <div class="mb-2">
                    <label for="name" class="mb-1">Name</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name') }}" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Color -->
                <div class="mb-2">
                    <label for="color" class="mb-1">Color</label>
                    <div class="row">
                        <!-- Text -->
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="hashtag">#</span>
                                <input id="color" type="text"
                                    class="form-control form-control-color @error('color') is-invalid @enderror"
                                    name="color" value="{{ old('color') != null ? old('color') : 'ffffff' }}"
                                    aria-describedby="hashtag">
                                @error('color')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Color wheel -->
                        <div class="col">
                            <input id="colorWheel" type="color"
                                class="form-control @error('colorWheel') is-invalid @enderror" name="colorWheel"
                                value="{{ old('colorWheel') != null ? old('colorWheel') : '#ffffff' }}">
                            @error('colorWheel')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>


                <!-- Display -->
                <div class="mb-2 form-check">
                    <input id="display" type="checkbox" class="form-check-input @error('display') is-invalid @enderror"
                        name="display" {{ old('display') == "on" ? "checked" : ""}} />
                    <label for="display" class="mb-1 form-check-label">Display</label>
                    @error('display')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Add button -->
                <div class="flex items-center justify-end mt-3">
                    <x-primary-button class="ml-3">
                        {{ __('Add') }}
                    </x-primary-button>
                </div>
            </div>
    </form>

@endsection
