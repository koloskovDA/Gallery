<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Выставки
                        @can('work')
                        <button class="btn btn-success float-right" data-toggle="modal"
                                data-target="#exampleModalCenter">Добавить выставку
                        </button>
                        @endcan
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <td>Выставка</td>
                                <td>Начало</td>
                                <td>Окончание</td>
                                <td>Адрес</td>
                                <td>Число билетов</td>
                                <td>Цена билета</td>
                                <td>Дата начала аукциона</td>
                                <td>Дата окончания аукциона</td>
                                <td>Купить билет</td>
                            </tr>
                            </thead>
                            @foreach ($exhibitions as $exhibition)
                                <tr>
                                    <td>
                                        <a href="{{route('admin.exhibition', ['exhibition_id' => $exhibition->id])}}">{{$exhibition->name}}</a>
                                    </td>
                                    <td>
                                        @if($exhibition->starts_at)
                                            {{\Carbon\Carbon::make($exhibition->starts_at)->translatedFormat('d F Y (l), H:i')}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($exhibition->ends_at)
                                            {{\Carbon\Carbon::make($exhibition->ends_at)->translatedFormat('d F Y (l), H:i')}}
                                        @endif
                                    </td>
                                    <td>{{$exhibition->address}}</td>
                                    <td>{{$exhibition->tickets_count}} шт.</td>
                                    <td>{{$exhibition->price}} руб.</td>
                                    <td>
                                        @if($exhibition->auction?->starts_at)
                                            {{\Carbon\Carbon::make($exhibition->auction?->starts_at)->translatedFormat('d F Y (l), H:i')}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($exhibition->auction?->ends_at)
                                            {{\Carbon\Carbon::make($exhibition->auction?->ends_at)->translatedFormat('d F Y (l), H:i')}}
                                        @endif
                                    </td>
                                    <td>
                                        @if (\Illuminate\Support\Facades\Auth::check())
                                            @if ((!empty($tickets)) && $tickets->where('exhibition_id', $exhibition->id)->where('user_id', \Illuminate\Support\Facades\Auth::user()->id)->count() > 0)
                                                @if($tickets->where('exhibition_id', $exhibition->id)->where('user_id', \Illuminate\Support\Facades\Auth::user()->id)?->first()?->receipt?->status === 'approved')
                                                    <a class="btn btn-outline-success" href="{{route('generatePDF', $tickets->where('exhibition_id', $exhibition->id)->where('user_id', \Illuminate\Support\Facades\Auth::user()->id)->first()->id)}}">Распечатать</a>
                                                @elseif($tickets->where('exhibition_id', $exhibition->id)->where('user_id', \Illuminate\Support\Facades\Auth::user()->id)?->first()?->receipt?->status === 'checking')
                                                    <button class="btn btn-outline-info" disabled>Проверяется</button>
                                                @else
                                                    <button class="btn btn-outline-danger" disabled>Отклонено</button>
                                                @endif
                                            @elseif ($exhibition->tickets_count > 0)
                                                <button class="btn btn-success" wire:click="addReceipt({{$exhibition->id}})" data-toggle="modal" data-target="#exampleModalCenter">Купить</button>
                                            @else
                                                <button class="btn btn-outline-light">Билетов нет</button>
                                            @endif
                                        @else
                                            @if ($exhibition->tickets_count > 0)
                                                <a class="btn btn-success" href="{{ route('login') }}">Купить</a>
                                            @else
                                                <button class="btn btn-outline-light">Билетов нет</button>
                                            @endif
                                        @endif
                                    </td>
                                    @can('work')
                                    <td class="pl-0 pr-0"><input class="btn btn-warning btn-sm" value="E" type="button"
                                                                 wire:click="editExhibition({{$exhibition->id}})"
                                                                 data-toggle="modal" data-target="#exampleModalCenter">
                                    </td>
                                    <td class="pl-0 pr-0"><input class="btn btn-danger btn-sm" value="X" type="button"
                                                                 wire:click="deleteExhibition({{$exhibition->id}})">
                                    </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" wire:ignore.self id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            @if ($keyToEdit === true)
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Изменить выставку</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Название</label>
                            <input type="text" wire:model="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Адрес</label>
                            <input type="text" wire:model="address" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Начало</label>
                            <input type="datetime-local" wire:model="starts_at" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Окончание</label>
                            <input type="datetime-local" wire:model="ends_at" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Число билетов</label>
                            <input type="number" wire:model="tickets_count" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Цена билета</label>
                            <input type="number" wire:model="price" class="form-control">
                        </div>
                        <hr/>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Дата начала аукциона</label>
                            <input type="date" wire:model="auction_date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Дата окончания аукциона</label>
                            <input type="date" wire:model="auction_date_ends" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" data-dismiss="modal"
                                   wire:click="updateExhibition">
                        </div>
                    </div>
            @elseif ($editableExhibition !== null && $keyToEdit === null)
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Добавить квитанцию</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @if ($receiptPhoto !== null)
                                    <label for="exampleInputEmail1">Квитанция</label>
                                    <br>
                                    <img src="{{$receiptPhoto->temporaryUrl()}}" height="100px" width="auto" alt="">
                                @endif
                                <hr/>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Сфотографируйте и отправьте квитанцию об оплате</label>
                                    <input type="file" wire:model="receiptPhoto" class="form-control">
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-primary" data-dismiss="modal"
                                           wire:click="createTicket">
                                </div>
                            </div>
                        </div>
            @else
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Добавить выставку</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Название</label>
                                    <input type="text" wire:model="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Адрес</label>
                                    <input type="text" wire:model="address" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Начало</label>
                                    <input type="date" wire:model="starts_at" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Окончание</label>
                                    <input type="date" wire:model="ends_at" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Число билетов</label>
                                    <input type="number" wire:model="tickets_count" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Цена билета</label>
                                    <input type="number" wire:model="price" class="form-control">
                                </div>
                                <hr/>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Дата проведения аукциона</label>
                                    <input type="date" wire:model="auction_date" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Дата окончания аукциона</label>
                                    <input type="date" wire:model="auction_date_ends" class="form-control">
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-primary" data-dismiss="modal"
                                           wire:click="createExhibition">
                                </div>
                            </div>
                        </div>
                </div>
            @endif
        </div>
    </div>
</div>
