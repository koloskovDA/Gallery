<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Авторы
                        <button class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModalCenter">Добавить автора</button>
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
                            @foreach ($authors as $author)
                                <tr>
                                    <td>{{$author->FIO}}</td>
                                    @if ($author->file !== null)
                                        <td><img src="{{asset('storage/img/authors/'.$author->file->name)}}" width="50px" alt=""></td>
                                    @endif
                                    <td>{{$author->created_at}}</td>
                                    <td class="pl-0 pr-0"><input class="btn btn-warning btn-sm" value="E" type="button" wire:click="editAuthor({{$author->id}})" data-toggle="modal" data-target="#exampleModalCenter"></td>
                                    <td class="pl-0 pr-0"><input class="btn btn-danger btn-sm" value="X" type="button" wire:click="deleteAuthor({{$author->id}})"></td>
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
                    <h5 class="modal-title" id="exampleModalLongTitle">Изменить автора</h5>
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
                    <img src="{{asset('storage/img/authors/'.$editableAuthor->file->name)}}" height="100px" width="auto" alt="">
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
                    <input type="submit" class="btn btn-primary" data-dismiss="modal" wire:click="updateAuthor">
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
                        <input type="submit" class="btn btn-primary" data-dismiss="modal" wire:click="createAuthor">
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
