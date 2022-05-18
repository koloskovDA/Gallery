<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Квитанции об оплате билетов
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <td>Выставка</td>
                                <td>Пользователь</td>
                                <td>Статус</td>
                            </tr>
                            </thead>
                            @foreach ($receipts as $receipt)
                                <tr>
                                    <td>
                                        <a href="{{route('admin.exhibition', ['exhibition_id' => $receipt->ticket->exhibition->id])}}">{{$receipt->ticket->exhibition->name}}</a>
                                    </td>
                                    <td><a href="{{route('user', ['user_id' => $receipt->ticket->user->id])}}">{{$receipt->ticket->user->name}}</a></td>
                                    <td>
                                        @if($receipt->status === 'approved')
                                            <button wire:click="editReceipt({{$receipt->id}})" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-success">
                                                Подтверждена
                                            </button>
                                        @elseif($receipt->status === 'rejected')
                                            <button wire:click="editReceipt({{$receipt->id}})" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-danger">
                                                Отклонена
                                            </button>
                                        @else
                                            <button wire:click="editReceipt({{$receipt->id}})" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-warning">
                                                Проверить
                                            </button>
                                        @endif
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
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Проверить квитанцию</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <img src="{{asset('storage/img/receipts/'.$editableReceipt?->file?->name)}}" alt="" class="img-thumbnail" style="max-height: 300px;">
                    </div>
                    <div class="form-group">
                        <input type="button" wire:click="approveReceipt" class="btn btn-outline-success" data-dismiss="modal" value="Подтвердить оплату">
                        <input type="button" wire:click="rejectReceipt" class="btn btn-outline-danger" data-dismiss="modal" value="Не оплачено">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
