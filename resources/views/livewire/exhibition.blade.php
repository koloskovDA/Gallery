<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Экспозиции
                        <button class="btn btn-success float-right" data-toggle="modal"
                                data-target="#exampleModalCenter">Добавить экспозицию
                        </button>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <td>Название</td>
                                <td>Дата добавления</td>
                            </tr>
                            </thead>
                            @foreach ($expositions as $exposition)
                                <tr>
                                    <td>
                                        <a href="{{route('admin.exposition', ['exposition_id' => $exposition->id])}}">{{$exposition->name}}</a>
                                    </td>
                                    <td>{{$exposition->created_at}}</td>
                                    <td class="pl-0 pr-0"><input class="btn btn-warning btn-sm" value="E" type="button"
                                                                 wire:click="editExposition({{$exposition->id}})"
                                                                 data-toggle="modal" data-target="#exampleModalCenter">
                                    </td>
                                    <td class="pl-0 pr-0"><input class="btn btn-danger btn-sm" value="X" type="button"
                                                                 wire:click="deleteExposition({{$exposition->id}})">
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
                        <h5 class="modal-title" id="exampleModalLongTitle">Изменить экспозицию</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Название</label>
                            <input type="text" wire:model="name" class="form-control">
                        </div>
                        <hr/>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" data-dismiss="modal"
                                   wire:click="updateExposition">
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
                                <hr/>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-primary" data-dismiss="modal"
                                           wire:click="createExposition">
                                </div>
                            </div>
                        </div>
                </div>
            @endif
        </div>
    </div>
</div>
