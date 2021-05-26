<nav class="navbar custom-navbar" role="navigation" aria-label="main navigation">
    <div class="dropdown navbar-item border-hover">
        <div class="dropdown-trigger">
            <div class="is-clickable" aria-haspopup="true">
                <span class="dropdown-name">Статті</span>
                <span class="icon is-small">
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                </span>
            </div>
        </div>
        <div class="dropdown-menu" role="menu">
            <div class="dropdown-content">
            <a href="{{route('blog.index')}}" class="dropdown-item">
                Статті
            </a>
            <a href="{{route('blog.my')}}" class="dropdown-item">
                Мої статті
            </a>
            <a href="{{route('blog.create')}}" class="dropdown-item">
                Додати статтю
            </a>
            </div>
        </div>
    </div>
    <div class="dropdown navbar-item border-hover">
        <div class="dropdown-trigger">
            <div class="is-clickable" aria-haspopup="true">
                <span class="dropdown-name">Рецепти</span>
                <span class="icon is-small">
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                </span>
            </div>
        </div>
        <div class="dropdown-menu" role="menu">
            <div class="dropdown-content">
                <a href="{{route('recipe.index')}}" class="dropdown-item">
                    Рецепти
                </a>
                <a href="{{route('recipe.create')}}" class="dropdown-item">
                    Додати новий рецепт
                </a>
            </div>
        </div>
    </div>
    <a href="{{route('doctors.get')}}" class="navbar-item mr-2 border-hover">
        Лікарі
    </a>
    <a  href="{{route('directory')}}" class="navbar-item border-hover">
        Довідник
    </a>
    <div class="is-flex is-justify-content-center is-hidden-desktop" id="close-menu">
        <i class="fa fa-times is-size-5 is-clickable pt-2" aria-hidden="true"></i>
    </div>
</nav>
