@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="carouselExampleIndicators" class="carousel slide mb-2" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($exhibitions->pluck('expositions')->flatten() as $key => $exposition)
                            <div class="carousel-item @if ($key === 0) active @endif">
                                @if($exposition->paintings->first()->file->name !== null)<img src="{{asset('storage/img/paintings/'.$exposition->paintings->first()->file->name)}}" alt="...">@endif
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>{{$exposition->name}}</h5>
                                    @if ($exposition->has('exhibition'))
                                        <p>Экспозиция представлена на выставке {{$exposition->exhibition->name}}</p>
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
                    <div class="card-header">Ближайшие выставки <a href="" class="float-right">Ближайшие выставки</a></div>

                    <div class="card-body">
                        <div class="col-md-10">
                            @can('work')
                            @dump(Auth::user()->isAdmin(), \Illuminate\Support\Facades\Auth::user()->file->name)
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center pt-2">
            <div class="col-md-12">
                <div class="card h-100">
                    <div class="card-header">Аукционы <a href="" class="float-right">Аукционы</a></div>

                    <div class="card-body">
                        <div class="col-md-10">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
