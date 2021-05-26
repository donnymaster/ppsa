<div>
    <h2 class="is-size-4 has-text-centered pb-3">Фільтри</h2>
    <form action="{{route('doctors.get')}}">
        <div class="range-parent">
            <label class="label">
                Стаж:
                <span class="range-time">1-100</span>
                років
            </label>
            <span class="field multi-range is-block">
                <input type="range" min="1" max="100" value="1" class="lower">
                <input type="range" min="1" max="100" value="100" class="upper">
           </span>
           <input class="value-time" type="hidden" name="experience">
           <input class="url-param" type="text" hidden value="{{request()->get('experience')}}">
        </div>
        <hr />
        <div class="field">
            <label class="label">
                Пошук по біографії
            </label>
            <input class="input" type="text" name="search_by_biography" value="{{request()->get('search_by_biography')}}">
        </div>
        <div class="is-flex is-justify-content-flex-end">
            <button class="button is-link mr-3" type="submit">Показати</button>
            <a href="{{route('doctors.get')}}" class="button is-success">Скинути фільтри</a>
        </div>
    </form>
</div>
