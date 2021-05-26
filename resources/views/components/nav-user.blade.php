<nav class="navbar custom-navbar" role="navigation" aria-label="main navigation">
    <a href="{{route('blog.index')}}" class="navbar-item mr-2 border-hover">
        Статті
    </a>
    <a href="{{route('recipe.index')}}" class="navbar-item border-hover">
        Рецепти
    </a>
    <a href="{{route('doctors.get')}}" class="navbar-item mr-2 border-hover">
        Лікарі
    </a>
    <a href="{{route('directory')}}" class="navbar-item border-hover">
        Довідник
    </a>
    <div class="is-flex is-justify-content-center is-hidden-desktop" id="close-menu">
        <i class="fa fa-times is-size-5 is-clickable pt-2" aria-hidden="true"></i>
    </div>
</nav>
