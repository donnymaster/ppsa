<div>
    <h2 class="is-size-4 has-text-centered pb-3">Фільтри</h2>
    <form action="{{route('blog.index')}}">
        <div class="range-parent">
            <label class="label">
                Тривалість читання:
                <span class="range-time">1-300</span>
                хвилин
            </label>
            <span class="field multi-range is-block">
                <input type="range" min="1" max="300" value="1" class="lower">
                <input type="range" min="1" max="300" value="300" class="upper">
           </span>
           <input class="value-time" type="hidden" name="reading_time">
           <input class="url-param" type="text" hidden value="{{request()->get('reading_time')}}">
        </div>
        <hr />
        <div class="field search-parent" data-id="doctor_id" data-show="name,surname">
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
        <div class="field">
            <label class="label">
                Пошук
                <x-info position="is-left">
                    Пошук здійснюється по назві і змісту
                </x-info>
            </label>
            <input class="input" type="text" name="search" value="{{request()->get('search')}}">
        </div>
        <div class="is-flex is-justify-content-flex-end">
            <button class="button is-link mr-3" type="submit">Показати</button>
            <a href="{{route('blog.index')}}" class="button is-success">Скинути фільтри</a>
        </div>
    </form>
</div>
