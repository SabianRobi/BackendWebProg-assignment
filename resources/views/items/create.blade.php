@extends('layouts.mainBody')

@section('title', 'Add item')

@section('scripts')
    <script>
        const coverImageInput = document.querySelector('input#image');
        const coverPreviewContainer = document.querySelector('#cover_preview');
        const coverPreviewImage = document.querySelector('img#cover_preview_image');

        coverImageInput.onchange = event => {
            const [file] = coverImageInput.files;
            if (file) {
                coverPreviewContainer.classList.remove('d-none');
                coverPreviewImage.src = URL.createObjectURL(file);
            } else {
                coverPreviewContainer.classList.add('d-none');
            }
        }
    </script>
@endsection

@section('content')
    <h3>Add item</h3>
    <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="d-flex justify-content-center">
            <div class="rounded p-2 w-50" style="background-color: #ffffff3c">

                @if (Session::has('item_created'))
                    <div class="alert alert-success" role="alert">
                        Item ({{ Session::get('item_created') }}) created!
                    </div>
                @endif

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

                <!-- Description -->
                <div class="mb-2">
                    <label for="description" class="mb-1">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                        cols="30" rows="6">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Obtained -->
                <div class="mb-2">
                    <label for="obtained" class="mb-1">Obtained</label>
                    <input id="obtained" type="datetime-local" max="<?= date('Y-m-d') . 'T' . date('H:i') ?>"
                        class="form-control
                        @error('obtained')
is-invalid
@enderror" name="obtained"
                        value="{{ old('obtained') }}">
                    @error('obtained')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Labels -->
                <div class="mb-2">
                    <div class="row">
                        @forelse ($labels as $label)
                            <div class="form-check col-3">
                                <input type="checkbox" class="form-check-input" value="{{ $label->id }}"
                                    id="label-{{ $label->id }}" name="labels[]" @checked(is_array(old('labels')) && in_array(strval($label->id), old('labels', [])))>
                                <label for="label-{{ $label->id }}" class="form-check-label m-1 rounded"
                                    style="background-color: {{ $label->color }}">
                                    <span class="badge">{{ $label->name }}</span>
                                </label>
                            </div>
                        @empty
                            <p>No labels found</p>
                        @endforelse
                    </div>
                </div>


                <!-- Image -->
                <div class="mb-2">
                    <label for="image" class="mb-1">Image</label>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <input type="file" class="form-control-file" id="image" name="image">
                        </div>
                        <div id="cover_preview" class="col-12 d-none">
                            <p>Image preview:</p>
                            <img class="img" id="cover_preview_image" src="#" alt="Cover preview">
                        </div>
                    </div>
                    @error('image')
                        <span class="text-danger" role="alert">
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
