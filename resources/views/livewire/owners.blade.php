<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Владельцы
                        <button class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModalCenter">Добавить владельца</button>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <td>ФИО</td>
                                <td></td>
                                <td>Дата добавления</td>
                            </tr>
                            </thead>
                            @foreach ($owners as $owner)
                                <tr>
                                    <td>{{$owner->FIO}}</td>
                                    @if ($owner->file !== null)
                                        <td><img src="{{asset('storage/img/Owners/'.$owner->file->name)}}" width="50px" alt=""></td>
                                    @endif
                                    <td>{{$owner->created_at}}</td>
                                    <td class="pl-0 pr-0"><input class="btn btn-warning btn-sm" value="E" type="button" wire:click="editOwner({{$owner->id}})" data-toggle="modal" data-target="#exampleModalCenter"></td>
                                    <td class="pl-0 pr-0"><input class="btn btn-danger btn-sm" value="X" type="button" wire:click="deleteOwner({{$owner->id}})"></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" wire:ignore.self id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            @if ($keyToEdit === true)
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Изменить владельца</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">ФИО</label>
                            <input type="text" wire:model="fio" class="form-control">
                        </div>
                        <hr>
                        <label for="exampleInputEmail1">Текущее фото</label>
                        <br>
                        <img src="{{asset('storage/img/owners/'.$editableOwner->file->name)}}" height="100px" width="auto" alt="">
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
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" data-dismiss="modal" wire:click="updateOwner">
                    </div>
                </div>
            @else
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Добавить автора</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">ФИО</label>
                            <input type="text" wire:model="fio" class="form-control">
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
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" data-dismiss="modal" wire:click="createOwner">
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
