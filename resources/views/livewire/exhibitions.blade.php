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
                                <td>Название</td>
                                <td>Дата добавления</td>
                                <td>Начало</td>
                                <td>Окончание</td>
                                <td>Число билетов</td>
                                <td>Дата начала аукциона</td>
                                <td>Дата окончания аукциона</td>
                                <td>Зарезервировать билет</td>
                            </tr>
                            </thead>
                            @foreach ($exhibitions as $exhibition)
                                <tr>
                                    <td>
                                        <a href="{{route('admin.exhibition', ['exhibition_id' => $exhibition->id])}}">{{$exhibition->name}}</a>
                                    </td>
                                    <td>{{$exhibition->created_at}}</td>
                                    <td>{{$exhibition->starts_at}}</td>
                                    <td>{{$exhibition->ends_at}}</td>
                                    <td>{{$exhibition->tickets_count}}</td>
                                    <td>{{$exhibition->auction?->starts_at}}</td>
                                    <td>{{$exhibition->auction?->ends_at}}</td>
                                    <td>
                                        @if (\Illuminate\Support\Facades\Auth::check())
                                            @if ((!empty($tickets)) && $tickets->where('exhibition_id', $exhibition->id)->where('user_id', \Illuminate\Support\Facades\Auth::user()->id)->count() > 0)
                                            <button class="btn btn-outline-info">Зарезервирован</button>
                                            @elseif ($exhibition->tickets_count > 0)
                                            <button class="btn btn-success" wire:click="createTicket({{$exhibition->id}})">Зарезервировать</button>
                                            @else
                                                <button class="btn btn-outline-light">Билетов нет</button>
                                            @endif
                                        @else
                                            @if ($exhibition->tickets_count > 0)
                                                <a class="btn btn-success" href="{{ route('login') }}">Зарезервировать</a>
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
