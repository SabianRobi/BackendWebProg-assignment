@extends('layouts.mainBody')

@section('title', 'Error 403')

@section('content')
    <div class="row">
        <div class="col-12">
            <h2 class="text-danger mb-5">Error 403: You don't have permission to view this page!</h2>
            <p><a href="{{ route('welcome') }}">Click here to return to home</a></p>
        </div>
    </div>
@endsection