<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Картины экспозиции
                        <button class="btn btn-success float-right" data-toggle="modal"
                                data-target="#exampleModalCenter">Добавить картину
                        </button>
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
                                <td>Добавлено в базу</td>
                            </tr>
                            </thead>
                            @foreach ($paintings as $painting)
                                <tr>
                                    <td>
                                        {{$painting->name}}
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
                                    <td>{{$painting->created_at}}</td>
                                    <td class="pl-0 pr-0"><input class="btn btn-warning btn-sm" value="E" type="button"
                                                                 wire:click="editPainting({{$painting->id}})"
                                                                 data-toggle="modal" data-target="#exampleModalCenter">
                                    </td>
                                    <td class="pl-0 pr-0"><input class="btn btn-danger btn-sm" value="X" type="button"
                                                                 wire:click="deletePainting({{$painting->id}})">
                                    </td>
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
                        <h5 class="modal-title" id="exampleModalLongTitle">Изменить картину</h5>
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
                            <label for="exampleInputEmail1">Направление</label>
                            <br><select wire:model="direction">
                                @foreach (\App\Models\Direction::all() as $direction)
                                    <option value="{{$direction->id}}">{{$direction->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Вид</label>
                            <br><select wire:model="type">
                                @foreach (\App\Models\Type::all() as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Автор</label>
                            <br><select wire:model="author">
                                @foreach (\App\Models\Author::all() as $author)
                                    <option value="{{$author->id}}">{{$author->FIO}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Год</label>
                            <input type="number" wire:model="year" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Оценочная стоимость</label>
                            <input type="number" wire:model="price" class="form-control">
                        </div>
                            <label for="exampleInputEmail1">Владелец</label>
                            <br><select wire:model="owner" class="form-select">
                                @foreach (\App\Models\Owner::all() as $ow)
                                    <option wire:key="owner-{{$ow->id}}" value="{{$ow->id}}">{{$ow->FIO}}</option>
                                @endforeach
                            </select>
                        <hr>
                        <label for="exampleInputEmail1">Текущее фото</label>
                        <br>
                        <img src="{{asset('storage/img/paintings/'.$editablePainting->file->name)}}" height="100px" width="auto" alt="">
                        @if ($file !== null)
                            <hr>
                            <label for="exampleInputEmail1">Новое фото</label>
                            <br>
                            <img src="{{$file->temporaryUrl()}}" height="100px" width="auto" alt="">
                        @endif
                        <hr/>
                        <div class="form-group">
                            <br>
                            <input type="file" wire:model="file">
                        </div>
                        <hr/>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" data-dismiss="modal"
                                   wire:click="updatePainting">
                        </div>
                    </div>
                    @else
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Добавить экспозицию</h5>
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
                                    <label for="exampleInputEmail1">Направление</label>
                                    <br><select wire:model="direction">
                                        <option value="" selected></option>
                                        @foreach (\App\Models\Direction::all() as $direction)
                                            <option value="{{$direction->id}}">{{$direction->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Вид</label>
                                    <br><select wire:model="type">
                                        <option value="" selected></option>
                                        @foreach (\App\Models\Type::all() as $type)
                                            <option value="{{$type->id}}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Автор</label>
                                    <br><select wire:model="author">
                                        <option value="" selected></option>
                                        @foreach (\App\Models\Author::all() as $author)
                                            <option value="{{$author->id}}">{{$author->FIO}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Год</label>
                                    <input type="number" wire:model="year" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Оценочная стоимость</label>
                                    <input type="number" wire:model="price" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Владелец</label>
                                    <br><select wire:model="owner">
                                        <option value="" selected></option>
                                        @foreach ($owners as $owner)
                                            <option value="{{$owner->id}}">{{$owner->FIO}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($file !== null)
                                    <hr>
                                    <label for="exampleInputEmail1">Новое фото</label>
                                    <br>
                                    <img src="{{$file->temporaryUrl()}}" height="100px" width="auto" alt="">
                                @endif
                                <hr/>
                                <div class="form-group">
                                    <br>
                                    <input type="file" wire:model="file">
                                </div>
                                <hr/>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-primary" data-dismiss="modal"
                                           wire:click="createPainting">
                                </div>
                            </div>
                        </div>
                </div>
            @endif
        </div>
    </div>
</div>
