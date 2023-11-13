@extends('layouts.mainBody')

@section('title', 'Error 404')

@section('content')
    <div class="row">
        <div class="col-12">
            <h2 class="text-danger mb-5">Error 404: Page not found!</h2>
            <p><a href="{{ route('welcome') }}">Click here to return to home</a></p>
        </div>
    </div>
@endsection