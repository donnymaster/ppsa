@extends('layouts.v1')

@section('content')
    <div class="box mb-5">
        <table class="table is-bordered">
            <thead>
                <tr>
                    <td width='10%'><h4>Метод</h4></td>
                    <td width='10%'><h4>Роут</h4></td>
                    <td width='10%'><h4>Имя</h4></td>
                    <td width='70%'><h4>Обработчик</h4></td>
                </tr>
            </thead>
            <tbody>
                @foreach (Route::getRoutes() as $value)
                    <tr>
                        <td>{{$value->methods()[0]}}</td>
                        <td>{{$value->uri()}}</td>
                        <td>{{$value->getName()}}</td>
                        <td>{{$value->getActionName()}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
