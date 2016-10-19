@extends('layouts.app')

@section('content')
<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-body">
            {!! form($form) !!}
            @if(Session::has('result'))
            <br>
            <p class="alert {{ Session::get('result')['class'] }}">{{ Session::get('result')['text'] }}</p>
            @endif
        </div>
    </div>
</div>
@endsection