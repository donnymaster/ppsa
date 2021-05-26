@extends('layouts.v1')

@section('content')
    <h2 class="pt-3 title is-4 has-text-centered">
        Форма редагування рецепта: {{$recipe->title}}
    </h2>
    @if($errors->count())
        <div class="box">
            <div class="title has-text-danger">Помилки при створенні рецепта</div>
            @foreach ($errors->all() as $error)
                <div class="has-text-danger">{{$loop->iteration}}){{ $error }}</div>
            @endforeach
        </div>
    @endif
    <div class="box mb-5">
        <form action="{{route('recipe.update', ['recipe' => $recipe->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        <div class="columns">
            <div class="column" style="border-right: 2px solid whitesmoke">
                <div class="field">
                    <label class="label">Назва <span class="has-text-danger">*</span></label>
                    <div class="control">
                      <input class="input" type="text" name="title" value="{{$recipe->title}}" required>
                    </div>
                </div>
                <div class="field">
                    <label class="label">
                        Час приготування <span class="has-text-danger">*</span>
                        <x-info>
                            min 1, max 100 (хв.)
                        </x-info>
                    </label>
                    <div class="control">
                      <input class="input" type="number" name="time_preparing" value="{{$recipe->time_preparing}}">
                    </div>
                </div>
                <div class="field">
                    <label class="label">
                        Кількість порцій <span class="has-text-danger">*</span>
                        <x-info>
                            min 1, max 100 (порцій)
                        </x-info>
                    </label>
                    <div class="control">
                      <input class="input" type="number" name="count_feed" value="{{$recipe->count_feed}}">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="label">
                        Категорії <span class="has-text-danger">*</span>
                    </label>
                    <select id="multiple" name="category[]" multiple>
                        @forelse ($categories as $category)
                            <option
                                value="{{$category->id}}"
                                {{in_array($category->id, $catId) ? 'selected' : ''}}
                            >
                                {{$category->name}}
                            </option>
                        @empty
                            <option value="">Дані відсутні</option>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="column is-three-quarters">
                <div class="ingredients-items ingredients-main">
                    <div class="is-flex is-align-content-center">
                        <h3 class="is-size-5">
                            Інгредієнти <span class="has-text-danger">*</span>
                        </h3>
                        <div class="is-align-self-flex-end pl-2 is-size-5">
                            <x-info>
                                min 1, max 20
                            </x-info>
                        </div>
                        <div class="plus pl-3 pr-2 has-text-success is-clickable">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </div>
                        <div class="minus has-text-danger is-clickable">
                            <i class="fa fa-minus" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="ingredients-wrapped">
                        <table class="table is-bordered percent-100">
                            <thead>
                                <tr>
                                    <th>Назва</th>
                                    <th>
                                        Кількість
                                        <x-info>
                                            min 1, max 1000
                                        </x-info>
                                    </th>
                                    <th>Одиниці виміру</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recipe->ingredients as $item)
                                    <tr data-id="{{$loop->index}}">
                                        <td>
                                            <div class="field search-parent" data-id="id" data-show="name">
                                                <input type="hidden" value="{{$item->id}}" name="ingredients[{{$loop->index}}][recipe_ingredient_id]">
                                                <input type="hidden" value="/ingredients?search=" class="search-url">
                                                <input class="input input-search" type="text" value="{{$item->ingredient->name}}">
                                                <input type="hidden" class="input doctor_id ingredient_id" value="{{$item->ingredient->id}}" name="ingredients[{{$loop->index}}][ingredient_id]">
                                                <div class="wrapped-search-window"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="field">
                                                <div class="control">
                                                <input value="{{$item->count}}" class="input count" required type="number" min="1" max="1000" name="ingredients[{{$loop->index}}][count]">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="select">
                                                <select class="unit" name="ingredients[{{$loop->index}}][unit]">
                                                    @forelse ($units as $unit)
                                                        <option
                                                            value="{{$unit->id}}"
                                                            {{$item->unit_id === $unit->id ? 'selected' : null}}
                                                        >
                                                            {{$unit->short_name}}
                                                        </option>
                                                    @empty
                                                        <option value="">Дані відсутні</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </td>
                                        <td class="par-link">
                                            <a class="pl-2 link-step-ingredient" href="{{route('recipe.delete.ingredient', ['ingredient' => $item->id])}}">
                                                <i class="fa fa-trash-o has-text-danger" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr />
                <div class="steps-main">
                    <div class="title-step is-flex is-justify-content-center">
                        <h3 class="is-size-4 pb-4 has-text-centered">
                            Кроки рецепта <span class="has-text-danger">*</span>
                        </h3>
                        <div class="pl-2 is-size-5">
                            <x-info>
                                min 1, max 10
                            </x-info>
                        </div>
                        <div class="plus pl-3 pr-2 has-text-success is-clickable">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </div>
                        <div class="minus has-text-danger is-clickable">
                            <i class="fa fa-minus" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="steps-items">
                        @foreach ($recipe->steps as $step)
                            <div class="step" data-id="{{$loop->index}}">
                                <input type="hidden" class="idx-step" value="{{$step->id}}" name="steps[{{$loop->index}}][step_id]">
                                <div class="is-flex is-align-items-flex-end">
                                    <div class="field mr-4 is-flex-grow-1">
                                        <label class="label is-flex">
                                            <p>Назва</p>
                                            <a class="pl-2 link-step-del" href="{{route('recipe.delete.step', ['step' => $step->id])}}">
                                                <i class="fa fa-trash-o has-text-danger" aria-hidden="true"></i>
                                            </a>
                                        </label>
                                        <div class="control">
                                            <input value="{{$step->title}}" class="input step-name" type="text" required name="steps[{{$loop->index}}][title]">
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">
                                        Опис кроку
                                    </label>
                                    <div class="control">
                                    <textarea class="textarea step-body" name="steps[{{$loop->index}}][body]" placeholder="Опис кроку">{{$step->description}}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="field is-grouped is-grouped-centered pt-2">
                    <p class="control">
                      <button type="submit" class="button is-primary">
                        Зберегти
                      </button>
                    </p>
                </div>
            </div>
        </div>
        </form>
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
