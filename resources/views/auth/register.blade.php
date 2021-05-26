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
<body style="height: 100vh">
    <main class="columns pt-6">
        <form action="{{route('register')}}" class="box column is-offset-4 is-4" method="POST">
            @csrf
            <h2 class="subtitle has-text-centered">PPSA</h2>
            <div class="field">
                <label class="label">Пошта</label>
                <div class="control">
                    <input
                        class="input @error('email') is-danger @enderror"
                        name="email"
                        type="email"
                        required
                        placeholder="напр. alex@example.com"
                    >
                </div>
                @error('email')
                <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="label">Ім'я</label>
                <div class="control">
                    <input
                        class="input @error('first_name') is-danger @enderror"
                        name="first_name"
                        type="text"
                        required
                        placeholder="напр. Іван"
                    >
                </div>
                @error('first_name')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="label">Прізвище</label>
                <div class="control">
                    <input
                        class="input @error('last_name') is-danger @enderror"
                        name="last_name"
                        type="text"
                        required
                        placeholder="напр. Іванов"
                    >
                </div>
                @error('last_name')
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

            <div class="field">
                <label class="label">Підтвердіть пароль</label>
                <div class="control">
                    <input
                        class="input @error('password_confirmation') is-danger @enderror"
                        name="password_confirmation"
                        type="password"
                        required
                        placeholder="********"
                    >
                </div>
            </div>

            <div class="is-flex mobile-auth">
                <div class="is-flex-grow-1">
                    <button class="button is-primary">Реєстрація</button>
                </div>
               <div>
                <a href="{{route('doctor.create')}}" class="button is-primary mr-2">Реєстрація для лікарів</a>
                <a href="{{route('login')}}" class="button is-primary">Вхід</a>
               </div>
            </div>
        </form>
    </main>
</body>
</html>
