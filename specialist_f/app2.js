console.log('in app2.js');

// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

var settings = {
  url: 'http://hh.allinson.id.au/aj_spec_ll.php',
}

$.ajax(settings).done(function(mapStr) {

  console.log('in the ajax call');

  var mapJson = JSON.parse(mapStr);

  var lat = Number(mapJson.data[0].lat);
  var lng = Number(mapJson.data[0].lng);

  initMap(mapJson);

}).fail(function() {

  console.log('fail!!');

});

var initMap = function(mapJson) {

  console.log('map init function');
  console.log(mapJson);

  var lat = Number(mapJson.data[0].lat);
  var lng = Number(mapJson.data[0].lng);

  console.log(lat);
  console.log(lng);

  var centre = {lat: lat, lng: lng};
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 11,
    center: centre
  });

    _.each(mapJson.data, function(loc) {
      console.log('in the .each function');
      var lat = Number(loc.lat)
      var lng = Number(loc.lng)
      var marker = new google.maps.Marker({
            position: { lat: lat, lng: lng },
            map: map,
            title: 'test'
          });
    });
};
