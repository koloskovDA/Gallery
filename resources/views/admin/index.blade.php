@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Статистика за последние сутки</div>
                    <div class="card-body">
                        <h5>Новых пользователей: {{$users}}</h5>
                        <hr>
                        <h5>Новых мероприятий: {{$actions}}</h5>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
