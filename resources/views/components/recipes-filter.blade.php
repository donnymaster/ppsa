<div>
    <h2 class="is-size-4 has-text-centered pb-3">Фільтри</h2>
    <form action="{{route('recipe.index')}}">
        <div class="field search-parent" data-id="id" data-show="name,surname">
            <label class="label">
                Лікар
                <x-info position="is-left">
                    Пошук здійснюється по прізвищу
                </x-info>
            </label>
            <input type="hidden" value="/doctor-search?doctor=" class="search-url">
            <input autocomplete="off" class="input input-search" type="text" name="doctor-full" value="{{request()->get('doctor-full')}}">
            <input type="hidden" class="input doctor_id" name="doctor_id" value="{{request()->get('doctor_id')}}">
            <div class="wrapped-search-window"></div>
        </div>
        <hr />
        <div class="range-parent">
            <label class="label">
                Час приготування:
                <span class="range-time">1-100</span>
                хвилин
            </label>
            <span class="field multi-range is-block">
                <input type="range" min="1" max="100" value="1" class="lower">
                <input type="range" min="1" max="100" value="100" class="upper">
           </span>
           <input class="value-time" type="hidden" name="time_preparing">
           <input class="url-param" type="text" hidden value="{{request()->get('time_preparing')}}">
        </div>
        <hr />
        <div class="range-parent">
            <label class="label">
                Кількість порцій:
                <span class="range-time">1-20</span>
                порцій
            </label>
            <span class="field multi-range is-block">
                <input type="range" min="1" max="20" value="1" class="lower">
                <input type="range" min="1" max="20" value="20" class="upper">
           </span>
           <input class="value-time" type="hidden" name="count_feed">
           <input class="url-param" type="text" hidden value="{{request()->get('count_feed')}}">
        </div>
        <hr />
        <div>
            <label class="label">
                Категорії
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
        <hr />
        <div class="is-flex is-justify-content-flex-end">
            <button class="button is-link mr-3" type="submit">Показати</button>
            <a href="{{route('recipe.index')}}" class="button is-success">Скинути фільтри</a>
        </div>
    </form>
</div>

