@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="carouselExampleIndicators" class="carousel slide mb-2" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($exhibitions->pluck('expositions')->flatten() as $key => $exposition)
                            <div class="carousel-item @if ($key === 0) active @endif" style="width: 100%;
    height: 15vw;
    object-fit: cover;">
                                @if($exposition->paintings->first()?->file?->name !== null) <div class="img"><img src="{{asset('storage/img/paintings/background/'.$exposition->paintings->first()?->file?->name)}}" alt="..."></div>@endif
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>«{{$exposition->paintings->first()?->name}}», {{$exposition->paintings->first()?->author->FIO}}, {{$exposition->paintings->first()?->year}} год. Из экспозиции «{{$exposition?->name}}»</h5>
                                    @if ($exposition->has('exhibition'))
                                        <p>Представлена на выставке «{{$exposition?->exhibition?->name}}»</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row justify-content-center pt-2">
            <div class="col-md-12">
                <div class="card h-100">
                    <div class="card-header">Ближайшие выставки <a href="{{route('exhibitions')}}" class="float-right">Все выставки</a></div>

                    <div class="card-body">
                        <div class="row justify-content-center">
                            @foreach ($exhibitions->sortBy('starts_at')->where('starts_at', '>', now()) as $exhibition)
                                <div class="card" style="width: 18rem;">
                                    <div class="img">
                                    <img class="card-img-top" style="filter: brightness(50%); max-height: 200px;" src="{{asset('storage/img/paintings/'.$exhibition->expositions?->first()?->paintings?->first()?->file?->name)}}"
                                                                    alt="Card image cap">
                                    </div>
                                    <div class="card-img-overlay">
                                        <h5 class="card-title actions-title">{{$exhibition->name}} </h5><span class="badge badge-primary">Начало: {{Carbon\Carbon::make($exhibition->starts_at)->translatedFormat('d F Y (l), H:i')}}</span>
                                        <br>
                                        <p class="card-text actions-text">
                                            Экспозиции:
                                            <br>
                                            @foreach ($exhibition->expositions as $exposition)
                                                «{{$exposition->name}}»:
                                                @foreach ($exposition->paintings as $painting)
                                                    «{{$painting->name}}», {{$painting->author->FIO}}.
                                                    @endforeach
                                                @endforeach
                                        </p>
                                    </div>
                                    <div class="card-footer">
                                        Начало аукциона: {{Carbon\Carbon::make($exhibition->auction->starts_at)->translatedFormat('d F Y')}}
                                        Осталось {{$exhibition->tickets_count}} билетов.
                                        Цена: {{$exhibition->price}} руб.
                                    </div>
                                </div>
                            @endforeach
                            @if($exhibitions->count() === 0)
                                Мероприятий нет
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
