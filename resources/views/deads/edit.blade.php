@extends('layouts.app')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="{{url('/')}}">Главная</a></li>
    <li><a href="{{url('/cemeteries')}}">Кладбища</a></li>
    <li><a href="{{url('/cemeteries/'.$dead->getCemetery()->id.'/edit')}}">{{$dead->getCemetery()->name}}</a></li>
    <li><a href="{{url('/cemeteries/'.$dead->getCemetery()->id.'/graves')}}">Захоронения</a></li>
    <li><a href="{{$dead->getGraveUrl()}}">Захоронение № {{$dead->idGrave}}</a></li>
    <li class="active">Покойный №{{$dead->id}}</li>
</ol>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Редактирование информации о покойном №{{ $dead->id }}</div>
                    <div class="panel-body">

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                       @include('deads.form',['url' => ['/deads', $dead->id], 'method' => 'PATCH'])

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection