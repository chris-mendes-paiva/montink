let _markers = {};
let _infowindows = {};
let _polygons = {};
let _polylines = {};
let _circles = {};
let _rectangles = {};
let _poly;
let _latLongMarkers = [];
let _addLatLngListener = undefined;
let _rectangles_data = [];
let _variable_center = [-19.902648, -43.930593];
let selectedShape;
let drawingManager

//let map;
var _map = '';
const symbolInicio = {
    path: "M -2,0 0,-2 2,0 0,2 z",
    strokeColor: "#00F",
    fillColor: "#00F",
    fillOpacity: 1,
};

const symbolTwo = {
    path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
};

const symbolFim = {
    path: "M -2,-2 2,2 M 2,-2 -2,2",
    strokeColor: "#292",
    strokeWeight: 4,
};

function _ZoomControl(controlDiv, _map) { // Cria os botões dentro do mapa para dar zoom de 5x
  
    // Creating divs & styles for custom zoom control
    controlDiv.style.padding = '12px';

    // Set CSS for the control wrapper
    var controlWrapper = document.createElement('div');
    controlWrapper.style.backgroundColor = 'white';
    controlWrapper.style.borderStyle = 'solid';
    controlWrapper.style.borderColor = 'gray';
    controlWrapper.style.borderWidth = '0px';
    controlWrapper.style.cursor = 'pointer';
    controlWrapper.style.textAlign = 'center';
    controlWrapper.style.width = '40px'; 
    controlWrapper.style.height = '80px';
    controlDiv.appendChild(controlWrapper);

    // Set CSS for the zoomIn
    var zoomInButton = document.createElement('div');
    zoomInButton.style.width = '40px'; 
    zoomInButton.style.height = '40px';
    /* Change this to be the .png image you want to use */
    zoomInButton.style.backgroundImage = 'url("http://placehold.it/32/00ff00")';
    controlWrapper.appendChild(zoomInButton);

    // Set CSS for the zoomOut
    var zoomOutButton = document.createElement('div');
    zoomOutButton.style.width = '40px'; 
    zoomOutButton.style.height = '40px';
    /* Change this to be the .png image you want to use */
    zoomOutButton.style.backgroundImage = 'url("http://placehold.it/32/0000ff")';
    controlWrapper.appendChild(zoomOutButton);

    // Setup the click event listener - zoomIn
    google.maps.event.addDomListener(zoomInButton, 'click', function() {
      //_map.setZoom(_map.setZoom(13));
      _map.setZoom(_map.getZoom() + 5);
    });

    // Setup the click event listener - zoomOut
    google.maps.event.addDomListener(zoomOutButton, 'click', function() {
      //_map.setZoom(_map.setZoom(10));
      _map.setZoom(_map.getZoom() - 5);
    });  
}

function _createZoomControl(){
    var zoomControlDiv = document.createElement('div');
    var zoomControl = new _ZoomControl(zoomControlDiv, _map);

    zoomControlDiv.index = 1;
    _map.controls[google.maps.ControlPosition.RIGHT_CENTER].push(zoomControlDiv);
}

function _initMapGerenciamentoArea (id, options) {
    if(options === undefined){
        var options = {
            zoom: 8,
            center: {lat: -19.902648, lng:-43.930593},
            streetViewControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            gestureHandling: 'greedy',
            mapTypeControl: true,
            mapTypeControlOptions: {
              style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
              position: google.maps.ControlPosition.TOP_LEFT,
            },
            zoomControl: true,
            zoomControlOptions: {
              position: google.maps.ControlPosition.LEFT_CENTER,
            },
            fullscreenControl: true,
            fullscreenControlOptions: {
              position: google.maps.ControlPosition.LEFT_BOTTOM,
            }
        };
    }
    _map = new google.maps.Map(document.getElementById(id), options);

}

function _initMap(id, options) {
    if(options === undefined){
        var options = {
            zoom: 8,
            center: {lat: -19.902648, lng:-43.930593},
            streetViewControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            gestureHandling: 'greedy',
            
        };
    }
    _map = new google.maps.Map(document.getElementById(id), options);
    // This example creates an interactive map which constructs a polyline based on
    // user clicks. Note that the polyline only appears once its path property
    // contains two LatLng coordinates.
}
//Inicializa a função para traçar a linha entr dois pontos
function _traceRuler() {
    _poly = new google.maps.Polyline({
        strokeColor: "#000000",
        strokeOpacity: 1.0,
        strokeWeight: 3,
    });
    _poly.setMap(_map);
      // Add a listener for the click event
    _addLatLngListener = _map.addListener("click", _addLatLng);
}
//Add o marker dos pontos clicados no mapa e preenche as cordenadas no painel para o cálclulo da distancia entre esses pontos.
function _addLatLng(event) {
    const path = _poly.getPath();
    // Because path is an MVCArray, we can simply append a new coordinate
    // and it will automatically appear.
    path.push(event.latLng);
    //$("#lat-long-inicial").val(event.latLng.lat()+','+event.latLng.lng());
    var p1 = '';
    var p2 = '';
    var distancia = 0;
    var distanciaKm = 0;
    
    console.log(($("#lat-long-inicial").val()));
    if($("#lat-long-inicial").val() == ''){
        $("#lat-long-inicial").val(event.latLng.lat()+','+event.latLng.lng());
        p1 = ($("#lat-long-inicial").val());
    }
    else if($("#lat-long-final").val() == ''){
        $("#lat-long-final").val(event.latLng.lat()+','+event.latLng.lng());
        p1 = ($("#lat-long-inicial").val());
        p2 = ($("#lat-long-final").val());
    }
    else{
        $("#lat-long-inicial").val($("#lat-long-final").val());
        $("#lat-long-final").val(event.latLng.lat()+','+event.latLng.lng());
        p1 = ($("#lat-long-inicial").val());
        p2 = ($("#lat-long-final").val());
    }
    
    if($("#lat-long-inicial").val() != ''){
        
    
        //alert("Latitude: " + event.latLng.lat() + " " + ", longitude: " + event.latLng.lng());
        // Add a new marker at the new plotted point on the polyline.
        var latLongMarker = new google.maps.Marker({
            position: event.latLng,
            title: "#" + path.getLength(),
            map: _map,
        });
        _latLongMarkers.push(latLongMarker);
        if(p2 != ''){
            if($("#distancia-total").val() > 0){
                distancia = parseInt($("#distancia-total").val());
                distanciaKm = distancia%100;
            }
            distancia+=parseInt(_getDistance(p1, p2));
            distanciaKm = distancia/1000;
            $("#distancia-total").val(parseInt(distancia));
            $("#distancia-total-km").val(parseInt(distanciaKm));
        }
    }
}
//Função para o cálculo da distancia entre dois pontos. Fórmula de Haversine.
var rad = function(x) {
    return x * Math.PI / 180;
}

var _getDistance = function(p1, p2) {
    var c1 = (p1.split(","));
    var c2 = (p2.split(","));
    var R = 6378137; // Earth’s mean radius in meter
    var dLat = rad(c2[0] - c1[0]);
    var dLong = rad(c2[1] - c1[1]);
    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(rad(c1[0])) * Math.cos(rad(c2[0])) *
        Math.sin(dLong / 2) * Math.sin(dLong / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    var d = R * c;
    return d; // returns the distance in meter
}
//Fim cálculo de distância.
function _createMarker(latitude, longitude, id, icon, contentString, show, text_info){
    if(_markers[id] === undefined){
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(latitude, longitude),
            icon: icon,
             title: text_info,
        });
        _markers[id] = marker;
        if(contentString !== undefined){
            _createInfowindow(contentString, id);
        }
        if(show === true){
            _markers[id].setMap(_map);
            _map.setCenter(marker.getPosition());//Centraliza no Marker
        }
    }
}

function _moveToLocation(latitude, longitude, zoom = true){
    _map.setCenter(new google.maps.LatLng(latitude, longitude));
    if(zoom === true){
        _map.setZoom(15);
    }
}

function _toogleMarker(id, show){
    if(show === true){
        _markers[id].setMap(_map);
    }
    else{
        _markers[id].setMap(null);
    }
}

function _tooglePoligon(id, show){
    if(show === true){
        _polygons[id].setMap(_map);
    }
    else{
        _polygons[id].setMap(null);
    }
}

function _tooglePolyline(id, show){
    if(show === true){
        _polylines[id].setMap(_map);
    }
    else{
        _polylines[id].setMap(null);
    }
}

function _toogleCircle(id, show, center){
    if(show === true){
        if(center === true){
            _moveToLocation(_circles[id].center.lat(),_circles[id].center.lng());
        }
        _circles[id].setMap(_map);
    }
    else{
        _circles[id].setMap(null);
    }
}

function _toggleStreetView(latlng) {
    panorama = _map.getStreetView();
    panorama.setPosition(latlng);
    panorama.setPov(/** @type {google.maps.StreetViewPov} */({
        heading: 265,
        pitch: 0
    }));
    var toggle = panorama.getVisible();
    if (toggle == false) {
        panorama.setVisible(true);
    } else {
        panorama.setVisible(false);
    }
}

function _createInfowindow(contentString, id){
    if(_infowindows[id] === undefined){
        _infowindows[id] = new google.maps.InfoWindow({
            content: contentString
        });

        var marker = _markers[id];
        google.maps.event.addListener(marker, 'click', (function(marker, id) {
            return function() {
                _infowindows[id].open(_map, marker);
            }
        })(marker, id));
    }
}

function _createPolygon(id, polygonCoords, color, fillcolor, contentPolygon, show){
    if(_polygons[id] === undefined){
        if(polygonCoords === undefined){
            var polygonCoords = [
                { lat: 25.774, lng: -80.19 },
                { lat: 18.466, lng: -66.118 },
                { lat: 32.321, lng: -64.757 },
            ];
        }
        _polygons[id] = new google.maps.Polygon({
            paths: polygonCoords,
            strokeColor: color,
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: fillcolor,
            fillOpacity: 0.35
        });

        var polygon = _polygons[id];
        if(contentPolygon !== undefined){
            var infowindow = new google.maps.InfoWindow({
                content: contentPolygon,
                position: polygonCoords[0]
            });
            google.maps.event.addListener(polygon, 'click', (function(polygon, id) {
                return function() {
                    infowindow.open(_map, polygon);
                }
            })(polygon, id));
        }

        if(show === true){
            _polygons[id].setMap(_map);
        }
    }
}
function _infoCallback(infowindow) {
    var contentPolygon = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<strong>Local: TRIANGULO DAS BERMUDAS</strong>'+
            '<div id="bodyContent">'+
            '<hr>'+
            '<p>'+
            '</div>'+
            '</div>';  
    return function() {
        infowindow.setContent( contentPolygon );
        infowindow.open(_map);
    };
}

function _createPolyline(id, polylineCoords, color, tracePath, show){
    if(_polylines[id] === undefined){
        if(color === undefined){
            color = '#FF0000';
        }
        var icons = [];
        if(tracePath === true){
            var icons = [
                {
                    icon: symbolInicio,
                    offset: "0%",
                },
                {
                    icon: symbolTwo,
                    repeat: "30%",
                },
                {
                    icon: symbolFim,
                    offset: "100%",
                },
            ];
        }
        _polylines[id] = new google.maps.Polyline({
            path: polylineCoords,
            icons: icons,
            geodesic: true,
            strokeColor: color,
            strokeOpacity: 1.0,
            strokeWeight: 2,
        });

        if(show === true){
            _polylines[id].setMap(_map);
        }
    }
}

//function _moveToCircle(latitude, longitude){
//    _circle[id].setCenter(new google.maps.Circle());
//    _map.setZoom(15);
//}

function _createCircle(id, point, raio, color, fillcolor, contentCircle, show){
    
    if(_circles[id] === undefined){
        _circles[id] = new google.maps.Circle({
            strokeColor: color,
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: fillcolor,
            fillOpacity: 0.35,
            center: point,
            radius: Math.sqrt(raio) * 100,
        }); 
        
        var circle = _circles[id];
        if(contentCircle !== undefined){
            var infowindow = new google.maps.InfoWindow({
                content: contentCircle,
                position: point
            });
            google.maps.event.addListener(circle, 'click', (function(circle, id) {
                return function() {
                    infowindow.open(_map, circle);
                }
            })(circle, id));
        }

        if(show === true){
            console.log(_map);
            _circles[id].setMap(_map);
            //_circles[id].setZoom(15);
        }
    }
}

function _toogleAllPoligon(){
    $.map( _polygons, function( val, i ) {
        _polygons[i].setMap(null);
    });
}

function _toogleAllCircle(){
    $.map( _circles, function( val, i ) {
        _circles[i].setMap(null);
    });
}

function _clearMap(tipo){
    switch(tipo){
        case 'marker':
            $.map( _markers, function( val, i ) {
                _markers[i].setMap(null);
            });
            _markers = {};
        break;
        case 'infowindows':
            $.map( _infowindows, function( val, i ) {
                _infowindows[i].setMap(null);
            });
            _infowindows = {};
        break;
        case 'polygons':
            $.map( _polygons, function( val, i ) {
                _polygons[i].setMap(null);
            });
            _polygons = {};
        break;
        case 'polylines':
            $.map( _polylines, function( val, i ) {
                _polylines[i].setMap(null);
            });
            _polylines = {};
        break;
        case 'circles':
            $.map( _circles, function( val, i ) {
                _circles[i].setMap(null);
            });
            _circles = {};
        break;
        case 'lines':
            $.map( _latLongMarkers, function( val, i ) {
                _latLongMarkers[i].setMap(null);
            });
            _latLongMarkers = [];
            if(_poly !== undefined){
                _poly.setMap(null);
            //_poly = {};
            _addLatLngListener.remove();
            }
            ($("#lat-long-inicial").val(""));
            ($("#lat-long-final").val(""));
            ($("#distancia-total").val(""));
            ($("#distancia-total-km").val(""));
        break;
        case 'clearForms':
            ($("#lat-long-inicial").val(""));
            ($("#lat-long-final").val(""));
            ($("#distancia-total").val(""));
            ($("#distancia-total-km").val(""));
        break;
        case 'rectangles':
            $.map( _rectangles, function( val, i ) {
                _rectangles[i].setMap(null);
            });
            _rectangles = {};
        break;
    }
}

function _clearMapAll(){
    
    _clearMap('marker');
    _clearMap('infowindows');
    _clearMap('polygons');
    _clearMap('polylines');
    _clearMap('circles');
    _clearMap('lines');
}

function _createRectangle(id, point, height, width, color, fillColor, editable, draggable, showContent, contentRectangle, show){
    if(_rectangles[id] === undefined){
        if(height === undefined){
            height = 50;
        }
        if(width === undefined){
            width = 50;
        }
        _rectangles_data[id] = {
            center: {
                latitude: point.lat,
                longitude: point.lng
            },
            height: height,
            width: width
        };

        _rectangles[id] = new google.maps.Rectangle({
            strokeColor: color,
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: fillColor,
            fillOpacity: 0.35,
            center: point,
            bounds: {
                north: (point.lat + height / 200000),
                south: (point.lat - height / 200000),
                east: (point.lng + width / 200000),
                west: (point.lng - width / 200000),
            },
            editable: editable,
            draggable: draggable
        });

        var rectangle = _rectangles[id];
        if(showContent === true){
            if(contentRectangle !== undefined){
                var infowindow = new google.maps.InfoWindow({
                    content: contentRectangle,
                    position: point
                });

                google.maps.event.addListener(rectangle, 'click', (function(rectangle, id) {
                    return function() {
                        infowindow.open(_map, rectangle);
                    }
                })(rectangle, id));
            }
        }

        if(show === true){
            _rectangles[id].setMap(_map);
        }
        if(editable === true){
            _rectangles[id].addListener('bounds_changed', function(){
                var ne = this.getBounds().getNorthEast().lat()+','+this.getBounds().getNorthEast().lng(); // Nordeste
                var sw = this.getBounds().getSouthWest().lat()+','+this.getBounds().getSouthWest().lng(); // Sudoeste
                var nw = this.getBounds().getNorthEast().lat()+','+this.getBounds().getSouthWest().lng(); // Noroeste
                var se = this.getBounds().getSouthWest().lat()+','+this.getBounds().getNorthEast().lng(); // Sudeste
                
                _rectangles_data[id].center.latitude = this.getBounds().getCenter().lat();
                _rectangles_data[id].center.longitude = this.getBounds().getCenter().lng();
                _rectangles_data[id].height = _getDistance(ne, se);
                _rectangles_data[id].width = _getDistance(sw, se);
            });
        }
    }
}

function _editRectangle(id, point, height, width){
    if(_rectangles[id] !== undefined){
        if(height === undefined){
            height = 50;
        }
        if(width === undefined){
            width = 50;
        }

        var bounds = {
            north: (point.lat + height / 200000),
            south: (point.lat - height / 200000),
            east: (point.lng + width / 200000),
            west: (point.lng - width / 200000),
        };

        _rectangles[id].setBounds(bounds);

        _rectangles_data[id].height = height;
        _rectangles_data[id].width = width;
    }
}

function _getLatLong(id){
    _map.setOptions({'disableDoubleClickZoom': true});
    google.maps.event.addListener(_map, 'dblclick', function(point) {
        _rectangles_data[id] = {
            center: {
                latitude: point.latLng.lat(),
                longitude: point.latLng.lng()
            }
        };
    });
}

function _drawingManager(id, radius, type, message, bounds){
    // Variavel type esta recebendo um vetor para os tipo de desenhos permitidos para determinada situação sejam eles (MARKER,CIRCLE,POLYGON,POLYLINE,RECTANGLE)
    // ex: type = [ google.maps.drawing.OverlayType.CIRCLE ];
    var span = document.getElementById("raio-tex");

    if(options === undefined){
        var options = {
            zoom: 8,
            center: {lat: -19.902648, lng:-43.930593},
            streetViewControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            gestureHandling: 'greedy',
        };
    }
    _map = new google.maps.Map(document.getElementById(id), options);

    // No momento desenhos como POLYGON, POLYLINE e RECTANGLE estão inativado conforme solicitação
    drawingManager = new google.maps.drawing.DrawingManager({
        drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: type
        },
        markerOptions: {
            icon: "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png",
        },
        circleOptions: {
            fillColor: "#d3d3e6",
            fillOpacity: 0.8,
            strokeWeight: 3,
            clickable: true,
            editable: true,
            draggable: true,
            Maxradius: 100,
        },
        rectangleOptions: {
            editable: true,
            clickable: true,
            draggable: true
        },
        polygonOptions: {
            editable: true,
            clickable: true,
            draggable: true,
        },
    });

    //Evento de complete Polygon
    google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon){
        var coordinates = polygon.getPath().getArray();
        console.log(coordinates);
    });

    //Evento de complete Cicle
    google.maps.event.addListener(drawingManager, 'circlecomplete', function (circle) {
        var valor_lat = circle.getCenter().lat();
        var valor_long = circle.getCenter().lng();
        var raio = parseInt(circle.getRadius());
        //Setando o raio de ciculos
        span.textContent = raio;
        if(raio > radius){
            alert(message);
            circle.setRadius(radius)
            span.textContent = radius;
        }
        _variable_center = [valor_lat, valor_long];
        console.log(valor_lat + ' - ' + valor_long + ' - ' + raio);
        document.getElementById('lat').value = valor_lat;
        document.getElementById('long').value = valor_long;
        document.getElementById('raio').value = raio;        
    });

    //Evento de edição Circle
    google.maps.event.addListener(drawingManager, 'circlecomplete', function (circle){
        google.maps.event.addListener(circle, 'radius_changed', function () {
            var raio = parseInt(circle.getRadius());
            document.getElementById('raio').value = raio;
            //Setando o raio de ciculos
            span.textContent = raio;
            if(raio > radius){
                alert(message);
                circle.setRadius(radius)
                span.textContent = radius;
            }           
        });
        google.maps.event.addListener(circle, 'dragend', function () {                
            var valor_lat = circle.getCenter().lat();
            var valor_long = circle.getCenter().lng();
            var raio = parseInt(circle.getRadius());

            _variable_center = [valor_lat, valor_long];
            document.getElementById('lat').value = valor_lat;
            document.getElementById('long').value = valor_long;
            document.getElementById('raio').value = raio;
            span.textContent = raio;
        });
        google.maps.event.addListener(circle, 'drag', function () {
            var valor_lat = circle.getCenter().lat();
            var valor_long = circle.getCenter().lng();
            var raio = parseInt(circle.getRadius());
            _variable_center = [valor_lat, valor_long];
            document.getElementById('lat').value = valor_lat;
            document.getElementById('long').value = valor_long;
            document.getElementById('raio').value = raio;
            span.textContent = raio;
        });
    });

    //Evento complete Rectangle
    google.maps.event.addListener(drawingManager, 'rectanglecomplete', function (rectangle) {
        var ne = rectangle.getBounds().getNorthEast().lat()+','+rectangle.getBounds().getNorthEast().lng(); // Nordeste
        var sw = rectangle.getBounds().getSouthWest().lat()+','+rectangle.getBounds().getSouthWest().lng(); // Sudoeste
        var nw = rectangle.getBounds().getNorthEast().lat()+','+rectangle.getBounds().getSouthWest().lng(); // Noroeste
        var se = rectangle.getBounds().getSouthWest().lat()+','+rectangle.getBounds().getNorthEast().lng(); // Sudeste
        
        _rectangles_data['new'] = {
            center: {
                latitude: rectangle.getBounds().getCenter().lat(),
                longitude: rectangle.getBounds().getCenter().lng()
            },
            height: _getDistance(ne, se),
            width: _getDistance(sw, se)
        };
    });

    //Evento de edição Rectangle
    google.maps.event.addListener(drawingManager, 'rectanglecomplete', function (rectangle){
        google.maps.event.addListener(rectangle, 'bounds_changed', function () {
            var ne = rectangle.getBounds().getNorthEast().lat()+','+rectangle.getBounds().getNorthEast().lng(); // Nordeste
            var sw = rectangle.getBounds().getSouthWest().lat()+','+rectangle.getBounds().getSouthWest().lng(); // Sudoeste
            var nw = rectangle.getBounds().getNorthEast().lat()+','+rectangle.getBounds().getSouthWest().lng(); // Noroeste
            var se = rectangle.getBounds().getSouthWest().lat()+','+rectangle.getBounds().getNorthEast().lng(); // Sudeste

            _rectangles_data['new'].center.latitude = rectangle.getBounds().getCenter().lat();
            _rectangles_data['new'].center.longitude = rectangle.getBounds().getCenter().lng();
            _rectangles_data['new'].height = _getDistance(ne, se);
            _rectangles_data['new'].width = _getDistance(sw, se);
        });
    });

    // Evento do Termino do desenho
    google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {
        if(e.type != google.maps.drawing.OverlayType.MARKER){
            drawingManager.setDrawingMode(null);
            drawingManager.setOptions({
                drawingControl: false
            });
            var newShape = e.overlay;
            newShape.type = e.type;
                google.maps.event.addListener(newShape, 'click', function() {
                setSelection(newShape);
            });
            setSelection(newShape);
        }
    });

    //Ideal sempre ter um botao para remoção dos desenhos criados
    google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', deleteSelectedShape);
    
    drawingManager.setMap(_map);
}

function clearSelection() {
    if (selectedShape) {
        selectedShape.setEditable(false);
        selectedShape = null;
    }
}

function setSelection(shape) {
    clearSelection();
    selectedShape = shape;
    shape.setEditable(true);
}

function deleteSelectedShape(){
    if(selectedShape){
        selectedShape.setMap(null);
        drawingManager.setOptions({
            drawingControl: true
        });
    }
}

