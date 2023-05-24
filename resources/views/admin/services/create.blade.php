@extends('layouts.master')

@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection
@section('title')
    {{ __('admin.add-place') }}
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.services') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    {{ __('admin.add-place') }}
                </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
@if (session()->has('Add'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('Add') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<div class="row">

    <div class="col-lg-12 col-md-12">

    <div class="card">
   
      <div class="card-body">
        <form action="{{ route('services.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <div class="row">

                @foreach (languages() as $lang)
                    <div class="col-6">
                        <div class="form-group">
                            <div class="controls">
                                <label class="form-label" for="account-name">{{ __('site.title_' . $lang) }} </label>
                                <input class="form-control" name="name[{{ $lang }}]" id=""
                                    placeholder="{{ __('site.write') . __('site.title_' . $lang) }}"  required data-validation-required-message="{{__('admin.this_field_is_required')}}">

                            </div>
                        </div>
                    </div>
                @endforeach

                </div>
            </div>

            <div class="mb-3">
                <div class="row">
                @foreach (languages() as $lang)
                    <div class="col-6">
                        <div class="form-group">
                            <div class="controls">
                                <label for="account-name" class="form-label">{{ __('site.description_' . $lang) }} </label>
                                <input class="form-control" name="description[{{ $lang }}]" id=""
                                    cols="30" rows="10"
                                    placeholder="{{ __('site.write') . __('site.description_' . $lang) }}"  required data-validation-required-message="{{__('admin.this_field_is_required')}}">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            </div>
         
        
       <div class="mb-3">
            <input id="input-b2" name="attachment" type="file">
       </div>
       

            <button type="submit" class="btn btn-primary">Submit</button>

             
        </div>

           
        

      
         
        </form>
        
      </div>
    </div>
</div>
  
@endsection
@section('js')

<script>
    $(document).ready(function() {
        $("#input-b2").fileinput({
            rtl: true,
            dropZoneEnabled: false,
            allowedFileExtensions: ["jpg", "png", "gif"]
        });
    });
    </script>

<script>
    
    $(function () {
        $(document).ready(function () {
            $('#fileUploadForm').ajaxForm({
                beforeSend: function () {
                    var percentage = '0';
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    var percentage = percentComplete;
                    $('.progress .progress-bar').css("width", percentage+'%', function() {
                      return $(this).attr("aria-valuenow", percentage) + "%";
                    })
                },
                complete: function (xhr) {
                    console.log('File has uploaded');
                }
            });
        });
    });
</script>


<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

<script>
       $("#pac-input").focusin(function() {
           $(this).val('');
       });
       $('#latitude').val('');
       $('#longitude').val('');

       // This example adds a search box to a map, using the Google Place Autocomplete
       // feature. People can enter geographical searches. The search box will return a
       // pick list containing a mix of places and predicted search terms.
       // This example requires the Places library. Include the libraries=places
       // parameter when you first load the API. For example:
       // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
       function initAutocomplete() {
           var map = new google.maps.Map(document.getElementById('map'), {
               center: {lat: 24.694969, lng: 46.724129  },
               zoom: 13,
               mapTypeId: 'roadmap'
           });
           // move pin and current location
           infoWindow = new google.maps.InfoWindow;
           geocoder = new google.maps.Geocoder();
           if (navigator.geolocation) {
               navigator.geolocation.getCurrentPosition(function(position) {
                   var pos = {
                       lat: position.coords.latitude,
                       lng: position.coords.longitude
                   };
                   map.setCenter(pos);
                   var marker = new google.maps.Marker({
                       position: new google.maps.LatLng(pos),
                       map: map,
                       title: 'موقعك الحالي'
                   });
                   markers.push(marker);
                   marker.addListener('click', function() {
                       geocodeLatLng(geocoder, map, infoWindow,marker);
                   });
                   // to get current position address on load
                   google.maps.event.trigger(marker, 'click');
               }, function() {
                   handleLocationError(true, infoWindow, map.getCenter());
               });
           } else {
               // Browser doesn't support Geolocation
               console.log('dsdsdsdsddsd');
               handleLocationError(false, infoWindow, map.getCenter());
           }
           var geocoder = new google.maps.Geocoder();
           google.maps.event.addListener(map, 'click', function(event) {
               SelectedLatLng = event.latLng;
               geocoder.geocode({
                   'latLng': event.latLng
               }, function(results, status) {
                   if (status == google.maps.GeocoderStatus.OK) {
                       if (results[0]) {
                           deleteMarkers();
                           addMarkerRunTime(event.latLng);
                           SelectedLocation = results[0].formatted_address;
                           console.log( results[0].formatted_address);
                           splitLatLng(String(event.latLng));
                           $("#pac-input").val(results[0].formatted_address);
                       }
                   }
               });
           });
           function geocodeLatLng(geocoder, map, infowindow,markerCurrent) {
               var latlng = {lat: markerCurrent.position.lat(), lng: markerCurrent.position.lng()};
               /* $('#branch-latLng').val("("+markerCurrent.position.lat() +","+markerCurrent.position.lng()+")");*/
               $('#latitude').val(markerCurrent.position.lat());
               $('#longitude').val(markerCurrent.position.lng());
               geocoder.geocode({'location': latlng}, function(results, status) {
                   if (status === 'OK') {
                       if (results[0]) {
                           map.setZoom(8);
                           var marker = new google.maps.Marker({
                               position: latlng,
                               map: map
                           });
                           markers.push(marker);
                           infowindow.setContent(results[0].formatted_address);
                           SelectedLocation = results[0].formatted_address;
                           $("#pac-input").val(results[0].formatted_address);
                           infowindow.open(map, marker);
                       } else {
                           window.alert('No results found');
                       }
                   } else {
                       window.alert('Geocoder failed due to: ' + status);
                   }
               });
               SelectedLatLng =(markerCurrent.position.lat(),markerCurrent.position.lng());
           }
           function addMarkerRunTime(location) {
               var marker = new google.maps.Marker({
                   position: location,
                   map: map
               });
               markers.push(marker);
           }
           function setMapOnAll(map) {
               for (var i = 0; i < markers.length; i++) {
                   markers[i].setMap(map);
               }
           }
           function clearMarkers() {
               setMapOnAll(null);
           }
           function deleteMarkers() {
               clearMarkers();
               markers = [];
           }
           // Create the search box and link it to the UI element.
           var input = document.getElementById('pac-input');
           $("#pac-input").val("أبحث هنا ");
           var searchBox = new google.maps.places.SearchBox(input);
           map.controls[google.maps.ControlPosition.TOP_RIGHT].push(input);
           // Bias the SearchBox results towards current map's viewport.
           map.addListener('bounds_changed', function() {
               searchBox.setBounds(map.getBounds());
           });
           var markers = [];
           // Listen for the event fired when the user selects a prediction and retrieve
           // more details for that place.
           searchBox.addListener('places_changed', function() {
               var places = searchBox.getPlaces();
               if (places.length == 0) {
                   return;
               }
               // Clear out the old markers.
               markers.forEach(function(marker) {
                   marker.setMap(null);
               });
               markers = [];
               // For each place, get the icon, name and location.
               var bounds = new google.maps.LatLngBounds();
               places.forEach(function(place) {
                   if (!place.geometry) {
                       console.log("Returned place contains no geometry");
                       return;
                   }
                   var icon = {
                       url: place.icon,
                       size: new google.maps.Size(100, 100),
                       origin: new google.maps.Point(0, 0),
                       anchor: new google.maps.Point(17, 34),
                       scaledSize: new google.maps.Size(25, 25)
                   };
                   // Create a marker for each place.
                   markers.push(new google.maps.Marker({
                       map: map,
                       icon: icon,
                       title: place.name,
                       position: place.geometry.location
                   }));
                   $('#latitude').val(place.geometry.location.lat());
                   $('#longitude').val(place.geometry.location.lng());
                   if (place.geometry.viewport) {
                       // Only geocodes have viewport.
                       bounds.union(place.geometry.viewport);
                   } else {
                       bounds.extend(place.geometry.location);
                   }
               });
               map.fitBounds(bounds);
           });
       }
       function handleLocationError(browserHasGeolocation, infoWindow, pos) {
           infoWindow.setPosition(pos);
           infoWindow.setContent(browserHasGeolocation ?
               'Error: The Geolocation service failed.' :
               'Error: Your browser doesn\'t support geolocation.');
           infoWindow.open(map);
       }
       function splitLatLng(latLng){
           var newString = latLng.substring(0, latLng.length-1);
           var newString2 = newString.substring(1);
           var trainindIdArray = newString2.split(',');
           var lat = trainindIdArray[0];
           var Lng  = trainindIdArray[1];
           $("#latitude").val(lat);
           $("#longitude").val(Lng);
       }
   </script>
   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB8LNfxjQ6S8WJDw_0_fQbhV4HfXOeulQ4&libraries=places&callback=initAutocomplete&language=ar&region=EG
        async defer"></script>
        <script>
            /**
* @license
* Copyright 2019 Google LLC. All Rights Reserved.
* SPDX-License-Identifier: Apache-2.0
*/
// In this example, we center the map, and add a marker, using a LatLng object
// literal instead of a google.maps.LatLng object. LatLng object literals are
// a convenient way to add a LatLng coordinate and, in most cases, can be used
// in place of a google.maps.LatLng object.
let map;

function initMap() {
 const mapOptions = {
   zoom: 8,
   center: { lat: -34.397, lng: 150.644 },
 };

 map = new google.maps.Map(document.getElementById("map"), mapOptions);

 const marker = new google.maps.Marker({
   // The below line is equivalent to writing:
   // position: new google.maps.LatLng(-34.397, 150.644)
   position: { lat: 31.037577, lng: 31.362163 },
   map: map,
 });
 // You can use a LatLng literal in place of a google.maps.LatLng object when
 // creating the Marker object. Once the Marker object is instantiated, its
 // position will be available as a google.maps.LatLng object. In this case,
 // we retrieve the marker's position using the
 // google.maps.LatLng.getPosition() method.
 const infowindow = new google.maps.InfoWindow({
   content: "<p>Marker Location:" + marker.getPosition() + "</p>",
 });

 google.maps.event.addListener(marker, "click", () => {
   infowindow.open(map, marker);
 });
}

window.initMap = initMap;

        </script>
@endsection