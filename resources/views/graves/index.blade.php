@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Захоронения</div>
                    <div class="panel-body">

                        <a href="{{ url('/graves/create') }}" class="btn btn-primary" title="Добавить новый элемент grave">Добавить новый элемент grave</a>
                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Покойные</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($graves as $item)
                                    <tr>
                                        <td>
                                            {{$item->sizeGrave}}
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