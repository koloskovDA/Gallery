@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Избранные картины
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <td>Название</td>
                                <td>Направление</td>
                                <td>Вид</td>
                                <td>Автор</td>
                                <td>Год создания</td>
                                <td>Оценочная стоимость</td>
                                <td>Фото</td>
                                <td>Владелец</td>
                                <td>Последняя ставка</td>
                            </tr>
                            </thead>
                            @foreach ($paintings as $painting)
                                <tr>
                                    <td>
                                        <a href="{{route('painting', [$painting->id])}}">{{$painting->name}}</a>
                                    </td>
                                    <td>
                                        {{$painting->direction->name}}
                                    </td>
                                    <td>
                                        {{$painting->type->name}}
                                    </td>
                                    <td>
                                        {{$painting->author->FIO}}
                                    </td>
                                    <td>
                                        {{$painting->year}}
                                    </td>
                                    <td>
                                        {{$painting->price}}
                                    </td>
                                    <td><img src="{{asset('storage/img/paintings/'.$painting?->file?->name)}}" width="50px" alt=""></td>
                                    <td>
                                        {{$painting->owner->FIO}}
                                    </td>
                                    <td>{{$painting?->bids?->sortByDesc('sum')?->first()?->sum}} руб., {{$painting?->bids?->sortByDesc('sum')?->first()?->user?->name}}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
