<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Настройки профиля</div>

                    <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Никнейм</label>
                                <input type="text" wire:model="name" class="form-control" id="exampleInputEmail1"
                                       aria-describedby="emailHelp" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" wire:model="email" class="form-control" id="exampleInputEmail1"
                                       aria-describedby="emailHelp" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                @if (Auth::user()->file !== null)
                                    <label for="exampleInputEmail1">Текущее фото</label>
                                    <br>
                                    <img src="{{asset('storage/img/profile/'.Auth::user()->file->name)}}" alt="Avatar">
                                @else
                                    <label for="exampleInputEmail1">Нет фото</label>
                                    <br>
                                    <img src="{{asset('storage/img/templates/noimage.jpg')}}" height="100px" width="auto">
                                @endif
                                @if ($file !== null)
                                    <hr>
                                        <label for="exampleInputEmail1">Новое фото</label>
                                        <br>
                                    <img src="{{$file->temporaryUrl()}}" height="100px" width="auto" alt="">
                                @endif
                                <hr/>
                                <input type="file" wire:model="file">
                            </div>
                            <button class="btn btn-primary" wire:click="saveNewParameters">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
