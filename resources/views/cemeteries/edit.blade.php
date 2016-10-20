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

                    <a href = "#" class="btn btn-success js-get-cemetery-coords">Получить контуры по кадастровому номеру</a>
                    <div class="col-md-12" style="height: 400px">
                        <riot-leaflet>
                        </riot-leaflet>
                    </div>
                    <script>
                        var map = null;
                        $(document).ready(function ()
                        {
                            riot.mount("riot-leaflet",{
                                zoom: 10,
                                centerPos: [53.315408, 83.822352],
                                onMountMap : function()
                                {
                                    map = this;
                                    $(".js-get-cemetery-coords").click(function()
                                    {
                                        let cadastr_num = $("#cadastr_num").val();
                                        if (cadastr_num == "")
                                            return
                                        aja()
                                            .method("post")
                                            .url('<?=url("/cemeteries/".$cemetery->id."/cadastr"); ?>')
                                            .header('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'))
                                            .data({cadastr_num: cadastr_num})
                                            .on('success', (data) => {
                                                let layer = map.addGeoJsonLayer(cadastr_num,data);
                                                layer.bringToBack();
                                                map.map.fitBounds(layer.getBounds());
                                             })
                                        .go();
                                        return false;
                                    }).click();
                                }
                            });
                        });
                    </script>
                    <a href = "<?= url("cemeteries"); ?>" class="btn btn-warning">Вернуться к списку</a>
                    {!! form_end($form) !!}

                </div>


            </div>
        </div>
    </div>
</div>
@endsection