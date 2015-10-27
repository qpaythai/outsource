var map;
var mapData=new Array();
var mapIsBeingLoaded=null;
var dataIsReady=null;
var markers=[];
var isLoaded=false;
var markerClusterer = null;
var count =0;
var perPage=1000;
var ids = new Array();	  
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
	
		console.log('calling ajax');
var geoParam;
		geoParam = 'n=' + map.getBounds().getNorthEast().lat();
        geoParam += '&e=' + map.getBounds().getNorthEast().lng();
        geoParam += '&s=' + map.getBounds().getSouthWest().lat();
        geoParam += '&w=' + map.getBounds().getSouthWest().lng();
		$.ajax({
			  url: "ajax-request.php?action=getcount",
			  method:'POST',
			  data:geoParam,
			  timeout:2000,
			  success: function(d){
				
				count = jQuery.parseJSON($.trim(d));
				  getMarker();
			  },
			  error:function(xhr, textStatus, errorThrown){
				  console.log('failed',xhr, textStatus, errorThrown);
			  }
			});
		
		return false;
		
	}
	var getMarker = function(){

		
	var maxP = Math.ceil(count.totlaRecords/perPage);
		for(var i=1;i<=maxP;i++){
			setTimeout(getMrk(i,perPage),200);
		
		} 
		
	}
function getMrk(page,pp){
		var geoParam;
		geoParam = 'n=' + map.getBounds().getNorthEast().lat();
        geoParam += '&e=' + map.getBounds().getNorthEast().lng();
        geoParam += '&s=' + map.getBounds().getSouthWest().lat();
        geoParam += '&w=' + map.getBounds().getSouthWest().lng();

			var postData = geoParam+'&page='+page;
			$.ajax({
			  url: "ajax-request.php?action=mapviewcount",
			  method:'POST',
			  data:postData,
			  timeout:2000,
			  success: function(data){
				   showOnMap(data);
			  }
			});
		
}
	showOnMap=  function(data){
			var data1 = jQuery.parseJSON($.trim(data));
			//var loopcount = Math.ceil(count/perPage);
            // console.log(data1);
            if(data1.id == null){
				return false;
			}

			for(var i=0; i < data1.id.length; i++){ 
			//console.log('length is',data1.id.length);
			//loopcount++;
			var pos = {lat:parseFloat(data1.lat[i]),lng:parseFloat(data1.long[i])}
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
			markerClusterer.clearMarkers();
        markerClusterer = new MarkerClusterer(map, mrk, {
          maxZoom: 16,
          gridSize: 50,
          styles: styles[-1]
        });
		mrk=[];
	console.log('total visible marker',markerClusterer,c);
	}