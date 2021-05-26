@extends('layouts.v1')

@section('content')
    <h1 class="pt-3 title is-4">
        Календар
        <i class="fa fa-print is-hidden is-clickable" id="print" aria-hidden="true" onclick="window.print();"></i>
    </h1>
    <div class="box mb-5" style="position: relative;min-height: 140px;">
        <div class="wrapped-spinner calendar-spinner" style="display: flex">
            <div class="loading-wrap">
                <div class="loading-hole">&nbsp;</div>
            </div>
        </div>
        <div id="calendar">
        </div>
    </div>
    <div class="modal" data-id="create-event">
        <div class="modal-background" />
        <div class="modal-content">
            <div class="box mt-6" style="position: relative">
                <div class="wrapped-spinner">
                    <div class="loading-wrap">
                        <div class="loading-hole">&nbsp;</div>
                    </div>
                </div>
                <div class="form">
                    <div class="is-flex is-align-items-flex-end">
                        <div class="field mr-3 is-flex-grow-1">
                            <label class="label">Назва раціону</label>
                            <div class="field">
                                <input type="text" class="input ration_id">
                            </div>
                        </div>
                        <div class="control mb-3">
                            <button type="submit" id="submit-create-event" class="button is-link">Зберегти</button>
                        </div>
                    </div>
                    <div class="date is-flex">
                        <div class="field mr-3 is-flex-grow-1">
                            <label class="label">Початок</label>
                            <div class="field">
                                <input class="input start" type="date" disabled>
                            </div>
                        </div>
                        <div class="field is-flex-grow-1">
                            <label class="label">Кінець</label>
                            <div class="field">
                                <input class="input end" type="date" disabled>
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
        <button class="modal-close is-large" aria-label="close"></button>
    </div>
    <div class="modal" data-id="show-event">
        <div class="modal-background" />
        <div class="modal-content">
            <div class="box mt-6" style="position: relative">
                <div class="wrapped-spinner">
                    <div class="loading-wrap">
                        <div class="loading-hole">&nbsp;</div>
                    </div>
                </div>
                <div class="form">
                    <div class="title is-flex">
                        <p>Default title</p>
                        <i id="delete-event" class="fa fa-trash-o has-text-danger pl-3 is-clickable" aria-hidden="true"></i>
                    </div>
                    <div class="date">
                        <div class="field">
                            <label class="label">Початок раціону</label>
                            <div class="field">
                                <input type="date" class="input start" disabled>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Кінець раціону</label>
                            <div class="field">
                                <input type="date" class="input end" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="is-size-4 pt-3 pb-3 has-text-centered">
                        Зміст раціону
                    </div>
                    <table class="table percent-100 is-bordered">
                        <thead>
                            <tr>
                                <th>Період</th>
                                <th>Страва</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
        <button class="modal-close is-large" aria-label="close"></button>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/locales/uk.js"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.css">
@endsection
