@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $document->name }}</h1>
        <div>{!! $content !!}</div>
    </div>
@endsection
