@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Cemeteries</div>
                    <div class="panel-body">

                        <a href="{{ url('/cemeteries/create') }}" class="btn btn-primary" title="Добавить новый элемент cemetery">Добавить новый элемент cemetery</a>
                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th> Наименование </th><th> Кадастровый номер</th><th> Город</th><th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($cemeteries as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td><td>{{ $item->cadastr_num }}</td><td>{{ $item->getCity() }}</td>
                                        <td>
                                            <a href="{{ url('/cemeteries/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs" title="Редактировать"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/cemeteries', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Удалить" />', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Удалить cemetery',
                                                        'onclick'=>'return confirm("Вы подтверждаете удаление?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $cemeteries->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection