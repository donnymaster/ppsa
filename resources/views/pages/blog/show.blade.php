@extends('layouts.v1')

@section('content')
    <div class="title">
        {{ $article->title }}
    </div>
    <div class="columns is-align-items-flex-start mb-5">
        <div class="box column is-two-thirds mr-5 print-show">
            <div class="content">
                {!!$article->body!!}
            </div>
        </div>
        <div class="column print-hide">
            <div class="box">
                <figure class="image lightgallery">
                    <img src="{{asset('storage/' . $article->background_path)}}" alt="image article">
                </figure>
            </div>
            <button class="percent-100 button is-success" onclick="window.print();">Версія для друку</button>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('js/vendor/img-previewer.min.js')}}"></script>
@endsection
