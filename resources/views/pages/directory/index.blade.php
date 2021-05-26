@extends('layouts.v1')

@section('content')
    <h1 class="pt-3 title is-4 is-inline-flex is-justify-content-center has-text-centered percent-100">
        Довідник
        <div class="print-hide pl-3">
            <x-info position="is-left" isBottom>
                На цій сторінці ви можете дізнатися слова, що позначають і в чому міститься обраний вами продукт
            </x-info>
            <i class="fa fa-print print-hide pl-3 is-clickable" aria-hidden="true" onclick="window.print();"></i>
        </div>
    </h1>
    <div class="box search-by-directory mb-5">
        <div class="is-flex is-justify-content-center">
            <div class="field mr-4">
                <p class="control has-icons-right" style="width: 300px">
                  <input class="input search-input is-search" type="text" placeholder="Назва продукту">
                  <span class="icon is-small is-right percent-100-height">
                    <i class="fa fa-search" aria-hidden="true"></i>
                  </span>
                  <div class="wrapped-search-window"></div>
                </p>
            </div>
            @if (Auth::user() && Auth::user()->isDoctor())
                <div class="info is-size-4 print-hide">
                    <i class="fa fa-plus mr-2 is-clickable modal-btn" data-id="create-info" aria-hidden="true"></i>
                </div>
            @endif
        </div>
        <hr class="mt-2">
        <div class="result is-flex is-justify-content-center">
            <table class="table is-bordered">
                <thead>
                    <tr>
                      <th>Слова, що позначають: <span class="title-mean"></span></th>
                      <th>Продукти, що містять: <span class="title-containing"></span></th>
                    </tr>
                </thead>
                <tbody class="product-content">
                </tbody>
            </table>
        </div>
    </div>
    @if (Auth::user() && Auth::user()->isDoctor())
        <div class="modal" data-id="create-info">
            <div class="modal-background"></div>
            <div class="modal-content">
                <div class="box">
                    <form action="{{route('product-info.store')}}" method="POST">
                        @csrf
                        <div class="is-flex is-align-items-flex-end">
                            <div class="field mr-3 is-flex-grow-1">
                                <label class="label">Назва продукту <span class="has-text-danger">*</span></label>
                                <div class="control">
                                  <input name="name_product" required class="input" type="text" placeholder="назва продукту">
                                </div>
                            </div>
                            <div class="control mb-3">
                                <button type="submit" class="button is-link">Submit</button>
                            </div>
                        </div>
                        <div>
                            <table class="table is-bordered percent-100">
                                <colgroup>
                                    <col span="1" style="width: 50%;">
                                    <col span="1" style="width: 50%;">
                                 </colgroup>
                                <thead>
                                    <tr>
                                      <th>
                                        <div class="is-flex">
                                            <p>Слова, що позначають <span class="has-text-danger">*</span></p>
                                            <div class="action is-flex">
                                                <div class="plus pl-3 pr-2 has-text-success is-clickable">
                                                   <i class="fa fa-plus plus-mean" aria-hidden="true"></i>
                                               </div>
                                               <div class="minus has-text-danger is-clickable">
                                                   <i class="fa fa-minus minus-mean" aria-hidden="true"></i>
                                               </div>
                                            </div>
                                        </div>
                                      </th>
                                      <th>
                                            <div class="is-flex">
                                                <p>Продукти, що містять <span class="has-text-danger">*</span></p>
                                                <div class="action is-flex">
                                                    <div class="plus pl-3 pr-2 has-text-success is-clickable">
                                                        <i class="fa fa-plus contained-plus" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="minus has-text-danger is-clickable">
                                                        <i class="fa fa-minus contained-minus" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                            <div class="items is-flex percent-100">
                                <div class="mean-parent is-flex-grow-1">
                                    <div class="field">
                                        <label class="label">Назва</label>
                                        <div class="control">
                                            <input name="mean_product[]" required class="input" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="contained-parent is-flex-grow-1 ml-2">
                                    <div class="field">
                                        <label class="label">Назва</label>
                                        <div class="control">
                                          <input name="contained_product[]" required class="input" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <button class="modal-close is-large" aria-label="close"></button>
        </div>
    @endif
@endsection

@section('js')
    <script src="{{asset('js/vendor/copyElementEngine.js')}}"></script>
    <script>
        new CopyElementEngine({
            plusSelector: '.plus-mean',
            minusSelector: '.minus-mean',
            parentSelector: '.mean-parent',
            maxItems: 5,
            messageMaxItems: 'Максимальна кількість 5!',
            minItems: 1,
            messageMinItems: 'Мінімальна кількість 1'
        });

        new CopyElementEngine({
            plusSelector: '.contained-plus',
            minusSelector: '.contained-minus',
            parentSelector: '.contained-parent',
            maxItems: 5,
            messageMaxItems: 'Максимальна кількість 5!',
            minItems: 1,
            messageMinItems: 'Мінімальна кількість 1'
        });
    </script>
@endsection
