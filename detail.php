<style>
      #right-panel {
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }

      #right-panel select, #right-panel input {
        font-size: 15px;
      }

      #right-panel select {
        width: 100%;
      }

      #right-panel i {
        font-size: 12px;
      }
      
      #map {
        height: 500px;
        float: left;
        width: 63%;
      }
      #right-panel {
        float: right;
        width: 34%;
        height: 500px;
        overflow: auto;
      }
      .panel {
        height: 500px;
        overflow: auto;
      }
</style>
    
<?php
$row = $db->get_row("SELECT * FROM tb_tempat WHERE id_tempat='$_GET[ID]'");
?>
<div class="page-header">
    <h1>Rute Detail ke <?=$row->nama_tempat?></h1>
</div>
<div class="clearfix" style="background: white;">
    <div id="map"></div>
    <div id="right-panel">
      <p>Total Jarak: <span id="total"></span><br />
      Node Terdekat: <span id="terdekat"></span></p>
    </div>
</div>
<p class="help-block">Geser marker atau garis untuk mengubah rute.</p>

<script>
$(function(){
    initMap();
})

var markerArray = [];

  function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 4,
      center: {lat: default_lat, lng: default_lng}  // Australia.
    });

    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer({
      draggable: true,
      map: map,
      panel: document.getElementById('right-panel')
    });
    
    var stepDisplay = new google.maps.InfoWindow;
    
    
    directionsDisplay.addListener('directions_changed', function() {
        //calculateAndDisplayRoute()
      computeTotalDistance(directionsDisplay.getDirections());
          for (var i = 0; i < markerArray.length; i++) {
            markerArray[i].setMap(null);
        }
        
        showSteps(directionsDisplay.getDirections(), markerArray, stepDisplay, map);
      //calculateAndDisplayRoute(pos, {lat: <?=$row->lat?>, lng: <?=$row->lng?>}, directionsService, directionsDisplay, stepDisplay, map);
    });
    
    // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            //infoWindow.setPosition(pos);
            //infoWindow.setContent('Location found.');
            //infoWindow.open(map);
            //map.setCenter(pos);
            calculateAndDisplayRoute(pos, {lat: <?=$row->lat?>, lng: <?=$row->lng?>}, directionsService, directionsDisplay, stepDisplay, map);
          }, function() {
                calculateAndDisplayRoute(getCurLocation(), {lat: <?=$row->lat?>, lng: <?=$row->lng?>}, directionsService, directionsDisplay, stepDisplay, map);
          });
        } else {
          // Browser doesn't support Geolocation
          calculateAndDisplayRoute(getCurLocation(), {lat: <?=$row->lat?>, lng: <?=$row->lng?>}, directionsService, directionsDisplay, stepDisplay, map);
        }            
  }

  function calculateAndDisplayRoute(origin, destination, directionsService, directionsDisplay, stepDisplay, map) {
    
    for (var i = 0; i < markerArray.length; i++) {
        markerArray[i].setMap(null);
    }
        
    directionsService.route({
      origin: origin,
      destination: destination,
      //waypoints: [{location: 'Adelaide, SA'}, {location: 'Broken Hill, NSW'}],
      travelMode: 'DRIVING',
      avoidTolls: true
    }, function(response, status) {
      if (status === 'OK') {
        //console.log(response);
        directionsDisplay.setDirections(response);
        showSteps(response, markerArray, stepDisplay, map);
      } else {
        alert('Could not display directions due to: ' + status);
      }
    });
  }
  
  function showSteps(directionResult, markerArray, stepDisplay, map) {
    // For each step, place a marker, and add the text to the marker's infowindow.
    // Also attach the marker to an array so we can keep track of it and remove it
    // when calculating new routes.
    var myRoute = directionResult.routes[0].legs[0];
    
    //console.log(directionResult.routes[0].legs[0]);
    
    for (var i = 0; i < myRoute.steps.length; i++) {
      var marker = markerArray[i] = markerArray[i] || new google.maps.Marker();
      //marker.setMap(map);
      //marker.setPosition(myRoute.steps[i].start_location);
      //marker.setIcon('http://maps.google.com/mapfiles/ms/icons/blue-dot.png');
      attachInstructionText(
          stepDisplay, marker, myRoute.steps[i].instructions, map);
    }
  }
  
  function attachInstructionText(stepDisplay, marker, text, map) {
        google.maps.event.addListener(marker, 'click', function() {
          // Open an info window when the marker is clicked on, containing the text
          // of the step.
          stepDisplay.setContent(text);
          stepDisplay.open(map, marker);
        });
      }

  function computeTotalDistance(result) {
    var total = 0;
    var myroute = result.routes[0];
    var terdekat = 0;
    
    terdekat = myroute.legs[0].steps[0].distance.value;
    
    //console.log(result);
    for (var i = 0; i < myroute.legs.length; i++) {
      total += myroute.legs[i].distance.value;      
    }
    total = total / 1000;
    document.getElementById('total').innerHTML = total + ' km';
    document.getElementById('terdekat').innerHTML = (terdekat / 1000) + ' km';// + terdekat + ' m';
  }
</script>