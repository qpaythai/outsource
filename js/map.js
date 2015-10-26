// JavaScript Document
var map;
var mapData=new Array();
var mapIsBeingLoaded=null;
var dataIsReady=null;
var markers=[];
var isLoaded=false;
var markerClusterer = null;
	  
var styles = [[{
        url: '../images/people35.png',
        height: 35,
        width: 35,
        anchor: [16, 0],
        textColor: '#ff00ff',
        textSize: 10
      }, {
        url: 'images/people45.png',
        height: 45,
        width: 45,
        anchor: [24, 0],
        textColor: '#ff0000',
        textSize: 11
      }, {
        url: 'images/people55.png',
        height: 55,
        width: 55,
        anchor: [32, 0],
        textColor: '#ffffff',
        textSize: 12
      }]];
 var imageUrl = 'https://storage.googleapis.com/support-kms-prod/SNP_2752125_en_v0';
console.log(imageUrl);
var markerImage;
      
initMap = function(){
  map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 13.79479694366455, lng: 100.71025085449219},
    zoom: 14
  });
   markerImage = new google.maps.MarkerImage(imageUrl,
          new google.maps.Size(24, 32));
 map.addListener('bounds_changed', function() {
											if(mapIsBeingLoaded)
												clearTimeout(mapIsBeingLoaded);
														   
											mapIsBeingLoaded =setTimeout(getData,300);
											 });
 
};

getData = function(){
	if(isLoaded){
		setMarker();
		return;
	}
	isLoaded=true;
	var geoParam;
	geoParam = 'n=' + map.getBounds().getNorthEast().lat();
        geoParam += '&e=' + map.getBounds().getNorthEast().lng();
        geoParam += '&s=' + map.getBounds().getSouthWest().lat();
        geoParam += '&w=' + map.getBounds().getSouthWest().lng();
		$.ajax({
			  dataType: "json",
			  url: "ajax-request.php?action=getcount",
			  method:'POST',
			  data:'',//geoParam,
			  success: function(d){
				  console.log('cc',d);
				 //  showOnMap(data);
			  }
			});
		
		return false;
		for(var i=0;i<9;i++){
			$.ajax({
			  dataType: "json",
			  url: "data/data"+i+".json",
			  success: function(data){
				   showOnMap(data);
			  }
			});
		}
	}
	showOnMap=  function(data){
		for(var i in data){
			
			//console.log(p);
			var pos = {lat:parseFloat(data[i].gpslat),lng:parseFloat(data[i].gpslong)}
			//console.log('pos',pos);
				var marker = new google.maps.Marker({
				position: pos,			
				map: map,
				visible:false,
				icon:markerImage
				
			  });
				markers.push(marker);


		}
		if(dataIsReady)
			clearTimeout(dataIsReady);
		dataIsReady = setTimeout(setMarker,600);
	}
	function setMarker(){
		console.log(map.getBounds(),'setM');
		var c=0;
		var mrk =[];
		for(var i in markers){
			if(map.getBounds().contains(markers[i].getPosition())){
				c++;
				markers[i].setVisible(true);
				mrk.push(markers[i]);
			}else{
				markers[i].setVisible(false);
			}
		}
		if(markerClusterer)
			markerClusterer.clearMarkes();
        markerClusterer = new MarkerClusterer(map, mrk, {
          maxZoom: 16,
          gridSize: 50,
          styles: styles[-1]
        });
		mrk=[];
		console.log('total visible marker',markerClusterer,c);
	}