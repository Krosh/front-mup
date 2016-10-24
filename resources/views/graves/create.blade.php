@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Добавление нового объекта - grave</div>
                    <div class="panel-body">

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::open(['url' => '/graves', 'class' => 'form-horizontal', 'files' => true]) !!}

                        

                           <div class="form-group">
                              <div class="col-md-offset-4 col-md-8">
                                  {!! Form::submit('Сохранить', ['class' => 'btn btn-primary']) !!}
                                  <a href = "<?=url("/graves"); ?>" class = "btn btn-warning">Вернуться к списку</a>
                              </div>
                           </div>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection