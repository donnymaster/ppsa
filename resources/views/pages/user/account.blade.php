@extends('layouts.v1')

@section('content')
    <h2 class="pt-3 title is-4">
        Особистий аккаунт
    </h2>
    <div class="box tabs is-flex-direction-column mb-6">
        <ul>
            <li class="is-active">
                <a data-tab="1">Редагування особистої інформації</a>
            </li>
        </ul>
        <div class="content pt-2 pb-3">
            <div data-tab="1">
                <div class="is-flex is-justify-content-center">
                    <form class="column is-6" method="POST" action="{{ route('account.update') }}">
                        @csrf
                        <div class="field">
                            <label class="label">Ім'я <span class="has-text-danger">*</span></label>
                            <div class="control">
                              <input
                                name="first_name"
                                class="input @error('first_name') is-danger @enderror"
                                type="text"
                                required
                                placeholder="напр. Іван"
                                value="{{ $user->first_name }}"
                              >
                            </div>
                            <x-error name="first_name" />
                        </div>

                        <div class="field">
                            <label class="label">Прізвище <span class="has-text-danger">*</span></label>
                            <div class="control">
                                <input
                                    name="last_name"
                                    class="input @error('last_name') is-danger @enderror"
                                    type="text"
                                    required
                                    placeholder="напр. Іванов"
                                    value="{{ $user->last_name }}"
                                >
                            </div>
                            <x-error name="last_name" />
                        </div>

                        <div class="field">
                            <label class="label">Пошта <span class="has-text-danger">*</span></label>
                            <div class="control">
                              <input
                                name="email"
                                class="input @error('email') is-danger @enderror"
                                type="email"
                                required
                                placeholder="напр. alex@example.com"
                                value="{{ $user->email }}"
                              >
                            </div>
                            <x-error name="email" />
                        </div>
                        <div class="field">
                            <label class="label">Старий пароль</label>
                            <div class="control">
                              <input
                                name="password"
                                class="input @error('password') is-danger @enderror"
                                type="password"
                                placeholder="************"
                              >
                            </div>
                            <x-error name="password" />
                        </div>
                        <div class="field">
                            <label class="label">Новий пароль</label>
                            <div class="control">
                              <input
                                name="new_password"
                                class="input @error('new_password') is-danger @enderror"
                                type="password"
                                placeholder="************"
                              >
                            </div>
                            <x-error name="new_password" />
                        </div>
                        <div class="field">
                            <label class="label">Ваша роль</label>
                            <div class="control">
                                <input class="input" type="text" value="{{$role->name}}" disabled>
                            </div>
                        </div>
                        <div class="field is-grouped is-grouped-centered pt-2">
                            <p class="control">
                              <button type="submit" class="button is-primary">
                                Зберегти
                              </button>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
