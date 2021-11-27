<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Направления
                        @can('work')
                        <button class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModalCenter">Добавить направление</button>
                            @endcan
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <td>Название</td>
                                <td>Дата добавления</td>
                            </tr>
                            </thead>
                            @foreach ($directions as $direction)
                                <tr>
                                    <td><a href="{{route('direction.paintings', [$direction->id])}}">{{$direction->name}}</a></td>
                                    <td>{{$direction->created_at}}</td>
                                    @can('work')
                                    <td class="pl-0 pr-0"><input class="btn btn-warning btn-sm" value="E" type="button" wire:click="editDirection({{$direction->id}})" data-toggle="modal" data-target="#exampleModalCenter"></td>
                                    <td class="pl-0 pr-0"><input class="btn btn-danger btn-sm" value="X" type="button" wire:click="deleteDirection({{$direction->id}})"></td>
                                        @endcan
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
                        <h5 class="modal-title" id="exampleModalLongTitle">Изменить направление</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Название</label>
                            <input type="text" wire:model="name" class="form-control">
                        </div>
                        <hr>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" data-dismiss="modal" wire:click="updateDirection">
                    </div>
                </div>
            @else
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Добавить направление</h5>
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
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" data-dismiss="modal" wire:click="createDirection">
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
