// JavaScript Document
var mapApp = {
	map:null,
	mapData:{},
	initMap: function(){
  this.map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 13.79479694366455, lng: 100.71025085449219},
    zoom: 8
  });
},showOnMap: function(){
		console.log('c',mapData);
	},
	getData : function(){
		$.ajax({
		  dataType: "json",
		  url: "data.json",
		  success: function(data){
			  mapData= data;
			  console.log(data,mapData);
			  mapApp.showOnMap();
		  }
		});
	},
	
};