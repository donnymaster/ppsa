@extends('layouts.v1')

@section('content')
    <div class="title has-text-centered">
        {{ $article->title }}
    </div>
    <div class="box">
        <figure class="image">
            <img src="{{asset('storage/' . $article->background_path)}}" alt="image article">
        </figure>
        {!! $article->body !!}
    </div>
@endsection
