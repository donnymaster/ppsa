@php
    $titlePage = $code
@endphp
@extends('layouts.v1')

@section('content')
    <div class="is-flex is-align-items-center is-justify-content-center min-height100 is-flex-direction-column">
        <div class="title">
            {{ $code }}
        </div>
        <div class="subtitle">
            {{ $message }}
        </div>
    </div>
@endsection
