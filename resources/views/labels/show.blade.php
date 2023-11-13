@extends('layouts.mainBody')

@section('title', 'Label: ' . $label->name)

@section('content')
    @if (Session::has('label'))
        <div class="w-25 alert alert-success" role="alert">
            {{ Session::get('label') }}
        </div>
    @endif

    <h2>
        <span class="p-2 rounded" style="background-color: {{ $label->color }}">
            {{ $label->name }}
        </span>
        @if (Gate::allows('edit-label', Auth::user()))
            <a class="text-xl" role="button" href="{{ route('labels.edit', $label) }}">
                <i class="ml-2 fa-solid fa-pen-to-square"></i>
            </a>
        @endif
        @if (Gate::allows('delete-item', Auth::user()))
            <a class="text-xl" role="button" onclick="document.querySelector('#delete-label-form').submit();">
                <i class="ml-2 fa-solid fa-trash"></i>
            </a>
        @endif
    </h2>

    <!-- Delete form -->
    <form id="delete-label-form" action="{{ route('labels.destroy', $label) }}" method="POST" class="d-none">
        @method('DELETE')
        @csrf
    </form>

    <div class="row">
        <div class="col">

            <h3 class="mt-5 mb-3 text-left">Items labeled with this</h3>
            <div class="row mb-4">
                @forelse (($label->items)->sortByDesc('obtained') as $item)
                    <div class="col-md-3 col-4">
                        <a href="{{ route('items.show', $item->id) }}" class="overlay-img">
                            <img
                                src="
                                        @if (isset($item->image)) {{ $item->image }}
                                        @else
                                            {{ asset('img/defaultItem.jpg') }} @endif
                                    ">
                            <div class="overlay"></div>
                            <div class="des">
                                <h1 class="title">{{ $item->name }}</h1>
                                <h6 class="subtitle">{{ $item->obtained }}</p>
                                    <p>{{ substr($item->description, 0, 80) }}...</p>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="alert">No items in the museum!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

@endsection
