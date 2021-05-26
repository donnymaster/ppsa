<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <main class="columns pt-6 is-align-items-flex-start min-height100">
        <form class="box column is-offset-4 is-4" method="POST">
            @csrf
            <div class="is-flex is-flex-direction-row-reverse is-align-items-center is-justify-content-center pt-4 pb-5">
                <h2 class="ml-5 is-size-4">PPSA</h2>
                <div class="columns is-centered">
                    <figure class="image is-64x64">
                        <img src="{{ asset('img/logo.png') }}">
                    </figure>
                </div>
            </div>
            <div class="field">
              <label class="label">Логін</label>
              <div class="control">
                <input
                    class="input @error('email') is-danger @enderror"
                    name="email"
                    type="email"
                    required placeholder="напр. alex@example.com"
                >
              </div>
              @error('email')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Пароль</label>
              <div class="control">
                <input
                    class="input @error('password') is-danger @enderror"
                    name="password"
                    type="password"
                    required
                    placeholder="********"
                >
              </div>
              @error('password')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="is-flex mobile-auth">
                <div class="is-flex-grow-1">
                    <button class="button is-primary">Увійти</button>
                </div>
                <div>
                    <a href="{{route('doctor.create')}}" class="button is-primary mr-2">Реєстрація для лікарів</a>
                    <a href="{{route('register')}}" class="button is-primary">Реєстрація</a>
                </div>
            </div>
        </form>
    </main>
</body>
</html>
