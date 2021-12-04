    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Картины направления
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 text-center">
                                    <img src="{{asset('storage/img/paintings/'.$painting?->file?->name)}}" alt="" class="img-thumbnail" style="max-height: 300px;">
                                </div>
                                <div class="col-lg-6" wire:poll.750ms>
                                    @if (!empty($painting->exposition->exhibition->auction))
                                    <table>
                                        <tr>
                                            <td>
                                                Закрытие аукциона: {{\Carbon\Carbon::parse($painting?->exposition?->exhibition?->auction?->ends_at)->translatedFormat('d F Y, H:i:s')}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Текущее время: {{\Carbon\Carbon::now()->translatedFormat('d F Y, H:i:s')}}
                                            </td>
                                        </tr>
                                    </table>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        Сумма ставки
                                                    </th>
                                                    <th>
                                                        Пользователь
                                                    </th>
                                                    <th>
                                                        Дата
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($bids as $bid)
                                                    <tr>
                                                        <td>
                                                            {{$bid->sum}}
                                                        </td>
                                                        <td>
                                                            {{$bid->user->name}}
                                                        </td>
                                                        <td>
                                                            {{$bid->created_at}}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                            </tbody>
                                        </table>
                                        @if (\Illuminate\Support\Facades\Auth::check())
                                        @if (\Carbon\Carbon::parse($painting->exposition->exhibition->auction->ends_at) > \Carbon\Carbon::now())
                                            <label for="makebidinput">Укажите сумму</label>
                                            <input type="number" wire:model="bidSum" name="makebidinput">
                                            <button wire:click="makeBid">Сделать ставку</button>
                                        @else
                                            Аукцион завершён
                                        @endif
                                        @else
                                            Авторизуйтесь или зарегистрируйтесь, чтобы участвовать
                                        @endif
                                        @foreach ($errors as $error)
                                            <p>{{$error->text}}</p>
                                            @endforeach
                                    @endif
                                </div>
                            </div>
                            <hr/>
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
