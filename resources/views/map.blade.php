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
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="{{URL::asset('js/components/riot-leaflet.tag.html')}}" type="riot/tag"></script>
    <script src="{{URL::asset('js/components/rg-highcharts.tag.html')}}" type="riot/tag"></script>
    <script src="{{URL::asset('js/components/search-one-result.tag.html')}}" type="riot/tag"></script>
    <script src="{{URL::asset('js/components/search-results.tag.html')}}" type="riot/tag"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/riot/2.6.2/riot+compiler.min.js"></script>
    <script src="{{URL::asset('js/all.js')}}"></script>


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
                    asdasdas:asdasdasd<br>
                    asdasdas:asdasdasd<br>
                    asdasdas:asdasdasd<br>
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

<!--    Карточка кладбища   -->
    <div class="sidebar left sidebar-card card_cont">
        <div class="card">
            <div class="card_title-wrap">
            <div class="card_title">
                <h3 class="js-name">123</h3>
                <div class="popup_close btnCardClose"><i class="fa fa-times" aria-hidden="true"></i></div>
                <div class="b-card-button">
                    <button class="btn-card js-btn-chart btn-card-active">Диаграмма</button>
                    <button class="btn-card js-btn-heatmap">Тепловая карта</button>
                    <!--      <button class="btn-card">3 кнопка</button>
                    -->
                </div>
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
                            <i class="fa fa-2x fa-lock"></i>
                        </td>
                        <td>
                            <p class="js-status">Закрыто</p>
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
                            <span class="has-hint">
                                <span class="js-square-total">123</span>
                                <span class="hint">
                                    Общая площадь
                                </span>
                            </span>
                            /
                            <span class="has-hint">
                                <span class="js-deads-square">123</span>
                                <span class="hint">
                                    Под захоронениями
                                </span>
                            </span>
                            /
                            <span class="has-hint">
                                <span class="js-square-filled">123</span>
                                <span class="hint">
                                    Занятая площадь
                                </span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class = "card__icon-column">
                            <img class="card__icon-img" src="{{url('/images/grave.png')}}">
                        </td>
                        <td>
                            <span class="has-hint">
                                <span class="js-graves-count">123</span>
                                <span class="hint">
                                    Захоронений
                                </span>
                            </span>
                            /
                            <span class="has-hint">
                                <span class="js-deads-count">123</span>
                                <span class="hint">
                                    Покойных
                                </span>
                            </span>
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

    <!--    Результаты поиска   -->
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

<script>


</script>
<script>
    $(document).ready(function () {
        $(".card_cont").mCustomScrollbar({
            theme:"dark-3",
            scrollButtons:{ enable: true }
        });
        $(".btn-card").click(function () {
            $(".btn-card").removeClass('btn-card-active');
            $(this).toggleClass('btn-card-active');
        });
        $(".js-toggle-search-options").click(function(elem){
            $(".js-search-options").slideToggle();
        });
        $(".btnCardClose").click(
            function () {
                $(".sidebar.left.sidebar-card").fadeOut();
                app.cardClose();
            }
        );
        $(".btnSearchCardClose").click(
            function () {
                $(".sidebar.left.sidebar-search-card").fadeOut();
                app.searchCardClose();
            }
        );

//        initMapContainer();
        let baseUrl = "/public";
        var app = new MapApplication(baseUrl);
        app.init();
        $(".js-search").click(app.search);
        $(".js-search-form").submit(app.search);
    })
</script>
</body>
</html>
