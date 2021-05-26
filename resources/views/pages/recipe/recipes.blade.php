@extends('layouts.v1')

@section('content')
    <h1 class="pt-3 title is-4">
        Рецепти
    </h1>
    <div class="columns is-align-items-flex-start mb-5">
        <div class="box column  mr-5">
            <x-recipes-filter :categories="$categories" />
        </div>
        <div class="box column is-two-thirds is-flex is-flex-wrap-wrap is-justify-content-space-evenly">
            @each('components.recipe-item', $recipes, 'recipe', 'components.empty')
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.27.0/slimselect.min.js"></script>
    <script>
        new SlimSelect({
        select: '#multiple',
        placeholder: 'назви категорії',
        searchPlaceholder: 'пошук',
        });
    </script>
@endsection


@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.27.0/slimselect.min.css" rel="stylesheet"></link>
@endsection

