<!DOCTYPE html>
<html>
<head>
    <title>Билет на выставку</title>
</head>
<body>
<h1>{{ $title }}</h1>
<p>Дата оформления: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i:s') }}</p>
<p>Билет на выставку {{$exhibition->name}}. На ней будут представлены экспозиции:
    @foreach($exhibition->expositions as $key => $exposition)
        <br>
        - «{{$exposition->name}}» с картинами
        @foreach ($exposition->paintings as $key => $painting)
            @if ($key + 1 === $exposition->paintings->count())
                «{{$painting->name}}».
            @else
                «{{$painting->name}}»,
            @endif
        @endforeach
    @endforeach
</p>
<p>
    @if($exhibition->starts_at)
        Выставка пройдет с {{\Carbon\Carbon::make($exhibition->starts_at)->translatedFormat('d F Y (l), H:i')}}
    @endif
    @if($exhibition->ends_at)
        по {{\Carbon\Carbon::make($exhibition->ends_at)->translatedFormat('d F Y (l), H:i')}}
    @endif по адресу: {{$exhibition->address}}
</p>

</body>
</html>
