<?php 
	include 'functions.php';
	include 'db_connect.php';
?>



<?php

//If form was posted, it will populate the $_POST array
//so we will run our query.Otherwise, skip it.
if(sizeof($_POST)>0){
	$sql = "
	SELECT fullname, latitude, longitude,
		   69*haversine(latitude,longitude,latpoint, longpoint) AS distance_in_miles
	 FROM military_installations
	 JOIN (
		 SELECT  {$_POST['lat']}  AS latpoint,  {$_POST['lng']} AS longpoint
	   ) AS p
	 ORDER BY distance_in_miles
	 LIMIT 10";

	 $result = $db->query($sql);
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Simple Polygon</title>
    <style>
      html, body, #map-canvas {
        height: 600px;
		width: 800px;
        margin: 0px;
        padding: 0px
      }
    </style>
    <!-- Include Google Maps Api to generate maps -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    
    <!-- Include Jquery to help with simplifying javascript syntax  -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>

	//Runs when page is done loading
	function initialize() {
	  //Javascript object to help configure google map.
	  var mapOptions = {
		zoom: 5,
		center: new google.maps.LatLng(39.707, -101.503),
		mapTypeId: google.maps.MapTypeId.TERRAIN
	  };

	  //Create google map, place it in 'map-canvas' element, and use 'mapOptions' to 
	  //help configure it
	  var map = new google.maps.Map(document.getElementById('map-canvas'),
		  mapOptions);
		var PolygonCoords = new Array();
		var PolyGon = new Array();

		<?php
		//If we posted a lat lon, then loop through the resulting query rows and create 
		//a google marker for each location.
		if(sizeof($_POST)>0){
			$i=0; 
			$numberOfbases = 0;
			while($row = $result->fetch_assoc()){
				
				echo"var marker{$i} = new google.maps.Marker({\n";

				echo"position: new google.maps.LatLng({$row['latitude']},{$row['longitude']}),\n";

				echo"map: map,\n";
				echo"title:\"{$row['fullname']}\"\n";
				echo"});\n";
				$i++;
				if($numberOfbases<$_POST['basenumber']){
				
					$result1 = $db->query("SELECT asText(SHAPE) as border
																	  FROM `military_installations`
																	  WHERE fullname = '{$row['fullname']}'");
					
					$Result = $result1->fetch_assoc();
					$CoordsArray[$numberOfbases] = sql_to_coordinates($Result['border']);
					$numberOfbases++;
				}
				
			}
			for($i=0;$i<sizeof($CoordsArray);$i++){

                         echo"var Temp = [\n";
                         echo"// Define the LatLng coordinates for the polygon's path.\n";
                         array_shift($CoordsArray[$i]);
                         $line=0;
						 
                         foreach($CoordsArray[$i] as $c){
                                $lat = $c['lat'];
                                $lng = $c['lng'];
                                $lat = str_replace("(","",$lat);
                                $lng = str_replace("(","",$lng);
                                $lat = str_replace(")","",$lat);
                                $lng = str_replace(")","",$lng);
                                echo "new google.maps.LatLng({$lng},{$lat})";
                                if($line < sizeof($CoordsArray[$i])-1){
                                       echo ",\n";
								}else{
                                       echo "\n";
                                }
                                $line++;
                         }
                         echo"];\n";
                         echo"PolygonCoords.push(Temp);\n";

                         echo"// Construct the polygon.\n";
                         echo"PolyGon[{$i}] = new google.maps.Polygon({\n";
                                echo"paths: PolygonCoords[{$i}],\n";
                                echo"strokeColor: '#";random_color();
								echo"',\n";
                                echo"strokeOpacity: 0.8,\n";
                                echo"strokeWeight: 2,\n";
                                echo"fillColor: '#";random_color();
								echo"',\n";
                                echo"fillOpacity: 0.35\n";
                         echo"});\n";

                         echo"PolyGon[{$i}].setMap(map);\n";
                 }
		}
		?>
  	  //Add the "click" event listener to the map, so we can capture
  	  //lat lon from a google map click.
	  google.maps.event.addListener(map, "click", function(event) {
		var lat = event.latLng.lat();
		var lng = event.latLng.lng();
		// populate yor box/field with lat, lng
		//console.write("Lat=" + lat + "; Lng=" + lng);
		$('#lat').val(lat);		//write lat to appropriate form field
		$('#lng').val(lng);		//same with lng
	  });
  
	}

	//Add a listener that runs "initialize" when page is done loading.
	google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
	<div id="FormDiv">
	<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
	Lat:<input type="text" name="lat" id="lat"><br>
	Lng:<input type="text" name="lng" id="lng"><br>

	No of Bases:<input type="text" name="basenumber" id="basenumber"><br>

	<input type="submit" name="submit" value="Get Poi's">
	</div>
	</form>
	<div id="map-canvas"></div>
  </body>
</html>