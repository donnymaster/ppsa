<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script defer src="https://cdn.tiny.cloud/1/e953kue889bd5i7wplz1yrnk954nql0gimt96aucgsl9i4rp/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{asset('js/vendor/copyElementEngine.js')}}"></script>
    <script src="{{ mix('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="{{asset('css/icon.css')}}">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <main class="columns pt-6 mb-0 pb-4">
        <form action="{{route('doctor.store')}}" class="box column is-offset-2 is-8" method="POST" enctype="multipart/form-data">
            @csrf
            <h2 class="subtitle has-text-centered">PPSA</h2>
            <div class="field">
                <label class="label">Пошта <span class="has-text-danger">*</span></label>
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
                <label class="label">Ім'я <span class="has-text-danger">*</span></label>
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
                <label class="label">Прізвище <span class="has-text-danger">*</span></label>
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
              <label class="label">Пароль <span class="has-text-danger">*</span></label>
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
                <label class="label">Підтвердіть пароль <span class="has-text-danger">*</span></label>
                <div class="control">
                    <input
                        class="input @error('password_confirmation') is-danger @enderror"
                        name="password_confirmation"
                        type="password"
                        required
                        placeholder="********"
                    >
                </div>
                @error('password_confirmation')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="field">
                <label class="label">Стаж роботи <span class="has-text-danger">*</span></label>
                <div class="control">
                    <input
                        class="input @error('work_experience') is-danger @enderror"
                        name="work_experience"
                        type="number"
                        required
                    >
                </div>
                @error('work_experience')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="field tiny-wrapped">
                <label class="label">Розкажіть про себе <span class="has-text-danger">*</span></label>
                <div class="placeholder-item"></div>
                <textarea class="tiny-init is-hidden" name="biography"></textarea>
                <x-error name="biography" />
            </div>
            <div class="info-wrapped">
                <div class="info-title is-flex">
                    <p>Документи</p>
                    <div class="action is-flex">
                        <div class="plus pl-3 pr-2 has-text-success is-clickable">
                            <i class="fa fa-plus plus-document" aria-hidden="true"></i>
                        </div>
                        <div class="minus has-text-danger is-clickable">
                            <i class="fa fa-minus minus-document" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="info-wrapped-items mb-5 mt-2">
                    <div class="file">
                        <label class="file-label">
                          <input class="file-input" type="file" name="document[]">
                          <span class="file-cta">
                            <span class="file-icon">
                              <i class="fa fa-upload"></i>
                            </span>
                            <span class="file-label">
                                виберете файл…
                            </span>
                          </span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="is-flex mobile-auth">
                <div class="is-flex-grow-1">
                    <button class="button is-primary">Реєстрація</button>
                </div>
                <div>
                    <a href="{{route('register')}}" class="button is-primary mr-2">Реєстрація для користувачів</a>
                    <a href="{{route('login')}}" class="button is-primary">Вхід</a>
                </div>
            </div>
        </form>
    </main>
    <script>
        new CopyElementEngine({
            plusSelector: '.plus-document',
            minusSelector: '.minus-document',
            parentSelector: '.info-wrapped-items',
            maxItems: 5,
            messageMaxItems: 'Максимальна кількість 5!',
            minItems: 1,
            messageMinItems: 'Мінімальна кількість 1'
        });
    </script>
</body>
</html>
