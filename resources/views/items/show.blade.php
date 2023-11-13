@php
    $displayableLabels = $item->labels->filter(function ($label) {
        return $label->display;
    });
@endphp

@extends('layouts.mainBody')

@section('title', 'Item: ' . $item->name)

@section('content')
    @if (Session::has('comment'))
        <div class="w-25 alert alert-success" role="alert">
            {{ Session::get('comment') }}
        </div>
    @endif

    <!-- Item infos (img, title, desc)-->
    <div class="row">
        <div class="col-xs-12 col-sm-5 col-md-4 col-lg-3">
            <img src="
                @if (isset($item->image)) {{ asset('storage/'.$item->image) }}
                @else {{ asset('img/defaultItem.jpg') }} @endif
                "
                class="img img-fluid rounded float-start d-block">
        </div>
        <div class="col">
            <h2 class="text-left">{{ $item->name }}
                @if (Gate::allows('delete-item', Auth::user()))
                    <a class="text-xl" role="button" onclick="document.querySelector('#delete-item-form').submit();">
                        <i class="fa-solid fa-trash"></i></a>
                @endif
            </h2>
            <p class="text-justify">{{ $item->description }}</p>
        </div>
    </div>

    <!-- Delete form -->
    <form id="delete-item-form" action="{{ route('items.destroy', $item) }}" method="POST" class="d-none">
        @method('DELETE')
        @csrf
    </form>

    <!-- Obtained date -->
    <div>
        <p class="text-right font-italic text-sm">Obtained at: {{ $item->obtained }}</p>
    </div>

    <!-- Labels -->
    <div class="text-right">
        @forelse ($displayableLabels as $label)
            <a href="{{ route('labels.show', $label->id) }}" class="p-1 mr-1 rounded"
                style="background-color: {{ $label->color }}">
                <p class="badge d-inline">{{ $label->name }}</p>
            </a>
        @empty
            @if ($item->labels->count() > 0)
                <p>Associated with non displayable label</p>
            @else
                <p>Not associated with any label</p>
            @endif
        @endforelse
    </div>

    <!-- Write comment -->
    <h2 class="text-left">Write comment</h2>
    @auth
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-5">
                <form action="{{ route('comments.store', $item) }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="form-group mb-2">
                        <label hidden for="text">Write comment</label>
                        <textarea class="form-control @error('text') is-invalid @enderror" name="text" id="text" rows="4"></textarea>
                        @error('text')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <input type="text" hidden name="itemId" id="itemId" value="{{ $item->id }}">
                    </div>
                    <input type="submit" value="Publish" class="btn btn-success d-block">
                </form>
            </div>
        </div>
    @else
        <p class="text-left"><a href="{{ route('login') }}">Login to write comments!</a></p>
    @endauth


    <!-- Comments -->
    <div class="row">
        @forelse ($item->comments->sortByDesc('updated_at') as $comment)
            <div class="col-12 col-md-6">
                <div class="commentcard">
                    <p class="author mb-0 mt-2 font-bold text-left">{{ $comment->user->name }}</p>
                    <div class="commentDate">
                        <p class="text-justify mb-1">{{ $comment->text }}</p>
                        <p class="text-xs text-right font-italic">{{ $comment->updated_at }}
                            @if (Gate::allows('edit-comment', $comment))
                                <a class="text-xl" role="button" onclick="editComment(this)">
                                    <i class="ml-2 fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if (Gate::allows('delete-comment', $comment))
                                <a class="text-xl" role="button"
                                    onclick="document.querySelector('#delete-comment-form-{{ $comment->id }}').submit();">
                                    <i class="ml-2 fa-solid fa-trash"></i>
                                </a>
                            @endif
                        </p>
                        <div class="d-none">
                            @if (Gate::allows('edit-comment', $comment))
                                <div class="">
                                    <form action="{{ route('comments.update', $comment) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <textarea class="form-control @error('comment-{{$comment->id}}') is-invalid @enderror" name="comment-{{$comment->id}}" id="comment-{{$comment->id}}"
                                        rows="4">@if (null !== old('comment-{{$comment->id}}'))old('comment-{{$comment->id}}')@else{{ $comment->text }}@endif</textarea>
                                        
                                        @error('comment-'.$comment->id)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        
                                        <input hidden type="text" value="{{ $item->id }}" name="itemId" id="itemId">
                                        <input type="submit" value="Edit" class="btn btn-success text-right">
                                    </form>
                                </div>
                            @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Delete form -->
            <form id="delete-comment-form-{{ $comment->id }}" action="{{ route('comments.destroy', $comment) }}"
                method="POST" class="d-none">
                @method('DELETE')
                @csrf
            </form>
        @empty
            <div class="row">
                <div class="col-12">
                    <p>There are no comments for this item.</p>
                </div>
            </div>
        @endforelse
    </div>
@endsection

@section('scripts')
    <script>
        function editComment(e) {
            e.parentNode.nextSibling.nextSibling.classList.toggle('d-none');
        }
    </script>
@endsection
