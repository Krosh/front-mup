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
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="{{URL::asset('js/components/riot-leaflet.tag.html')}}" type="riot/tag"></script>
    <script src="{{URL::asset('js/components/rg-highcharts.tag.html')}}" type="riot/tag"></script>
    <script src="{{URL::asset('js/components/search-one-result.tag.html')}}" type="riot/tag"></script>
    <script src="{{URL::asset('js/components/search-results.tag.html')}}" type="riot/tag"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/riot/2.6.2/riot+compiler.min.js"></script>


</head>
<body>
<div class="b-main">
    <div class="b-shadow">
    </div>
    <div class="b-navigation">
        <div class="b-find">
            <div class="b-find__row">
                <div class="b-find__btn-menu">
                    <div class="btn-menu__pic">
                        <a href="#" id="btnMenu">
                           <div> </div>
                           <div> </div>
                           <div> </div>
                        </a>
                    </div>
                </div>
                <div class="b-find__field-find">
                    <form action="#" class="js-search-form">
                        <input type="text" id="js-search-fio" placeholder="Поиск по ФИО">
                        <a href = "#" class="js-search"><i class="fa fa-search" aria-hidden="true"></i></a>
                    </form>
                </div>
                <div>
                    <a href="#" class="js-toggle-search-options"> Параметры поиска <i class="fa fa-cog" aria-hidden="true"></i> </a>
                </div>
            </div>
            <div class="b-find__row js-search-options" style="display: none">
                <div>
                </div>
            </div>


            <!--            <div style="padding: 15px;background-color: white;display: inline-block;margin-top: 5px">
                            <a href="#" class="btnCardOpen">Открыть карточку</a>
                        </div>
                        <div style="padding: 15px;background-color: white;display: inline-block;margin-top: 5px">
                            <a href="#modal" class="default_popup">Открыть popup</a>
                        </div>
            -->        </div>
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
            <div class="card_title-wrap">
            <div class="card_title">
                <h3 class="js-name">123</h3>
                <div class="popup_close btnCardClose"><i class="fa fa-times" aria-hidden="true"></i></div>
            </div>
            </div>
            <div class="card_content">
                <table>
                    <tr>
                        <td class = "card__icon-column">
                            <i class="fa fa-map-marker fa-2x"></i>
                        </td>
                        <td>
                            <p class="js-adres">123</p>
                        </td>
                    </tr>
                    <tr>
                        <td class = "card__icon-column">
                            <i class="fa fa-user-circle fa-2x"></i>
                        </td>
                        <td>
                            <p class="js-watcher-name">123</p>
                        </td>
                    </tr>
                    <tr>
                        <td class = "card__icon-column">
                            <i class="fa fa-phone fa-2x"></i>
                        </td>
                        <td>
                            <p class="js-watcher-phone">123</p>
                        </td>
                    </tr>
                    <tr>
                        <td class = "card__icon-column">
                            <i class="fa fa-map fa-2x"></i>
                        </td>
                        <td>
                            <p class="js-cadastr-num">123</p>
                        </td>
                    </tr>
                    <tr>
                        <td class = "card__icon-column">
                            <i class="fa fa-gears fa-2x"></i>
                        </td>
                        <td>
                            <p class="js-organisation-name">123</p>
                        </td>
                    </tr>
                    <tr>
                        <td class = "card__icon-column">
                            <img class="card__icon-img" src="{{url('/images/size.png')}}">
                        </td>
                        <td>
                            <p class="js-square-info">123</p>
                        </td>
                    </tr>
                    <tr>
                        <td class = "card__icon-column">
                            <img class="card__icon-img" src="{{url('/images/grave.png')}}">
                        </td>
                        <td>
                            <p class="js-graves-count">123</p>
                        </td>
                    </tr>

                </table>
                <div style="width: 350px">
                    <rg-highcharts>

                    </rg-highcharts>
                </div>

            </div>
        </div>
    </div>
    <div class="sidebar left sidebar-search-card card_cont">
        <div class="card">
            <div class="card_title-wrap card-wrap-find">
            <div class="card_title card_title-find">
                <h3 class="card_title-text">Результаты поиска</h3>
                <div class="popup_close btnSearchCardClose"><i class="fa fa-times" aria-hidden="true"></i></div>
            </div>
                </div>
            <div class="card_content card_content-find">
                <search-results>

                </search-results>
            </div>
        </div>
    </div>
</div>
<div id="dead-modal" class="popup" style="display:none;">
    <div class="modal-content">
        <p>123</p>
    </div>

</div>

<!--<a href="#dead-modal" class="default_popup" style="visibility: hidden">Default Inline</a>
-->

<script>
    var map;
    var cemeteries = [];
    var heatmaps = [];
    var pieCharts;
    var maxValue = 100;
    var tempMarker = null;
    var defaultMapConfig = {
        zoom: 10,
        centerPos: [53.315408, 83.822352],
    }


    function addMarker(lat,lng)
    {
        if (tempMarker != null)
            removeMarker();
        tempMarker = L.marker([lat, lng]).addTo(map.map);
        tempMarker.on("click",showSearchContainer);
    }

    function removeMarker()
    {
        map.map.removeLayer(tempMarker);
    }


    initMapContainer();


    riot.mount("riot-leaflet",{
        zoom: defaultMapConfig.zoom,
        centerPos: defaultMapConfig.centerPos,
        onMountMap: function() {
            map = this;
            map.map.zoomControl.setPosition('topright');
            aja()
                .url('<?=url("/cemeteries/info"); ?>')
                .on('success', (data) => {
                    pieCharts = map.addChartLayer("pie-charts");
                    data.forEach((elem) => {
                           addCemeteryPolygon(elem.geo,elem.id);
                           addChart(elem.geo);
                           addHeatmap(elem.heatmap,elem.id);
                        });
                    initMapContainer();
                })
            .go();
            }
        });



    var searchResults = null;
    riot.mount("search-results",{onLoad: function() {searchResults = this}});

    var chart = null;
    riot.mount("rg-highcharts",{
        onLoad: function() {
            chart = this;
        },
        chartOptions: {}
    });

    var addCemeteryPolygon = (elem, index) => {
        let layer = map.addGeoJsonLayer("cemetery"+index,elem);
        layer.bringToBack();
        layer.on("click",(e) => {
            showPanel(elem.features[0].properties);
        });
        map.map.removeLayer(layer);
        cemeteries[index] = layer;
    }

    var addHeatmap = (elem, index) => {
        let heat = L.heatLayer(elem.points, {radius: elem.radius});
        heatmaps[index] = heat;
    }

    var formatCemeterySize = (text) => {
        return text.toFixed(0).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
    }

    var addChart = (elem) => {
        let chart = new L.PieChartMarker(new L.LatLng(elem.features[0].properties.centerLat, elem.features[0].properties.centerLon), {
            color: '#000',
            iconSize: new L.Point(80, 40),
            weight: 1,
            radius: 40,
            fillOpacity: 0.9,
            data : {
                'Свободная:': elem.features[0].properties.totalSize - elem.features[0].properties.fillSize,
                'Занятая:': elem.features[0].properties.fillSize,
            },
            chartOptions : {
                'Свободная:': {
                    fillColor: '#FF0000',
                    displayText: formatCemeterySize,
                },
                'Занятая:': {
                    fillColor: '#BDC9E1',
                    displayText: formatCemeterySize,
                },
            }
        });
        chart.on("click",(e) => {
            showPanel(elem.features[0].properties);
       })
       pieCharts.addLayer(chart);
    }


    // Init jquery events
    $(document).ready(function ()
    {
        $(".js-search").click(search);
        $(".js-search-form").submit(search);
    });

    function search()
    {
        aja()
            .url('<?=url("/deads/search"); ?>')
            .data({fio: $("#js-search-fio").val()})
            .on('success', function(data) {
                showSearchResults(data)
            })
            .go();
        return false;
    }


    function showHeatMap(idCemetery)
    {
        showCemeteryPolygon(idCemetery);
        heatmaps[idCemetery].addTo(map.map);
    }


    function showSearchContainer()
    {
        $(".sidebar.left.sidebar-menu").trigger("sidebar:close");
        $(".sidebar.left.sidebar-card").fadeOut();
        $(".sidebar.left.sidebar-search-card").fadeIn();
    }


    function showSearchResults(data)
    {
        showSearchContainer();
        searchResults.loadItems(data);
    }

    function showDefaultMap(){
        hideCemeteriesPolygons()
        removeMarker();
        map.map.addLayer(pieCharts);
        map.map.setView(defaultMapConfig.centerPos,defaultMapConfig.zoom);
    }

    function showCemeteryPolygon(idCemetery)
    {
        let cemeteryLayer = cemeteries[idCemetery];
        map.map.addLayer(cemeteryLayer);
        map.map.fitBounds(cemeteryLayer.getBounds(), {animate: true});
    }

    function hideCemeteriesPolygons()
    {
        cemeteries.forEach((elem) => {
            map.map.removeLayer(elem);
        });
    }

    function showDeadOnMap(idDead)
    {
        aja()
            .url('<?=url("/deads/info"); ?>')
            .data({id: idDead})
            .on('success', function(data) {
                showCemeteryPolygon(data.idCemetery);
                addMarker(data.lat,data.lng);
                map.map.removeLayer(pieCharts);
            })
            .go();
    }


    function showDeadCard(idDead)
    {
        aja()
            .url('<?=url("/deads/info"); ?>')
            .data({id: idDead})
            .on('success', function(data) {
                // Костыль
                $(".default_popup").click();
            })
            .go();
    }

    function showPanel(params)
    {
        $(".sidebar.left.sidebar-menu").trigger("sidebar:close");
        $(".sidebar.left.sidebar-card").fadeIn();
        $(".sidebar.left.sidebar-search-card").fadeOut();
        $(".card .js-name").text(params.name);
        $(".card .js-adres").text(params.adres);
        $(".card .js-watcher-name").text(params.watcher_name);
        $(".card .js-watcher-phone").text(params.watcher_phone);
        $(".card .js-cadastr-num").text(params.cadastr_num);
        $(".card .js-organisation-name").text(params.organisation_name);
        $(".card .js-square-info").html(params.square_info);
        $(".card .js-graves-count").text(params.graves_count);
        chart.changeChart(JSON.parse(params.graves_dynamic));
    }


    function initMapContainer()
    {
        var mapContainer = document.getElementById("map");
        mapContainer.style.width = document.documentElement.clientWidth.toString()+"px";
        mapContainer.style.height = document.documentElement.clientHeight.toString()+"px";
    }


</script>
</body>
</html>
