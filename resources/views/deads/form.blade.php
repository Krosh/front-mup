{!! Form::model($dead, [
'method' => $method,
'url' => $url,
'class' => 'form-horizontal',
'files' => true
]) !!}

<div class="form-group {{ $errors->has('family') ? 'has-error' : ''}}">
    {!! Form::label('family', 'Фамилия', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('family', null, ['class' => 'form-control']) !!}
        {!! $errors->first('family', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Имя', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('patron') ? 'has-error' : ''}}">
    {!! Form::label('patron', 'Отчество', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('patron', null, ['class' => 'form-control']) !!}
        {!! $errors->first('patron', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('dateBorn') ? 'has-error' : ''}}">
    {!! Form::label('dateBorn', 'Дата рождения', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::date('dateBorn', null, ['class' => 'form-control']) !!}
        {!! $errors->first('dateBorn', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('dateDeath') ? 'has-error' : ''}}">
    {!! Form::label('dateDeath', 'Дата смерти', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::date('dateDeath', null, ['class' => 'form-control']) !!}
        {!! $errors->first('dateDeath', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('memorial') ? 'has-error' : ''}}">
    {!! Form::label('memorial', 'Памятник', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('memorial', null, ['class' => 'form-control']) !!}
        {!! $errors->first('memorial', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('memorialMaterial') ? 'has-error' : ''}}">
    {!! Form::label('memorialMaterial', 'Материал', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('memorialMaterial', null, ['class' => 'form-control']) !!}
        {!! $errors->first('memorialMaterial', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('sizeMemorial') ? 'has-error' : ''}}">
    {!! Form::label('sizeMemorial', 'Размер', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('sizeMemorial', null, ['class' => 'form-control']) !!}
        {!! $errors->first('sizeMemorial', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group">
    <div class="col-md-offset-4 col-md-8">
        {!! Form::submit('Сохранить', ['class' => 'btn btn-primary']) !!}
        <a href = "<?=$dead->getGraveUrl(); ?>" class = "btn btn-warning">Вернуться к списку</a>
    </div>
</div>

{!! Form::hidden('idGrave', null) !!}

{!! Form::close() !!}