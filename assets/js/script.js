function getCurLocation()
{
    var pos = {
        lat : default_lat, 
        lng : default_lng
    };    
    if(navigator.geolocation) {        
        navigator.geolocation.getCurrentPosition(function(position) {            
            pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };                  
            
        }, function() {
            handleNoGeolocation(true);
        });
    } else {        
        handleNoGeolocation(false);
    }   
    console.log(pos); 
    return pos; 
}

function handleNoGeolocation(browserHasGeolocation) {
    alert(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');             
}   

// mengisi marker
function addMarker(pos, map, label){
    var marker = new google.maps.Marker({
        position: pos,
        map: map,
        label : label,
        animation: google.maps.Animation.DROP
    });
}