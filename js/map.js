// JavaScript Document
var map;
var mapData=new Array();
var mapIsBeingLoaded=null;
initMap = function(){
  map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 13.79479694366455, lng: 100.71025085449219},
    zoom: 8
  });
 map.addListener('bounds_changed', function() {
											if(mapIsBeingLoaded)
												clearTimeout(mapIsBeingLoaded);
														   
											mapIsBeingLoaded =setTimeout(getData,300);
											 });
 
};

getData = function(){
	var geoParam;
	geoParam = 'n=' + map.getBounds().getNorthEast().lat();
        geoParam += '&e=' + map.getBounds().getNorthEast().lng();
        geoParam += '&s=' + map.getBounds().getSouthWest().lat();
        geoParam += '&w=' + map.getBounds().getSouthWest().lng();
		console.log(geoParam);
		
		$.ajax({
		  dataType: "json",
		  url: "data.json",
		  success: function(data){
			   showOnMap(data);
		  }
		});
	}
	showOnMap=  function(data){
		for(var i in data){
			//console.log(data[i].BODY.GPS);
			var p = data[i].BODY.GPS.split(",");
			//console.log(p);
			var pos = {lat:parseFloat(p[0]),lng:parseFloat(p[1])}
			//console.log('pos',pos);
				var marker = new google.maps.Marker({
				position: pos,
			
				map: map
			  });


		}
	}