/*
 * Author: Pieter-Jan Geeroms
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
	$.get('http://wouterlambrechts.ikdoeict.be/project2/api/Routes',function(data) {
	  		for (var i in data.content) {
	  			$(".routes").append('<div class="route"><div id="' + data.content[i].gsmCode + '" class="clearfix imagesRoute"></div><div class="clearfix infoRoute"><h2>' + data.content[i].Name + '</h2><p>' + data.content[i].Description +'</p><p>GsmCode: '+ data.content[i].gsmCode + '</p><p>Duration: '+ data.content[i].Duration +' minuten</div>');
	  			jQuery('#' + data.content[i].gsmCode).qrcode({
						text	: data.content[i].gsmCode
			    });
	  		
	  		}
	},"json");
	$("select ").change(function () {
	  $(".routes").empty();
	  var str = $("select option:selected").val();
	  if(str == 0){
	  	$.get('http://wouterlambrechts.ikdoeict.be/project2/api/Routes',function(data) {
	  		for (var i in data.content) {
	  			$(".routes").append('<div class="route"><div id="' + data.content[i].gsmCode + '" class="clearfix imagesRoute"></div><div class="clearfix infoRoute"><h2>' + data.content[i].Name + '</h2><p>' + data.content[i].Description +'</p><p>GsmCode: '+ data.content[i].gsmCode + '</p><p>Duration: '+ data.content[i].Duration +' minuten</div>');
	  			jQuery('#' + data.content[i].gsmCode).qrcode({
						text	: data.content[i].gsmCode
			    });
	  		}
	  	},"json");
	  }else{
	  	$.get('http://wouterlambrechts.ikdoeict.be/project2/api/provincie/' + str,function(data) {
	  		if(data.content.length > 0){
		  		for (var i in data.content) {
		  			$(".routes").append('<div class="route"><div id="' + data.content[i].gsmCode + '" class="clearfix imagesRoute"></div><div class="clearfix infoRoute"><h2>' + data.content[i].Name + '</h2><p>' + data.content[i].Description +'</p><p>GsmCode: '+ data.content[i].gsmCode + '</p><p>Duration: '+ data.content[i].Duration +' minuten</div>');
		  			jQuery('#' + data.content[i].gsmCode).qrcode({
						text	: data.content[i].gsmCode
			    	});
		  		}
		  	}else{
		  		$(".routes").append('Geen Routes gevonden voor de provincie: ' + $("select option:selected").text());		  	}
	  	},"json");
	  }

	})
}); 

