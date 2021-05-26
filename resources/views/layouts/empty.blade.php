<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('components.head')

<body class="is-relative">
        @yield('content')
</body>
</html>
