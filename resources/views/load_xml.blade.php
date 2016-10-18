@extends('layouts.app')

@section('content')
<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-body">
            {!! form($form) !!}
        </div>
    </div>
</div>
@if(Session::has('result'))
<p class="alert {{ Session::get('result')['class'] }}">{{ Session::get('result')['text'] }}</p>
@endif
@endsection