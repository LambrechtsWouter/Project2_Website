/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var map;
var marker;
var total = 0;
var points = [];
var id = null;
var pos = 0;
var time = 0;
var directionsService = new google.maps.DirectionsService()
var directionsDisplay;

    
$(document).ready(function() {
	
	function initialize() {
		directionsDisplay = new google.maps.DirectionsRenderer();
		  var mapOptions = {
		    zoom: 7,
		    mapTypeId: google.maps.MapTypeId.ROADMAP,
		    center: new google.maps.LatLng(50.97382, 3.958132),
		  };
		  map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
		  directionsDisplay.setMap(map);
		 
		
		 
	}
	$('.tab4').hide();
	$('.tab1').on('click', function(e) {
		$('#tab1').show();
		$('#tab2').hide();
		$('#tab3').hide();
		$('#tab4').hide();
	});
	$('.tab2').on('click', function(e) {
		document.getElementById("btnSubmit").disabled = true; 
		$('#tab1').hide();
		$('#tab2').show();
		$('#tab3').hide();
		$('#tab4').hide();
	});
	$('.tab3').on('click', function(e) {
		$('#tab1').hide();
		$('#tab2').hide();
		$('#tab3').show();
		$('#tab4').hide();
	});
	$('.tab5').on('click', function(e) {
		$('#tab1').hide();
		$('#tab2').hide();
		$('#tab3').hide();
		$('.tab2').hide();
		$('.tab3').hide();
		$('#tab4').show();
		$('.tab4').show();	
	});
	$('.tab4').on('click', function(e) {
		$('#tab1').hide();
		$('#tab2').hide();
		$('#tab3').hide();
		$('#tab4').show();
	});

	$('#Volgende').on('click', function(e) {
		
		$.get('http://wouterlambrechts.ikdoeict.be/project2/api/Routes',function(data) {
			total = data.content.length;
			total = total +1;
			name = document.getElementById('RouteName').value;
    		locatie = document.getElementById('location').value;
			description = document.getElementById('description').value;
			provincie = document.getElementById('prov').value; 
			if(!name ||  !locatie || !description){
				
			}else{
				$.post('http://wouterlambrechts.ikdoeict.be/project2/api/Routes',{ 'gsmCode': 'phototour' + total, 'Name': name, 'city': locatie, 'provincie':provincie,'Description':description,'arrived_text': ''},function(data) {
					id = data;
				});
				$('.tab1').hide();
				$('#tab1').hide();
				$('#tab2').show();
				$('.tab2').show();
				document.getElementById("btnSubmit").disabled = true; 
			};
		}, "json");
	});
	//toon streetview
    $('#btnExercise1').on('click', function(e) {
      document.getElementById("btnSubmit").disabled = false; 
       adres = $('#adres').val();
       gemeente = $('#gemeente').val();
       var mygc = new google.maps.Geocoder();
		mygc.geocode({'address' : '' + adres + ', ' + gemeente}, function(results, status){
    		var lat = results[0].geometry.location.lat();
    		var lng = results[0].geometry.location.lng();   		
    		element = document.getElementById("streetview");
			element.parentNode.removeChild(element);
			$('#view').append('<img align="center" id="streetview" src="http://maps.googleapis.com/maps/api/streetview?size=600x450&location='+ lat +','+ lng +'&heading=151.78&pitch=-0.76&sensor=false">');
		});		
    });
    $('#Submit').on('click', function(e) {
    	arrived_text = $('textarea#name').val();
    	$.post('http://wouterlambrechts.ikdoeict.be/project2/api/Routes/info',{ 'id': id,'Duration': time,'arrived_text':arrived_text},function(data) {
			window.location.href = '../routes';
		});

    	
	});
	
     $('#btnSubmit').on('click', function(e) {
     	$('#tab2').hide();
     	$('#tab3').show();
     	console.log(pos);
     	total++;
        pos++;
        if(pos <2){
        	document.getElementById("next").disabled = true; 
        }else{
        	document.getElementById("next").disabled = false; 
        }
     	adres = $('#adres').val();
       	gemeente = $('#gemeente').val();
        description = $('textarea#arrived').val();
       	var mygc = new google.maps.Geocoder();
       	var lat;
       	var lng;
    	mygc.geocode({'address' : '' + adres + ', ' + gemeente}, function(results, status){
    		lat = results[0].geometry.location.lat();
    		lng = results[0].geometry.location.lng();   		
    		element = document.getElementById("streetview");
			element.parentNode.removeChild(element);
			$('#view').append('<img align="center" id="streetview" src="http://maps.googleapis.com/maps/api/streetview?size=600x450&location='+ lat +','+ lng +'&heading=151.78&pitch=-0.76&sensor=false">');
			var myLatlng = new google.maps.LatLng(lat,lng);
			 $.post('http://wouterlambrechts.ikdoeict.be/project2/api/Location',{ 'lat': lat, 'lng': lng, 'position': pos, 'address': adres + ', ' + gemeente,'arrived_text': description,'Routes_idRoutes': id},function(data) {
			
			});
	  		points.push({'adres' : adres + ', ' + gemeente, 'lat' : lat,'lng' : lng,'description': description});
	  		setTable(adres,gemeente,lat,lng,total,description);
	  		 calcRoute();
	  		 
		  
		});	
	});	
	
	function setTable(adres,gemeente,lat,lng, total,description){
		$('#table').append('<tr><td>' + pos + '</td><td>' + adres + ' ' + gemeente + '</td><td>' + lat + ',' + lng + '</td><td>' + description +'</td></tr>');
	};	
	
	function calcRoute() {
      var length = points.length-1;
      var waypts = [];
       for (var i = 1; i < points.length-1; i++) {
      		waypts.push({
          		location:points[i].adres
          	});
    	}	
    if(points.length == 2){
	  var request = {
	    origin: points[0].adres,
	    destination:points[length].adres,
	    travelMode: google.maps.DirectionsTravelMode.WALKING
	  };
	  directionsService.route(request, function(response, status) {
	      directionsDisplay.setDirections(response);
	      var route = response.routes[0];
	       document.getElementById('duration').innerHTML = route.legs[0].duration.text;
	       time = Math.round(route.legs[0].distance.value/60).toFixed(0);;
	      document.getElementById('total').innerHTML = route.legs[0].distance.text;
	  });
	}else if(points.length > 2){
	 console.log(waypts);
	 console.log(points[length].adres);
	 console.log(points[0].adres);
	  var request = {
		    origin: points[0].adres,
		     waypoints: waypts,
		    destination:points[length].adres,
		   
	    	travelMode: google.maps.DirectionsTravelMode.WALKING
	  };
	  directionsService.route(request, function(response, status) {
	      directionsDisplay.setDirections(response);
	      var duration,distance;
	      var route = response.routes[0];
	      for (var i = 0; i < route.legs.length; i++) {
	        distance = route.legs[i].distance.value;
	        duration = route.legs[i].duration.value;
	      }
	      document.getElementById('total').innerHTML = distance / 1000 + ' km';
	      time = Math.round(duration/60).toFixed(0);
	      document.getElementById('duration').innerHTML = Math.round(duration/60).toFixed(0)+ ' min';
	  });
	};
	  
	}
	
	function computeTotalDistance(result) {
	  var total = 0;
	  var myroute = result.routes[0];
	  for (var i = 0; i < myroute.legs.length; i++) {
	    total += myroute.legs[i].distance.value;
	  }
	  total = total / 1000.
	  document.getElementById('total').innerHTML = total + ' km';
	}	
	
	google.maps.event.addDomListener(window, 'load', initialize); 
});


