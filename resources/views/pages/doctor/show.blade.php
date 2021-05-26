@extends('layouts.v1')

@section('content')
    <div class="title text-center">
        {{$doctor->user->full_name}}
    </div>
    <div class="columns is-align-items-flex-start mb-5">
        <div class="box column is-two-thirds mr-5">
            <div class="content">
                {!!$doctor->biography!!}
            </div>
        </div>
        <div class="column">
            <div class="box">
                <h3 class="is-size-4 has-text-centered pb-4">Документи лікаря</h3>
                <table class="table is-bordered percent-100">
                    <colgroup span="9">
                        <col span="1" style="width:80%">
                        <col span="2" style="width:20%">
                    </colgroup>
                        @forelse ($materials as $material)
                            <tr>
                                <td>
                                    <a
                                        title="{{$material->name}}"
                                        target="_blank"
                                        href="{{route('doctor.file', ['id' => $material->id])}}"
                                    >
                                        {{Str::limit($material->name, 25)}}
                                    </a>
                                </td>
                                <td class="has-text-centered">
                                    <i class="fa fa-file-text" aria-hidden="true"></i>
                                </td>
                            </tr>
                        @empty
                            <x-empty />
                        @endforelse
                </table>
            </div>
            <button class="percent-100 button is-success" onclick="window.print();">Версія для друку</button>
        </div>
    </div>
@endsection
