<a href="{{route('recipe.show',['recipe' => $recipe->id])}}" class="card mb-5 card-recipe">
    <div class="card-image">
        <figure class="image is-4by3">
            <div class="time-preparing">
                <div title="Час приготування" class="time-preparing-item">
                    {{$recipe->time_preparing}} хв.
                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                </div>
                <div title="Порції" class="count-feed">
                    <p>{{$recipe->count_feed}}</p>
                    <img src="{{asset('images/dinner.png')}}" alt="{{$recipe->count_feed}}">
                </div>
            </div>
            <img src="{{asset('storage/' . $recipe->background)}}" alt="{{$recipe->background}}">
        </figure>
    </div>
    <div class="card-content  pt-2 pl-2 pr-2 pb-2">
        <p class="is-size-6 pb-2">{{Str::limit($recipe->title, 30)}}</p>
        <div class="content has-text-right">
            <i class="fa fa-plus" aria-hidden="true"></i>
            <time datetime="{{$recipe->created_at->format('d-m-Y')}}">{{$recipe->created_at->format('d-m-Y')}}</time>
        </div>
    </div>
</a>
