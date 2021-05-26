@extends('layouts.v1')

@section('content')
    <h1 class="pt-3 title is-4">Статті</h1>
    <div class="columns is-align-items-flex-start mb-5 mobile-content">
        <div class="box column is-two-thirds mr-5">
            @each('components.article', $articles, 'article', 'components.empty')
            <div class="mt-4">
                {{ $articles->withQueryString()->onEachSide(1)->links('components.pagination') }}
            </div>
        </div>
        <div class="box column">
            <x-articles-filter />
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('js/vendor/img-previewer.min.js')}}"></script>
@endsection
