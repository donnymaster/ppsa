
<div class="mb-5 article">
    <div class="title is-size-4 mb-3">
        <a href="{{route('blog.show', ['id' => $article->id])}}">
            {{$article->title}}
        </a>
        @isset($isDoctorEdit)
            <a href="{{route('blog.edit', ['blog' => $article->id])}}">
                <i class="fa fa-pencil is-size-5 pl-2 has-text-success" aria-hidden="true"></i>
            </a>
            <form class="is-inline" id="delete-article-{{$article->id}}" action="{{route('blog.destroy', ['blog' => $article->id])}}" method="POST">
                @csrf
                @method('DELETE')
                <a
                    href="#"
                    onclick="
                        event.preventDefault();
                        document.getElementById('delete-article-{{$article->id}}').submit();
                    "><i class="fa fa-trash is-size-5 pl-2 has-text-danger" aria-hidden="true"></i></a>
            </form>
        @endisset
    </div>
    <div class="is-flex mobile-article">
        <div class="lightgallery" style="min-width: 180px">
            <img class="pr-3 image is-180x180" src="{{asset('storage/' . $article->background_path)}}" alt="200">
        </div>
        <div>
            {{strip_tags(Str::limit($article->body, 400))}}
        </div>
    </div>
    <div class="pt-3">
        <i class="fa fa-plus" aria-hidden="true"></i> {{$article->created_at->format('d-m-Y')}}
        | <i class="fa fa-book" aria-hidden="true"></i> {{$article->reading_time}} хвилин
        | <i class="fa fa-user-md" aria-hidden="true"></i> <a target="_blank" href="{{route('doctor.get', ['id' => $article->doctor->id])}}">{{$article->doctor->user->full_name}}</a>
    </div>
</div>
