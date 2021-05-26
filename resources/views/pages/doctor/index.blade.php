@extends('layouts.v1')

@section('content')
    <h1 class="pt-3 title is-4">Лікарі</h1>
    <div class="columns is-align-items-flex-start mb-5 mobile-content">
        <div class="box column is-two-thirds mr-5">
            @each('components.doctor-list', $doctors, 'doctor', 'components.empty')
            <div class="mt-4">
                {{ $doctors->onEachSide(1)->links('components.pagination') }}
            </div>
        </div>
        <div class="box column">
            <x-doctor-filter />
        </div>
    </div>
@endsection
