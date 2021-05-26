@extends('layouts.v1')

@section('content')
    <h2 class="pt-3 title is-4 has-text-centered">
        Редагувати: {{ $article->title }}
    </h2>
    <div class="box mb-5">
        <form class="form" method="POST" action="{{ route('blog.update', ['blog' => $article->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                <div class="is-flex is-justify-content-space-evenly is-align-items-flex-end">
                    <div class="field is-flex-grow-5 mr-5">
                        <label class="label">Назва <span class="has-text-danger">*</span></label>
                        <div class="control">
                            <input
                            name="title"
                            class="input @error('title') is-danger @enderror"
                            type="text"
                            required
                            placeholder="Топ 5 продуктів для дітей аутистів"
                            value="{{$article->title}}"
                            >
                        </div>
                        <x-error name="title" />
                    </div>
                    <div class="field is-flex-grow-1 mr-5">
                        <label class="label">Час прочитання (хвилини) <span class="has-text-danger">*</span></label>
                        <div class="control">
                            <input
                            name="reading_time"
                            class="input @error('reading_time') is-danger @enderror"
                            type="number"
                            required
                            min="1"
                            max="300"
                            value="{{$article->reading_time}}"
                            >
                        </div>
                        <x-error name="reading_time" />
                    </div>
                    <div class="field pb-3">
                        <div class="file">
                            <label class="file-label">
                            <input class="file-input" accept="image/png, image/jpeg, image/jpg" type="file" name="preview_article">
                            <span class="file-cta">
                                <span class="file-icon">
                                <i class="fa fa-upload"></i>
                                </span>
                                <span class="file-label">
                                    прев'ю статті…
                                </span>
                            </span>
                            </label>
                        </div>
                        <x-error name="preview_article" />
                    </div>
                </div>
                <div class="field tiny-wrapped">
                    <label class="label">Зміст статті <span class="has-text-danger">*</span></label>
                    <div class="placeholder-item"></div>
                    <textarea class="tiny-init is-hidden" name="body">{{$article->body}}</textarea>
                    <x-error name="body" />
                </div>
                <div class="field is-grouped is-grouped-centered pt-2">
                    <p class="control">
                      <button type="submit" class="button is-primary">
                        Зберегти
                      </button>
                    </p>
                </div>
        </form>
    </div>
@endsection

@section('js')
    <script defer src="https://cdn.tiny.cloud/1/e953kue889bd5i7wplz1yrnk954nql0gimt96aucgsl9i4rp/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
@endsection
