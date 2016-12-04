/**
 * Created with JetBrains PhpStorm.
 * User: БОСС
 * Date: 04.12.16
 * Time: 23:33
 * To change this template use File | Settings | File Templates.
 */
var MapApplication = function(baseUrl) {
    var app = this;
    this.baseUrl = baseUrl;
    this.map = null;
    this.cemeteries = [];
    this.heatmaps = [];
    this.modes = [];
    const MODE_CHART = 1;
    const MODE_HEATMAP = 2;
    this.pieCharts = null;
    const maxValue = 100;
    this.tempMarker = null;
    const defaultMapConfig = {
        zoom: 10,
        centerPos: [53.315408, 83.822352],
    }
    this.searchResults = null;
    this.chart = null;


    this.addMarker = function(lat, lng) {
        app.removeMarker();
        app.tempMarker = L.marker([lat, lng]).addTo(app.map.map);
        app.tempMarker.on("click", app.showSearchContainer);
    }

    this.removeMarker = function() {
        if (app.tempMarker != null)
            app.map.map.removeLayer(app.tempMarker);
    }


    this.addCemeteryPolygon = function(elem, index) {
        let layer = app.map.addGeoJsonLayer("cemetery" + index, elem);
        layer.bringToBack();
        layer.on("click", (e) => {
            app.showPanel(elem.features[0].properties);
    });
    app.map.map.removeLayer(layer);
    app.cemeteries[index] = layer;
}

this.addHeatmap = (elem, index) => {
    let heat = L.heatLayer(elem.points, {
        radius: elem.radius
    });
    app.heatmaps[index] = heat;
}

this.formatCemeterySize = (text) => {
    return text.toFixed(0).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ') + " га";
}

this.addChart = (elem) => {
    let chart = new L.PieChartMarker(new L.LatLng(elem.features[0].properties.centerLat, elem.features[0].properties.centerLon), {
        color: '#000',
        iconSize: new L.Point(80, 40),
        weight: 1,
        radius: 10,
        fillOpacity: 0.9,
        data: {
            'Свободная:': elem.features[0].properties.totalSize - elem.features[0].properties.fillSize,
            'Занятая:': elem.features[0].properties.fillSize,
        },
        chartOptions: {
            'Свободная:': {
                fillColor: '#FF0000',
                displayText: app.formatCemeterySize,
            },
            'Занятая:': {
                fillColor: '#BDC9E1',
                displayText: app.formatCemeterySize,
            },
        }
    });
    chart.on("click", (e) => {
        app.showPanel(elem.features[0].properties);
})
app.pieCharts.addLayer(chart);
}


this.search = function() {
    aja()
        .url(baseUrl + "/deads/search")
        .data({
            fio: $("#js-search-fio").val()
        })
        .on('success', function(data) {
            app.showSearchResults(data)
        })
        .go();
    return false;
}


this.showHeatMap = function(idCemetery) {
    this.showCemeteryPolygon(idCemetery);
    this.heatmaps[idCemetery].addTo(this.map.map);
}

this.hideHeatMap = function(idCemetery) {
    this.hideCemeteryPolygon(idCemetery);
    this.map.map.removeLayer(this.heatmaps[idCemetery]);
}

this.showSearchContainer = function() {
    $(".sidebar.left.sidebar-menu").trigger("sidebar:close");
    $(".sidebar.left.sidebar-card").fadeOut();
    $(".sidebar.left.sidebar-search-card").fadeIn();
}


this.showSearchResults = function(data) {
    this.showSearchContainer();
    this.searchResults.loadItems(data);
}

this.showDefaultMap = function() {
    this.hideCemeteriesPolygons()
    this.removeMarker();
    this.map.map.addLayer(this.pieCharts);
    this.map.map.setView(this.defaultMapConfig.centerPos, this.defaultMapConfig.zoom);
}

this.showCemeteryPolygon = function(idCemetery) {
    let cemeteryLayer = this.cemeteries[idCemetery];
    this.map.map.addLayer(cemeteryLayer);
    this.map.map.fitBounds(cemeteryLayer.getBounds(), {
        animate: true
    });
}

this.hideCemeteryPolygon = function(idCemetery) {
    this.map.map.removeLayer(this.cemeteries[idCemetery]);
}


this.hideCemeteriesPolygons = function() {
    this.cemeteries.forEach((elem) => {
        this.map.map.removeLayer(elem);
});
}

this.showDeadOnMap = function(idDead) {
    aja()
        .url(baseUrl + "/deads/info")
        .data({
            id: idDead
        })
        .on('success', function(data) {
            app.showCemeteryPolygon(data.idCemetery);
            app.addMarker(data.lat, data.lng);
            app.map.map.removeLayer(app.pieCharts);
        })
        .go();
}

this.showDeadCard = function(idDead) {
    aja()
        .url(baseUrl + "/deads/info")
        .data({
            id: idDead
        })
        .on('success', function(data) {
            // Костыль
            // Чтобы открыть карточку, симулируем нажатие по кнопке
            $(".default_popup").click();
        })
        .go();
}

this.cardClose = function() {
    this.setDefaultView();
}

this.searchCardClose = function() {
    this.setDefaultView();
}


this.setDefaultView = function() {
    this.modes.forEach((elem, i) => {
        if (elem == this.MODE_HEATMAP) {
        this.clickChartButton(i);
    }
});
this.removeMarker();
this.hideCemeteriesPolygons();
this.map.map.addLayer(this.pieCharts);
}


this.clickHeatMapButton = function(id) {
    $(".btn-card-active").removeClass("btn-card-active");
    this.modes[id] = this.MODE_HEATMAP;
    this.showHeatMap(id);
    this.map.map.removeLayer(this.pieCharts);
    $(".js-btn-heatmap").addClass("btn-card-active");
}

this.clickChartButton = function(id) {
    $(".btn-card-active").removeClass("btn-card-active");
    this.modes[id] = MODE_CHART;
    this.hideHeatMap(id);
    this.map.map.addLayer(app.pieCharts);
    $(".js-btn-chart").addClass("btn-card-active");
}


this.showPanel = function(params) {
    $(".sidebar.left.sidebar-menu").trigger("sidebar:close");
    $(".sidebar.left.sidebar-card").fadeIn();
    $(".sidebar.left.sidebar-search-card").fadeOut();
    $(".card .js-name").text(params.name);
    $(".card .js-status").text(params.status ? "Кладбище закрыто" : "Кладбище открыто");
    $(".card .js-adres").text(params.adres);
    $(".card .js-watcher-name").text(params.watcher_name);
    $(".card .js-watcher-phone").text(params.watcher_phone);
    $(".card .js-cadastr-num").html(params.cadastr_num.join("<br>"));
    $(".card .js-organisation-name").text(params.organisation_name);
    $(".card .js-square-total").html(params.square_total);
    $(".card .js-deads-square").html(params.deads_square);
    $(".card .js-square-filled").html(params.square_filled);
    $(".card .js-graves-count").text(params.graves_count);
    $(".card .js-deads-count").text(params.deads_count);
    $(".js-btn-heatmap").off("click").click(() => {
        app.clickHeatMapButton(params.id)
    });
    $(".js-btn-chart").off("click").click(() => {
        app.clickChartButton(params.id)
    });
    this.clickChartButton(params.id);
    this.chart.changeChart(JSON.parse(params.graves_dynamic));
}


this.init = function() {
    riot.mount("riot-leaflet", {
        zoom: defaultMapConfig.zoom,
        centerPos: defaultMapConfig.centerPos,
        onMountMap: function() {
            app.map = this;
            app.map.map.zoomControl.setPosition('topright');
            aja()
                .url(baseUrl + "/cemeteries/info")
                .on('success', (data) => {
                    app.pieCharts = app.map.addChartLayer("pie-charts");
                    data.forEach((elem) => {
                        app.modes[elem.id] = app.MODE_CHART;
                        app.addCemeteryPolygon(elem.geo, elem.id);
                        app.addChart(elem.geo);
                        app.addHeatmap(elem.heatmap, elem.id);
                    });
                app.map.map.on("zoomend", onZoom);
                })
            .go();
        }
    })

    riot.mount("search-results", {
        app: app,
        onLoad: function() {
            app.searchResults = this
        }
    });

    riot.mount("rg-highcharts", {
        onLoad: function() {
            app.chart = this;
        },
        chartOptions: {}
    });

}


var onZoom = (e) => {
    let zoomValue = app.map.map.getZoom();
    let newRadius = zoomValue < 12 ? Math.max(40 / Math.pow(2, 12 - zoomValue), 4) : 40;
    app.pieCharts.eachLayer(function(figure) {
        figure.options.radiusX = figure.options.radiusY = figure.options.radius = newRadius;
        figure.redraw();
    });
}



}