@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Добавление нового объекта - cemetery</div>
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

<script>
    $(".js-test-toggle").change(function()
    {
        if ($(this).is(":checked"))
        {
            $(".js-test").show();
        } else
        {
            $(".js-test").hide();
        }
    }).change();
</script>

@endsection