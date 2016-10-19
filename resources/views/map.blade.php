<?php
/**
 * Created by JetBrains PhpStorm.
 * User: БОСС
 * Date: 22.08.16
 * Time: 13:52
 * To change this template use File | Settings | File Templates.
 */
//$cs = Yii::app()->clientScript;
//$cs->registerCssFile("https://npmcdn.com/leaflet@0.7.7/dist/leaflet.css");
//$cs->registerScriptFile("https://npmcdn.com/leaflet@0.7.7/dist/leaflet.js");
//$cs->registerScriptFile("http://api-maps.yandex.ru/2.0/?load=package.map&lang=ru-RU");
//$cs->registerScriptFile("/js/layer/tile/Yandex.js");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>
    <link rel="stylesheet" href="{{URL::asset('css/all.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/app.css')}}">
    <script src="{{URL::asset('js/all.js')}}"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <script src="{{URL::asset('js/components/riot-leaflet.tag.html')}}" type="riot/tag"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/riot/2.6.2/riot+compiler.min.js"></script>

</head>
<body>
<div class="b-main">
    <div class="b-shadow">
    </div>
    <div class="b-navigation">
        <div class="b-find">
            <div class="b-find__btn-menu">
                <div class="btn-menu__pic">
                    <a href="#" id="btnMenu">
                    </a>
                </div>
            </div>
            <div class="b-find__field-find">
                <input type="text">
            </div>
            <div style="padding: 15px;background-color: white;display: inline-block;margin-top: 5px">
                <a href="#" class="btnCardOpen">Открыть карточку</a>
            </div>
            <div style="padding: 15px;background-color: white;display: inline-block;margin-top: 5px">
                <a href="#modal" class="default_popup">Открыть popup</a>
            </div>
        </div>
    </div>
    <div class="b-map" >
        <div id="map">
            <riot-leaflet>

            </riot-leaflet>
        </div>
    </div>
</div>
<div class="sidebars">
    <div class="sidebar left sidebar-menu">
        <div class="sidebar-menu__title">
            Меню
            <br>
            <a href="#" id="btnMenuClose"><span>Закрыть</span></a>
            <br>
            <a href="#" class="js-map-style-by-regions">Подсветить по районам обслуживания</a>
            <a href="#" class="js-map-toggle-charts js-showed">Показать/скрыть диаграммы</a>
        </div>
    </div>
    <div class="sidebar left sidebar-card card_cont">
        <div class="card">
            <div class="card_content">
                <p>123</p>
            </div>
        </div>
        <div class="popup_close btnCardClose">×</div>
    </div>
</div>
<div id="modal" style="display:none;">
    <div class="modal-content">
        <p>123</p>
    </div>

</div>


<script>
   var map;
   riot.mount("riot-leaflet",{
        zoom: 10,
        centerPos: [53.315408, 83.822352],
        onMountMap: function() {
            map = this;
            map.map.zoomControl.setPosition('topright');
            aja()
                .url('<?=url("/map/districts"); ?>')
                .on('success', (data) => {
                    var layer = this.addGeoJsonLayer("cemetery",data);
                    layer.bringToBack();
                    this.map.fitBounds(layer.getBounds());
                })
            .go();
         }
    });


    initMapContainer();
    // Init jquery events
    $(document).ready(function ()
    {
        $('.default_popup').popup();


    });



    function initMapContainer()
    {
        var mapContainer = document.getElementById("map");
        mapContainer.style.width = document.documentElement.clientWidth.toString()+"px";
        mapContainer.style.height = document.documentElement.clientHeight.toString()+"px";
    }


</script>
</body>
</html>
