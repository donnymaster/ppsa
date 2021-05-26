<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('components.head')

<body class="is-relative">
    <div class="container">
        @include('components.header')

        <div id="app">
            @yield('content')
        </div>

        @include('components.footer')
    </div>
    {{-- @if (Auth::user() && !Auth::user()->isDoctor()) {{-- TODO: добавить две дерективы isUser and isDoctor
        @include('components.racion-form')
    @endif --}}
    @yield('js')
    <script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>
