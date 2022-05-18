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
                                                Рейтинг: @for ($i = 0; $i < (int)$amountRating; $i++)
                                                    <span class="fa fa-star checked"></span>
                                                @endfor
                                                <br/>
                                                <button class="btn btn-primary" data-toggle="modal"
                                                        data-target="#exampleModalCenter">Оценки и комментарии</button>
                                                @if (Auth::check() && (\Illuminate\Support\Facades\Cache::get(Auth::user()->id) === null || !(\Illuminate\Support\Facades\Cache::get(Auth::user()->id))->contains($painting->id)))
                                                <button class="btn btn-warning" wire:click="addToFavourites">Добавить в избранное</button>
                                                @elseif (Auth::check())
                                                    <button class="btn btn-danger" wire:click="removeFromFavourites">Убрать из избранного</button>
                                                @endif
                                            </td>
                                        </tr>
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
        <div class="modal fade" wire:ignore.self id="exampleModalCenter" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Оценки и комментарии</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                                @foreach ($ratings->where('painting_id', $painting->id) as $rating)
<div class="card">
    <div class="card-header"><h5>@if ($rating->user->file !== null)
                <img src="{{asset('storage/img/profile/'.$rating->user->file->name)}}" alt="Avatar" width="30px" class="rounded-circle">
            @else
                <img src="{{asset('storage/img/templates/noimage.jpg')}}" alt="Avatar" width="30px" class="rounded-circle">
            @endif{{$rating->user->name}}

        </h5>
        Оценка: @for ($i = 0; $i < (int)($rating->rating); $i++)
            <span class="fa fa-star checked"></span>
        @endfor
        <p>{{$rating->user->comments->where('painting_id', $painting->id)?->first()?->text}}</p>

    </div>
</div>
                                @endforeach
                        <hr/>
                                    @if (\Illuminate\Support\Facades\Auth::check() && $ratings->where('user_id', \Illuminate\Support\Facades\Auth::user()->id)->where('painting_id', $painting->id)->count() === 0)
                        <div class="form-group">
                            <label for="exampleInputEmail1">Оставить оценку</label>
                            <br><select wire:model="rating">
                                <option value="5" selected>Отлично</option>
                                <option value="4">Хорошо</option>
                                <option value="3">Удовлетворительно</option>
                                <option value="2">Не очень</option>
                                <option value="1">Плохо</option>
                                <option value="0">Отвратительно</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Комментарий</label>
                            <textarea wire:model="comment" class="form-text" cols="50" rows="4"></textarea>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" data-dismiss="modal"
                                   wire:click="leaveReview">
                        </div>
                                    @elseif(Auth::check())
                        Вы уже оставили свою оценку
                                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
