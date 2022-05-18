<div>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Билеты пользователя {{$user->name}}
                        </div>

                        <div class="card-body">
                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <td>Выставка</td>
                                    <td>Начало</td>
                                    <td>Окончание</td>
                                </tr>
                                </thead>
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td>
                                            <a href="{{route('admin.exhibition', ['exhibition_id' => $ticket->exhibition->id])}}">{{$ticket->exhibition->name}}</a>
                                        </td>
                                        <td>
                                            @if($ticket->exhibition->starts_at)
                                                {{\Carbon\Carbon::make($ticket->exhibition->starts_at)->translatedFormat('d F Y (l), H:i')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($ticket->exhibition->ends_at)
                                                {{\Carbon\Carbon::make($ticket->exhibition->ends_at)->translatedFormat('d F Y (l), H:i')}}
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
    </div>
</div>
