<nav class="level print-hide wrapped-menu-mobile">
    <!-- Left side -->
    <div class="level-left mobile-menu">
        <div class="pr-5 is-hidden-touch">
            <figure class="image is-32x32">
                <img src="{{ asset('img/logo.png') }}">
            </figure>
        </div>
        @if (Auth::user() && Auth::user()->isDoctor())
            <x-nav-doctor />
        @else
            <x-nav-user />
        @endif
    </div>
    <i class="fa fa-bars is-clickable is-hidden-desktop" id="open-menu" aria-hidden="true"></i>
    <!-- Right side -->
    <div class="level-right">
        @auth
            <div class="dropdown is-right">
                <div class="dropdown-trigger">
                    <div class="is-clickable" aria-haspopup="true">
                        <span class="dropdown-name">{{ Auth::user()->full_name }}</span>
                        <span class="icon is-small">
                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
                <div class="dropdown-menu" role="menu">
                    <div class="dropdown-content">
                    <a href="{{route('account.index')}}" class="dropdown-item">
                        Мій аккаунт
                    </a>
                    <a href="{{route('messanger.index')}}" class="dropdown-item">
                        Мессенджер
                    </a>
                    @if (!Auth::user()->isDoctor()) {{-- TODO: поменять --}}
                        <a href="{{route('calendar')}}" class="dropdown-item">
                            Календар
                        </a>
                    @endif
                    <hr class="dropdown-divider">
                    <a
                        href="#"
                        class="dropdown-item"
                        onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();"
                    >
                        Вихід
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    </div>
                </div>
            </div>
        @endauth

        @guest
            <div class="buttons">
                <a href="{{ route('register') }}" class="button is-primary">
                    Реєстрація
                </a>
                <a href="{{ route('login') }}" class="button is-light">
                    Увійти
                </a>
          </div>
        @endguest
    </div>
</nav>
