@extends('layouts.v1')

@section('content')
    @if (session('error_delete'))
        <div class="title has-text-danger box has-text-centered mt-5 mb-5">
            {{ session('error_delete') }}
        </div>
    @endif
    <h1 class="pt-3 title is-4 has-text-centered">
        {{$recipe->title}}
        <div class="is-inline-flex is-size-6 is-align-items-center">
            <div title="Час приготування">
                {{$recipe->time_preparing}} хв.
                <i class="fa fa-clock-o pr-4" aria-hidden="true"></i>
            </div>
           <div class="is-flex" title="Порції">
                <p class="pr-1">{{$recipe->count_feed}}</p>
                <img class="image is-16x16" src="{{asset('images/dinner-black.png')}}" alt="{{$recipe->count_feed}}">
            </div>
           @if (Auth::user() && Auth::user()->isDoctor())
                <a class="pl-2 print-hide" href="{{route('recipe.edit', ['recipe' => $recipe->id])}}">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                </a>
                <a
                class="pl-2 print-hide"
                onclick="event.preventDefault();
                         document.getElementById('delete-recipe').submit();"
                href="#">
                    <i class="fa fa-trash-o has-text-danger" aria-hidden="true"></i>
                </a>
                <form id="delete-recipe" action="{{route('recipe.destroy', ['recipe' => $recipe->id])}}" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
            <i class="fa fa-print print-hide pl-3 is-clickable has-text-link" aria-hidden="true" onclick="window.print();"></i>
        </div>
    </h1>
    <div class="box mb-6">
        <div class="columns">
            <div class="column recipe-img">
                <figure class="image is-3by2 lightgallery">
                    <img src="{{asset('storage/' . $recipe->background)}}" alt="{{$recipe->background}}">
                </figure>
            </div>
            <div class="column is-two-fifths">
                <div class="ingredients">
                    <div class="ingredients-title is-size-4 pb-3">
                        Інгредієнти
                    </div>
                    <table class="table is-bordered">
                        <thead>
                          <tr>
                            <th>Назва</th>
                            <th>Кількість</th>
                            <th>Одиниці виміру</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse ($recipe->ingredients as $item)
                            <tr>
                                <td>
                                    {{$item->ingredient->name}}
                                </td>
                                <td>
                                    {{$item->count}}
                                </td>
                                <td>
                                    {{$item->unit->short_name}}
                                    <x-info>
                                        {{$item->unit->name}}
                                    </x-info>
                                </td>
                            </tr>
                          @empty
                              @include('components.empty')
                          @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="column print-hide">
                <div class="title is-size-4">
                    Категорії
                </div>
                <div class="tags">
                    @forelse ($recipeCategories as $item)
                        <span class="tag is-primary">{{$item->category->name}}</span>
                    @empty

                    @endforelse
                </div>
            </div>
        </div>
        <div class="title">Кроки рецепта</div>
        <div class="is-flex is-flex-direction-column">
            @forelse ($recipe->steps as $step)
                <div class="pb-4">
                    <div class="is-size-4 pb-3">
                        {{$loop->iteration}})
                        {{$step->title}}
                    </div>
                    <div class="is-flex">
                        <p class="lightgallery">
                            <img class="img-in-text" src="{{asset('storage/' . $step->img_path)}}" alt="{{$step->img_path}}">
                            {{$step->description}}
                        </p>
                    </div>
                </div>
            @empty
                @include('components.empty')
            @endforelse
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('js/vendor/img-previewer.min.js')}}"></script>
@endsection
