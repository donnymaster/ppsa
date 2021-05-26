@extends('layouts.v1')

@section('content')
    <h2 class="pt-3 title is-4 has-text-centered">
        Форма створення нового рецепта
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
        <form action="{{route('recipe.store')}}" method="post" enctype="multipart/form-data">
            @csrf
        <div class="columns">
            <div class="column" style="border-right: 2px solid whitesmoke">
                <div class="field">
                    <label class="label">Назва <span class="has-text-danger">*</span></label>
                    <div class="control">
                      <input class="input" type="text" name="title" required>
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
                      <input class="input" type="number" name="time_preparing">
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
                      <input class="input" type="number" name="count_feed">
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
                                {{in_array($category->id, request()->get("category") ?? []) ? 'selected' : ''}}
                            >
                                {{$category->name}}
                            </option>
                        @empty
                            <option value="">Дані відсутні</option>
                        @endforelse
                    </select>
                </div>
                <div class="field">
                    <div class="file">
                        <label class="file-label">
                        <input class="file-input" type="file" accept="image/png, image/jpeg, image/jpg" name="preview_article">
                        <span class="file-cta">
                            <span class="file-icon">
                            <i class="fa fa-upload"></i>
                            </span>
                            <span class="file-label">
                                прев'ю рецепта...
                            </span>
                        </span>
                        </label>
                    </div>
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
                                </tr>
                            </thead>
                            <tbody>
                               <tr data-id="0">
                                   <td>
                                    <div class="field search-parent" data-id="id" data-show="name">
                                        <input type="hidden" value="/ingredients?search=" class="search-url">
                                        <input class="input input-search" type="text">
                                        <input type="hidden" class="input doctor_id ingredient_id" name="ingredients[0][ingredient_id]">
                                        <div class="wrapped-search-window"></div>
                                    </div>
                                   </td>
                                   <td>
                                    <div class="field">
                                        <div class="control">
                                          <input class="input count" required type="number" min="1" max="1000" name="ingredients[0][count]">
                                        </div>
                                    </div>
                                   </td>
                                   <td>
                                    <div class="select">
                                        <select class="unit" name="ingredients[0][unit]">
                                            @forelse ($units as $unit)
                                                <option value="{{$unit->id}}">
                                                    {{$unit->short_name}}
                                                </option>
                                            @empty
                                                <option value="">Дані відсутні</option>
                                            @endforelse
                                        </select>
                                    </div>
                                   </td>
                               </tr>
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
                        <div class="step" data-id="0">
                            <div class="is-flex is-align-items-flex-end">
                                <div class="field mr-4 is-flex-grow-1">

                                    <label class="label">
                                        Назва
                                    </label>
                                    <div class="control">
                                        <input class="input step-name" type="text" required name="steps[0][title]">
                                    </div>
                                </div>
                                <div class="field mb-3">
                                    <div class="file">
                                        <label class="file-label">
                                        <input class="file-input step-image" type="file" accept="image/png, image/jpeg, image/jpg" name="steps[0][preview]">
                                        <span class="file-cta">
                                            <span class="file-icon">
                                            <i class="fa fa-upload"></i>
                                            </span>
                                            <span class="file-label">
                                                прев'ю кроку...
                                            </span>
                                        </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">
                                    Опис кроку
                                </label>
                                <div class="control">
                                <textarea class="textarea step-body" name="steps[0][body]" placeholder="Опис кроку"></textarea>
                                </div>
                            </div>
                        </div>
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
