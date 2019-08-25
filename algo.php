<?php
include('includes/config.php');

 $INT_MAX = 0x7FFFFFFF;

function MinimumDistance($distance, $shortestPathTreeSet, $verticesCount)
{
	global $INT_MAX;
	$min = $INT_MAX;
	$minIndex = 0;

	for ($v = 0; $v < $verticesCount; ++$v)
	{
		if ($shortestPathTreeSet[$v] == false && $distance[$v] <= $min)
		{
			$min = $distance[$v];
			$minIndex = $v;
		}
	}

	return $minIndex;
}

function PrintResult($distance, $verticesCount)
{
	echo "<pre>" . "Vertex    Distance from source" . "</pre>";

	for ($i = 0; $i < $verticesCount; ++$i)

		$node=$i;
		foreach ($distance as $s) {
		
		$insert="INSERT into distance(node,distance) values (:node,:distance) ";
		$iquery=$dbh->prepare($insert);
		$iquery->bindParam(':node',$node,PDO::PARAM_STR);
		$iquery->bindParam(':distance',$s,PDO::PARAM_STR);
		$iquery->execute();
		
		}
		
}

function Dijkstra($graph, $source, $verticesCount)
{
	global $INT_MAX;
	$distance = array();
	$shortestPathTreeSet = array();

	for ($i = 0; $i < $verticesCount; ++$i)
	{
		$distance[$i] = $INT_MAX;
		$shortestPathTreeSet[$i] = false;
	}

	$distance[$source] = 0;

	for ($count = 0; $count < $verticesCount - 1; ++$count)
	{
		$u = MinimumDistance($distance, $shortestPathTreeSet, $verticesCount);
		$shortestPathTreeSet[$u] = true;
		

		for ($v = 0; $v < $verticesCount; ++$v)
			if (!$shortestPathTreeSet[$v] && $graph[$u][$v] && $distance[$u] != $INT_MAX && $distance[$u] + $graph[$u][$v] <= $distance[$v]){
				$distance[$v] = $distance[$u] + $graph[$u][$v];
			
		
		}
		
	}

	PrintResult($distance, $verticesCount);
}



?>

<?php 


if (isset($_POST['submit']))
{
	$sql="SELECT * FROM location";
	$query = $dbh -> prepare($sql);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$user=[];
	$user[]=0;
	
	if($query->rowCount() > 0)
	{	
		foreach($results as $result)
		{ 	
			$latitude2=$result->lat;
			$longitude2=$result->lng;
			$description=$result->description; 
			
			$latitude1= $_POST['lat1'];
			$longitude1=$_POST['lon1'];
			$distance=getDistance($latitude1,$longitude1,$latitude2,$longitude2);
			$user[] = $distance;
			
			

		}
		
		
		$graph=array(
			array($user[0],$user[1],$user[2],$user[3],$user[4],$user[5],$user[6]),
			array($user[1],0,77,94,0,0,0),
			array($user[2],77,0,0,0,51,0),
			array($user[3],94,0,0,67,30,0),
			array($user[4],0,0,64,0,0,37),
			array($user[5],0,51,30,0,0,91),
			array($user[6],0,0,0,37,91,0),



		);
		



		Dijkstra($graph, 0, 7);

	}
	

}
?>
<!DOCTYPE html>
<html>
<head>
	<title>shortest distance</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
	<form method="POST">
		<input type="text" name="lat1" id="lat1"><br><br>
		<input type="text" name="lon1" id="lon1"><br><br>
		<input type="submit" name="submit">
	</form>
	<script type="text/javascript">
		$(document).ready(function(){
		
        navigator.geolocation.getCurrentPosition(function(){
        	 position.coords.latitude= $("#lat1").val();
	         position.coords.longitude=$("#lon1").val();
  	    
        });
    });
		
	</script>
</body>
</html>
<?php
	function getDistance($latitude1,$longitude1,$latitude2,$longitude2){

			$earthRadius=6371;
			$latFrom=deg2rad($latitude1);
			$lonFrom=deg2rad($longitude1);
			$latTo=deg2rad($latitude2);
			$lonTo=deg2rad($longitude2);

			$latDelta=$latTo-$latFrom;
			$lonDelta=$lonTo-$lonFrom;

			$angle=2*asin(sqrt(pow(sin($latDelta/2), 2)+cos($latFrom)*cos($latTo)*pow($lonDelta/2, 2)));
			return $angle*$earthRadius;
			
			}
?>
