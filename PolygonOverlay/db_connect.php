<?
// Create connection
    $con=mysqli_connect("localhost","rveeravalli","teo7Pup0","rveeravalli");

    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
	//echo"Database Connected";
?>