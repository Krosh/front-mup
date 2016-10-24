@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Редактироване объекта dead {{ $dead->id }}</div>
                    <div class="panel-body">

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($dead, [
                            'method' => 'PATCH',
                            'url' => ['/deads', $dead->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                                    <div class="form-group {{ $errors->has('family') ? 'has-error' : ''}}">
                {!! Form::label('family', 'Family', ['class' => 'col-md-4 control-label']) !!}
                <div class="col-md-6">
                    {!! Form::text('family', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('family', '<p class="help-block">:message</p>') !!}
                </div>
            </div>


                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-8">
                                {!! Form::submit('Сохранить', ['class' => 'btn btn-primary']) !!}
                                <a href = "<?=url("/deads"); ?>" class = "btn btn-warning">Вернуться к списку</a>
                            </div>
                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection