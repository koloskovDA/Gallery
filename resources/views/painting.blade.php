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
                                <hr/>
                                <img src="{{asset('storage/img/authors/'.$painting?->author?->file?->name)}}" alt="">
                                <li>Автор: <a href="{{route('author.paintings', [$painting->author->id])}}">{{$painting->author->FIO}}</a></li>
                                <hr/>
                                <img src="{{asset('storage/img/owners/'.$painting?->owner?->file?->name)}}" alt="">
                                <li>Владелец: <a href="{{route('owner.paintings', [$painting->owner->id])}}">{{$painting->owner->FIO}}</a></li>
                                <li>Тип: <a href="{{route('type.paintings', [$painting->type->id])}}">{{$painting->type->name}}</a></li>
                                <li>Направление: <a href="{{route('direction.paintings', [$painting->direction->id])}}">{{$painting->direction->name}}</a></li>
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
