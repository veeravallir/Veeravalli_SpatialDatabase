<?php 
	include 'db_connect.php';
	include 'functions.php';
	
	unset($Coords);

       if(isset($_POST['Countries'])){
               foreach($_POST['Countries'] as $Cid){
                       $result = $con->query("SELECT asText(SHAPE) as border
                                                                  FROM `world_borders`
                                                                  WHERE CountryID = '{$Cid}'");
                       $Result = $result->fetch_assoc();
                       $CoordsArray[] = sql_to_coordinates($Result['border']);
               }
               $PrintMap = true;
       }
?>
<!DOCTYPE html>
<html>
 <head>
   <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
   <meta charset="utf-8">
   <title>Simple Polygon</title>
   <style>
     #map-canvas {
       height: 600px;
       margin: 0px;
       padding: 0px
     }
   </style>
   <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>

   <script>
               // This example creates a simple polygon representing selected countries on a map.

               var i = 0;

               function initialize() {
                 var mapOptions = {
                       zoom: 5,
                       <?php
                               $center = $CoordsArray[0][0];
							    $lat = $center['lat'];
                                $lng = $center['lng'];
                                $lat = str_replace("MULTI","",$lat);
                                $lng = str_replace("MULTI","",$lng);
                                $lat = str_replace("MULTI","",$lat);
                                $lng = str_replace("MULTI","",$lng);
								$lat = str_replace("(","",$lat);
                                $lng = str_replace("(","",$lng);
                                $lat = str_replace(")","",$lat);
                                $lng = str_replace(")","",$lng);
                       ?>
                       center: new google.maps.LatLng(<?=$lng?>,<?=$lat?>),
                       mapTypeId: google.maps.MapTypeId.TERRAIN
                 };

                 var map = new google.maps.Map(document.getElementById('map-canvas'),
                         mapOptions);

                 var PolygonCoords = new Array();
				 var PolyGon =new Array();
				 
                 <?php
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
                 ?>

               }

               <?php
               if($PrintMap){
               echo"google.maps.event.addDomListener(window, 'load', initialize);\n";
           }
           ?>

   </script>
 </head>
 <body>
       <div>
               <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
                       <?php
                       $result = $con->query("SELECT CountryID,name
                                                                  FROM `world_borders`
                                                                  ORDER BY name");
                       ?>
       <select name="Countries[]"  multiple="multiple">
                       <?php
                       while($row = $result->fetch_assoc()){
                               echo"\t\t<option value=\"{$row['CountryID']}\">{$row['name']}</option>\n";
                       }
                       ?>
                       <input type="submit" name="submit" value="Get Country">
               </form>
       </div>
   <div id="map-canvas"></div>
 </body>
</html>