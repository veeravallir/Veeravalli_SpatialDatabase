<?php

/**
 * This function converts a WKT string into a PHP array of polygonal coordinate pairs.
 * @param string $wkt_str is the Well-Known-Text string representing one or more polygons
 * @return array Returns an array of polygons with sub arrays of coordinate pairs
 */ 

function convert_wkt_to_poly_arr($wkt_str)
{
  $ret_arr = array();
  $matches = array();

  preg_match('/\)\s*,\s*\(/', $wkt_str, $matches);

  if(empty($matches))
  {  
      $polys = array(trim($wkt_str));
  }
  else
  {
      $polys = explode($matches[0], trim($wkt_str));
  }
  foreach($polys as $poly)
  {
      $ret_arr[] = str_replace('(','',str_replace(')','',substr($poly, stripos($poly,'(')+2, stripos($poly,')')-2))); 
  }

  return $ret_arr;

}

function sql_to_coordinates($blob)
    {
        $blob = str_replace("))", "", str_replace("POLYGON((", "", $blob));
        $coords = explode(",", $blob);
        $coordinates = array();
        foreach($coords as $coord)
        {
            $coord_split = explode(" ", $coord);
            $coordinates[]=array("lat"=>$coord_split[0], "lng"=>$coord_split[1]);
        }
        return $coordinates;
    }
	
	       function random_color_part() {
				$s = str_pad( dechex(mt_rand( 0,255 ) ), 2, '0', STR_PAD_LEFT);
				print_r($s);
               //return $s;
       }

       function random_color() {
               random_color_part() . random_color_part() . random_color_part();
       }
?>