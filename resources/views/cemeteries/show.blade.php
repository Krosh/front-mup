@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">cemetery {{ $cemetery->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('cemeteries/' . $cemetery->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit cemetery"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['cemeteries', $cemetery->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete cemetery',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $cemetery->id }}</td>
                                    </tr>
                                    <tr><th> Name </th><td> {{ $cemetery->name }} </td></tr><tr><th> Cadastr Num </th><td> {{ $cemetery->cadastr_num }} </td></tr><tr><th> IdCity </th><td> {{ $cemetery->idCity }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection