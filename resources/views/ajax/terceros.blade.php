@extends('eusalud2')
@section('content')

<div class="container">
    <h1>Terceros</h1>
    <hr>
    <ul>
        @foreach($info as $row)
        <li>{{ $row->TrcRazSoc }}</li>
        @endforeach
    </ul>
</div>

@stop