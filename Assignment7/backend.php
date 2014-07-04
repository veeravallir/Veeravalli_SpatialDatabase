<?php 

/**   
###  Assignment 7

###  Ramakrishna Veeravalli  & Rohit Mukherjee

### Subject : 5443-Spatial Databases

### Implementing Queries related to Bounding Rectangle 
**/

error_reporting(0);

//Establish connection to database.
$Conn = new PDO("pgsql:host=localhost;dbname=5443","5443","5443");

if(isset($argv[1]) && $argv[1]=='debug'){
	$_POST = unserialize(file_get_contents("array.out"));
	print_r($_POST);
}

$fp = fopen('array.out','w');
fwrite($fp,serialize($_POST));
fclose($fp);


$fp = fopen('error.log','w');
fwrite($fp,time()."\n");
$out = print_r($_POST,true);
fwrite($fp,$out);


if(isset($argv[1]) && $argv[1]=='debug' || $_GET['debug']){
	$_POST['lat'] = 33.546;
	$_POST['lng'] = -122.546;
	$_POST['earthQuakes'] = true;
	$debug = true;
}


switch($_POST['QueryNum']){
	case 1:
		$Data = Query1($_POST);
		break;
	case 2:
		$Data = Query2($_POST);
		break;
	case 3:
		$Data = Query3($_POST);
		break;
	case 4:
		$Data = Query4($_POST);
		break;
	case 5:
		$sql = "";
		break;
	case 6:
		$sql = "";
		break;
}
// To send the data to javascript file
echo json_encode($Data);

/*
Query to find Select all features completely contained within bounding rectangle.
@ used for contains 


*/

function Query1($post){
	global $fp;
       global $Conn;
       
       $Lat1 = $post['lat1'];
       $Lon1 = $post['lon1'];
       $Lat2 = $post['lat2'];
       $Lon2 = $post['lon2'];
       
       $Points = array();
       
       foreach($post['sources'] as $source){
               $sql = "
                       SELECT ST_AsGeoJSON(wkb_geometry) AS wkb
                       FROM {$source}
                       WHERE wkb_geometry @ ST_MakeEnvelope({$Lon1}, {$Lat1},{$Lon2},{$Lat2})
               ";
               //echo $sql."\n";
               fwrite($fp,print_r($sql,true));
               $result = $Conn->query($sql);
               while($row = $result->fetch(PDO::FETCH_ASSOC)){

                       $Points[] = $row['wkb'];
               }
       }
       fwrite($fp,print_r($Points,true));
       //print_r($Points);
       return $Points;
	   }

	   
	/*
Query to find Select all features completely contained within bounding rectangle.
		&&  used for intersection  


*/
   
	
	
	function Query2($post){
	global $fp;
       global $Conn;
       
       $Lat1 = $post['lat1'];
       $Lon1 = $post['lon1'];
       $Lat2 = $post['lat2'];
       $Lon2 = $post['lon2'];
       
       $Points = array();
       
       foreach($post['sources'] as $source){
               $sql = "
                       SELECT ST_AsGeoJSON(wkb_geometry) AS wkb
                       FROM {$source}
                       WHERE wkb_geometry  &&  ST_MakeEnvelope({$Lon1}, {$Lat1},{$Lon2},{$Lat2})
               ";
               fwrite($fp,print_r($sql,true));
               $result = $Conn->query($sql);
               while($row = $result->fetch(PDO::FETCH_ASSOC)){

                       $Points[] = $row['wkb'];
               }
       }
       fwrite($fp,print_r($Points,true));
       //print_r($Points);
       return $Points;
	   }

	   
	  	/*
Query to find Select all features that are within 100 miles, but not in contact or within bounding rectangle.
		ST_DWithin   used for  finding the things within X distance of other thing  


*/ 
	   
	   	   function Query3($post){
		global $fp;
       global $Conn;
       
       $Lat1 = $post['lat1'];
       $Lon1 = $post['lon1'];
       $Lat2 = $post['lat2'];
       $Lon2 = $post['lon2'];
       
       $Points = array();
       
       foreach($post['sources'] as $source){
               $sql = "
                       SELECT ST_AsGeoJSON(wkb_geometry) AS wkb  
					   FROM {$source}
						WHERE ST_DWithin(wkb_geometry, ST_MakeEnvelope({$Lon1}, {$Lat1},{$Lon2},{$Lat2}), 100.0) AND  
						NOT wkb_geometry   IN( SELECT wkb_geometry 
                       FROM {$source}
                       WHERE wkb_geometry @ ST_MakeEnvelope({$Lon1}, {$Lat1},{$Lon2},{$Lat2}));
               ";
               fwrite($fp,print_r($sql,true));
               $result = $Conn->query($sql);
               while($row = $result->fetch(PDO::FETCH_ASSOC)){

                       $Points[] = $row['wkb'];
               }
       }
       fwrite($fp,print_r($Points,true));
       //print_r($Points);
       return $Points;
	   }
	   
	   /*
			Query to find Based on an input form, display only specified features within bounding rectangle.
		@ USED FOR CONTAINS WITH IN THE GEOMETRY


*/ 
	   function Query4($post){
	global $fp;
       global $Conn;
       
       $Lat1 = $post['lat1'];
       $Lon1 = $post['lon1'];
       $Lat2 = $post['lat2'];
       $Lon2 = $post['lon2'];
       
       $Points = array();
       
       foreach($post['sources'] as $source){
					$sql = "
                       SELECT ST_AsGeoJSON(wkb_geometry) AS wkb
                       FROM {$source}
                       WHERE wkb_geometry @ ST_MakeEnvelope({$Lon1}, {$Lat1},{$Lon2},{$Lat2})
					";
               fwrite($fp,print_r($sql,true));
               $result = $Conn->query($sql);
               while($row = $result->fetch(PDO::FETCH_ASSOC)){

                       $Points[] = $row['wkb'];
               }
       }
       fwrite($fp,print_r($Points,true));
       //print_r($Points);
       return $Points;
	   }

	   function Query5($post){
	global $fp;
       global $Conn;
       
       $Lat1 = $post['lat1'];
       $Lon1 = $post['lon1'];
       $Lat2 = $post['lat2'];
       $Lon2 = $post['lon2'];
       
       $Points = array();
       
       foreach($post['sources'] as $source){
               $sql = "
                      SELECT ST_AsGeoJSON(wkb_geometry) AS wkb  FROM {$source}
  WHERE BuildCircleMbr(ST_DWithin(wkb_geometry, ST_MakeEnvelope({$Lon1}, {$Lat1},{$Lon2},{$Lat2}), 5.0)) ;
               ";
               fwrite($fp,print_r($sql,true));
               $result = $Conn->query($sql);
               while($row = $result->fetch(PDO::FETCH_ASSOC)){

                       $Points[] = $row['wkb'];
               }
       }
       fwrite($fp,print_r($Points,true));
       //print_r($Points);
       return $Points;
	   }
	   
	   
function sql_to_coordinates($blob)
{
	$blob = str_replace("))", "", str_replace("POLYGON((", "", $blob));
	$coords = explode(",", $blob);
	$coordinates = array();
	foreach($coords as $coord)
	{
		$coord_split = explode(" ", $coord);
		$coordinates[]=array(str_replace("\n","",$coord_split[0]),str_replace("\n","",$coord_split[1]));
	}
	return $coordinates;
}

function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}

function getFeatures(){
    $sql = "SELECT * FROM pg_catalog.pg_tables WHERE schemaname = 'public'";
    $result = $db->query($sql);
    $TableArray = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        $TableArray[] = $row['tablename'];
    }
    echo json_encode($TableArray);
}
fclose($fp);
