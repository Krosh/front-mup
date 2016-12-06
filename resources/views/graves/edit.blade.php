@extends('layouts.app')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="{{url('/')}}">Главная</a></li>
    <li><a href="{{url('/cemeteries')}}">Кладбища</a></li>
    <li><a href="{{url('/cemeteries/'.$grave->idCemetery.'/edit')}}">{{$grave->getCemetery()->name}}</a></li>
    <li><a href="{{url('/cemeteries/'.$grave->idCemetery.'/graves')}}">Захоронения</a></li>
    <li class="active">Захоронение №{{$grave->id}}</li>
</ol>
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#main" aria-controls="main" role="tab" data-toggle="tab">Основная информация</a></li>
                <li role="presentation"><a href="#dead" aria-controls="dead" role="tab" data-toggle="tab">Данные о покойных</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="main">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">Редактирование информации о захоронении №{{ $grave->id }}</div>
                            <div class="panel-body">
                                @if ($errors->any())
                                <ul class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                @endif

                                {!! form($form) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="dead">
                    <a href="{{ url('/deads/create',["idGrave" => $grave->id]) }}" class="btn btn-primary" title="Добавить новый элемент grave">Добавить информацию о покойном</a>
                    <div class="table-responsive ">
                        <table class="table table-borderless">
                            <thead>
                            <tr>
                                <th>Покойные</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($deads as $item)
                            <tr>
                                <td>
                                    {{$item->getFio() }}
                                </td>

                                <td>
                                    <a href="{{ url('/deads/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs" title="Редактировать"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                                    {!! Form::open([
                                    'method'=>'DELETE',
                                    'url' => ['/deads', $item->id],
                                    'style' => 'display:inline'
                                    ]) !!}
                                    {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Удалить" />', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Удалить grave',
                                    'onclick'=>'return confirm("Вы подтверждаете удаление?")'
                                    )) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection