@extends('layouts.mainBody')

@section('title', 'Edit label')

@section('scripts')
    @vite(['resources/js/createLabel.js'])
@endsection

@section('content')
    <h3>Edit label ({{ $label->name }})</h3>
    <form method="POST" action="{{ route('labels.update', $label) }}">
        @method('PUT')
        @csrf

        <div class="d-flex justify-content-center">
            <div class="rounded p-2 w-50" style="background-color: #ffffff3c">

                @if (Session::has('label_updated'))
                    <div class="alert alert-success" role="alert">
                        Label ({{ Session::get('label_updated') }}) updated!
                    </div>
                @endif

                <!-- Name -->
                <div class="mb-2">
                    <label for="name" class="mb-1">Name</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name"
                        value="@empty(old('name')){{ $label->name }}@else{{ old('name') }}@endempty"
                        autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Color -->
                <div class="mb-2">
                    <label for="color" class="mb-1">Color:</label>
                    <div class="row">
                        <!-- Text -->
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="hashtag">#</span>
                                <input id="color" type="text"
                                    class="form-control form-control-color @error('color') is-invalid @enderror"
                                    name="color"
                                    value="@empty(old('color'))<?= substr($label->color, 1) ?>@else<?= old('color') ?>@endempty"
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
                                value="@empty(old('colorWheel')){{ $label->color }}@else{{ old('colorWheel') }}@endempty">
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
                    <p>Display</p>
                    <div>
                        <input type="radio" class="form-check-input" name="display" id="display-yes" value="display-yes"
                        @if(old('display') !== null)
                            @checked(old('display') == 'display-yes')
                        @else
                            @checked($label->display)
                        @endif
                        >
                        <label for="display-yes" class="ml-2 form-check-label">Yes</label>
                    </div>
                    <div>
                        <input type="radio" class="form-check-input" name="display" id="display-no" value="display-no"
                        @if(old('display') !== null)
                            @checked(old('display') == 'display-no')
                        @else
                            @checked(!($label->display))
                        @endif
                        >
                        <label for="display-no" class="ml-2 form-check-label">No</label>
                    </div>
                    @error('display')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Add button -->
                <div class="flex items-center justify-end mt-3">
                    <x-primary-button class="ml-3">
                        {{ __('Edit') }}
                    </x-primary-button>
                </div>
            </div>
    </form>

@endsection
