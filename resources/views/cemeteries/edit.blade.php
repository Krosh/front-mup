@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Редактироване объекта cemetery {{ $cemetery->id }}</div>
                <div class="panel-body">

                    @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    @endif

                    {!! form_start($form) !!}
                    {!! form_until($form,"cadastr_num") !!}

                    <a href = "<?= url("cemeteries"); ?>" class="btn btn-warning">Вернуться к списку</a>
                    {!! form_end($form) !!}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection