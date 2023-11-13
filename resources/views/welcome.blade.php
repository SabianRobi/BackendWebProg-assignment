@extends('layouts.mainBody')

@section('content')
    @if (Session::has('auth'))
        <div class="w-25 alert alert-success" role="alert">
            {{ Session::get('auth') }}
        </div>
    @endif
    @if (Session::has('item_deleted'))
        <div class="w-25 alert alert-success" role="alert">
            {{ Session::get('item_deleted') }}
        </div>
    @endif
    @if (Session::has('label_deleted'))
        <div class="w-25 alert alert-success" role="alert">
            {{ Session::get('label_deleted') }}
        </div>
    @endif

    <h3 id="about" class="mb-3">About us</h3>
    <p>In the museum you can find various computer releated techs, such as tapes, floppys, Commodore 64 computers, DDR1
        RAMs, controlles and so on. Everything you can imagine from the early commputer ages to nowadays.</p>

    <h3 id="items" class="mt-5 mb-3">Items</h3>
    <div class="row mb-4">
        @if ($items->count() > 0)
            @foreach ($items as $item)
                <div class="col-md-3 col-4">
                    <a href="{{ route('items.show', $item->id) }}" class="overlay-img">
                        <img src="@if(isset($item->image)){{ asset('storage/'.$item->image) }}@else{{ asset('img/defaultItem.jpg') }}@endif">
                        <div class="overlay"></div>
                        <div class="des">
                            <h1 class="title">{{ $item->name }}</h1>
                            <h6 class="subtitle">{{ $item->obtained }}</p>
                                <p>{{ substr($item->description, 0, 80) }}...</p>
                        </div>
                    </a>
                </div>
            @endforeach
            <div class="col-12">
                {{ $items->links() }}
            </div>
        @else
            <div class="col-12">
                <p class="alert">No items in the museum!</p>
            </div>
        @endif
    </div>

@endsection
