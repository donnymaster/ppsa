@extends('layouts.v1')

@section('content')
   <div class="pt-3 pb-3 mt-3 mb-3">
        <div id="messanger" class="messenger columns">
            <input type="hidden" id="user-id" value="{{$userId}}">
            <input type="hidden" id="user-full-name" value="{{Auth::user()->full_name}}">
            <div class="column is-one-quarter left-bar pl-0 pr-0 pb-0">
                <div class="fetch-wrapped">
                    <div class="loader"></div>
                </div>
                <div class="bar-head pl-3 pr-3 pb-3" style="border-bottom: 1px solid">
                    <div class="field">
                        @if (Auth::user()->isDoctor())
                            <label class="label">Користувач</label>
                        @else
                            <label class="label">Лікар</label>
                        @endif
                        <div class="field search-parent" data-id="id" data-show="full_name">
                            <input type="hidden" value="/users?role={{$role}}&last-name=" class="search-url">
                            <input autocomplete="off" class="input input-search" type="text" name="doctor-full">
                            <input type="hidden" class="input doctor_id" name="doctor_id">
                            <div class="wrapped-search-window"></div>
                        </div>
                      </div>
                </div>
                <div class="bar-items pt-2">
                    @forelse ($rooms as $room)
                        @php
                            $user = $room->users->where('id', '!=', Auth::user()->id)->first();
                        @endphp
                        <div
                            class="user-item is-clickable"
                            data-room="{{$room->name}}"
                            data-user-id="{{$user->id}}"
                            data-user-full="{{$user->full_name}}"
                        >
                            {{$user->full_name}}
                        </div>
                    @empty
                        <p class="empty-dialog has-text-centered">діалоги відсутні</p>
                    @endforelse
                </div>
            </div>
            <div class="column dialog pt-0 pb-0 pl-0 pr-0 is-relative">
                @if (Auth::user()->isDoctor())
                    <div class="add-racion is-hidden">
                        <i class="fa fa-plus has-text-link is-size-3 is-clickable" aria-hidden="true"></i>
                    </div>
                @endif
                <div class="chat-box">
                    <div class="is-size-5 has-text-centered pt-3">Виберіть чат</div>
                </div>
                <div class="form-send is-flex ml-2 mr-2 mt-3">
                    <div class="field has-addons" style="width: 100%">
                        <div class="control is-flex-grow-1">
                          <input id="message-body" class="input" type="text" placeholder="Введіть повідомлення">
                        </div>
                        <div class="control">
                          <a id="send-message" class="button is-info" style="font-size: .9rem;">
                            Відправити
                          </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </div>
   @if (Auth::user()->isDoctor())
   <div class="modal" data-id="create-event">
    <div class="modal-background" />
    <div class="modal-content" style="max-height: 610px;">
        <div class="box mt-6" style="position: relative">
            <div class="wrapped-spinner">
                <div class="loading-wrap">
                    <div class="loading-hole">&nbsp;</div>
                </div>
            </div>
            <div id="form">
                <h3 class="is-size-4 has-text-centered">Додати раціон користувачеві: <span id="user-name"></span></h3>
                <input type="hidden" name="user_id" id="user-id-owner">
                <div class="is-flex is-align-items-flex-end">
                    <div class="field mr-3 is-flex-grow-1">
                        <label class="label">Назва раціону <span class="has-text-danger">*</span></label>
                        <div class="field has-addons has-addons-left">
                            <div class="field is-flex-grow-0">
                                <div disabled class="doctor-title">{{Auth::user()->full_name}}:</div>
                            </div>
                            <p class="control is-flex-grow-1">
                              <input class="input ration-name" type="text">
                            </p>
                          </div>
                    </div>
                    <div class="control mb-5">
                        <button type="submit" id="submit-create-event" class="button is-link">Зберегти</button>
                    </div>
                </div>
                <div class="date is-flex">
                    <div class="field mr-3 is-flex-grow-1">
                        <label class="label">Початок <span class="has-text-danger">*</span></label>
                        <div class="field">
                            <input class="input start" type="date">
                        </div>
                    </div>
                    <div class="field is-flex-grow-1">
                        <label class="label">Кінець <span class="has-text-danger">*</span></label>
                        <div class="field">
                            <input class="input end" type="date">
                        </div>
                    </div>
                </div>
                <div>
                    <div class="field">
                        <label class="label">Страва на: сніданок <span class="has-text-danger">*</span></label>
                        <div class="field search-parent" data-id="id" data-show="title">
                            <input type="hidden" value="/recipe-search?value=" class="search-url">
                            <input class="input input-search" type="text">
                            <input type="hidden" class="input doctor_id lunch">
                            <div class="wrapped-search-window"></div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Страва на: обід <span class="has-text-danger">*</span></label>
                        <div class="field search-parent" data-id="id" data-show="title">
                            <input type="hidden" value="/recipe-search?value=" class="search-url">
                            <input class="input input-search" type="text">
                            <input type="hidden" class="input doctor_id dinner">
                            <div class="wrapped-search-window" data-pos="bottom"></div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Страва на: полудень</label>
                        <div class="field search-parent" data-id="id" data-show="title">
                            <input type="hidden" value="/recipe-search?value=" class="search-url">
                            <input class="input input-search" type="text">
                            <input type="hidden" class="input doctor_id nooning">
                            <div class="wrapped-search-window" data-pos="bottom"></div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Страва на: вечерю <span class="has-text-danger">*</span></label>
                        <div class="field search-parent" data-id="id" data-show="title">
                            <input type="hidden" value="/recipe-search?value=" class="search-url">
                            <input class="input input-search" type="text">
                            <input type="hidden" class="input doctor_id supper">
                            <div class="wrapped-search-window" data-pos="bottom"></div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
   @endif
@endsection
