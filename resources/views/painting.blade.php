@extends('layouts.app')

@section('content')
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Картины направления
                        </div>

                        <div class="card-body">
                            <img src="{{asset('storage/img/paintings/'.$painting?->file?->name)}}" alt="">
                            <ul>
                                <li>Название: {{$painting->name}}</li>
                                <li>Описание: {{$painting->description}}</li>
                                <li>Автор: {{$painting->author->FIO}}</li>
                                <li>Владелец: {{$painting->owner->FIO}}</li>
                                <li>Тип: {{$painting->type->name}}</li>
                                <li>Направление: {{$painting->direction->name}}</li>
                                <hr/>
                                <li>Участвует в экспозиции: {{$painting->exposition->name}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
