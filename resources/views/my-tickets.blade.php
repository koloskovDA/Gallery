@extends('layouts.app')

@section('content')
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Мои билеты
                        </div>

                        <div class="card-body">
                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <td>Название</td>
                                    <td>Начало</td>
                                    <td>Окончание</td>
                                    <td>Число билетов</td>
                                    <td>Дата начала аукциона</td>
                                    <td>Дата окончания аукциона</td>
                                </tr>
                                </thead>
                                @foreach ($exhibitions as $exhibition)
                                    <tr>
                                        <td>
                                            <a href="{{route('admin.exhibition', ['exhibition_id' => $exhibition->id])}}">{{$exhibition->name}}</a>
                                        </td>
                                        <td>{{$exhibition->starts_at}}</td>
                                        <td>{{$exhibition->ends_at}}</td>
                                        <td>{{$exhibition->tickets_count}}</td>
                                        <td>{{$exhibition->auction?->starts_at}}</td>
                                        <td>{{$exhibition->auction?->ends_at}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
