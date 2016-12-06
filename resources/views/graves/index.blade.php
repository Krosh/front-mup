@extends('layouts.app')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="{{url('/')}}">Главная</a></li>
    <li><a href="{{url('/cemeteries')}}">Кладбища</a></li>
    <li><a href="{{url('/cemeteries/'.$cemetery->id.'/edit')}}">{{$cemetery->name}}</a></li>
    <li class="active">Захоронения - управление</li>
</ol>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Захоронения
                        <a href="{{ url('cemeteries/'.$cemetery->id.'/graves/create') }}" class="btn btn-primary pull-right" title="Добавить новый элемент grave">Добавить новое захоронение</a>
                        <div class="clearfix"></div>

                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Покойные</th>
                                        <th>Размер</th>
                                        <th>Состояние</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($graves as $item)
                                    <tr>
                                        <td>
                                            {{$item->getDeadsInfo()}}
                                        </td>
                                        <td>
                                            {{$item->sizeGrave}}
                                        </td>
                                        <td>
                                            {{$item->getStateAsString()}}
                                        </td>

                                        <td>
                                            <a href="{{ url('/graves/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs" title="Редактировать"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/graves', $item->id],
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
                            <div class="pagination-wrapper"> {!! $graves->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection