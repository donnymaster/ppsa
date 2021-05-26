@extends('layouts.v1')

@section('content')
    <h1 class="pt-3 title is-4">Мои статті</h1>
    <div class="columns is-align-items-flex-start mb-5">
        <div class="box column is-two-thirds mr-5">
            @forelse ($articles as $article)
                @include('components.article', ['article' => $article, 'isDoctorEdit' => true])
            @empty
                @include('components.empty')
            @endforelse
            <div class="mt-4">
                {{ $articles->onEachSide(1)->links('components.pagination') }}
            </div>
        </div>
        <div class="box column">
            <x-articles-filter-doctor />
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('js/vendor/img-previewer.min.js')}}"></script>
@endsection
