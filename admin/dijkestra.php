<?php $INT_MAX = 0x7FFFFFFF;

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

function PrintResult($distance, $verticesCount,$emailid)
{
	echo "<pre>" . "Vertex    Distance from source" . "</pre>";

	for ($i = 0; $i < $verticesCount; ++$i)
		echo "<pre>" . $i . "\t  " . $distance[$i] . "</pre></br>";
		sort( $distance, SORT_NUMERIC );
		asort($distance);
		foreach ($distance as $s) {
			echo $s."<br>";
		}
		$smallest = array_shift( $distance );
		$smallest_2nd = array_shift( $distance );
		echo "Nearest node is in distance : ".$smallest_2nd." Km"." ".$emailid;
		
}

function Dijkstra($graph, $source, $verticesCount,$user2)
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
			
			
			$emailid=$user2[$u];
			
		}
		
	}

	PrintResult($distance, $verticesCount,$emailid);
}



?>

<?php 



if (isset($_POST['submit']))
{
	$sql="SELECT * FROM tbldriverstatus";
	$query = $dbh -> prepare($sql);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$user=[];
	$user[]=0;
	$user2[]=" ";
	if($query->rowCount() > 0)
	{	
		foreach($results as $result)
		{ 	
			$latitude2=$result->Latitude;
			$longitude2=$result->Longitude;
			$EmailId=$result->EmailId; 
			//$user3[]=$result->Id;
			$latitude1= $_POST['lat1'];
			$longitude1=$_POST['lon1'];
			$distance=getDistance($latitude1,$longitude1,$latitude2,$longitude2);
			$user[] = $distance;
			$user2[]=$EmailId;

			

		}
		
		
		$graph=array(
			array($user[0],$user[1],$user[2],$user[3],$user[4],$user[5],$user[6],$user[7],$user[8],$user[9]),
			array($user[1],0,40,0,23,30,0,0,0,0),
			array($user[2],40,0,123,0,0,0,0,0,0),
			array($user[3],0,123,0,0,0,0,0,90,0),
			array($user[4],23,0,0,0,25,0,0,0,0),
			array($user[5],30,0,0,25,0,95,0,0,0),
			array($user[6],0,0,0,0,95,0,71,44,0),
			array($user[7],0,0,0,0,0,71,0,0,85),
			array($user[8],0,0,90,0,0,44,0,0,110),
			array($user[9],0,0,0,0,0,0,85,110,0),
		);
		



		Dijkstra($graph, 0, 10,$user2);
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
		<input type="hidden" name="output" id="lat1"><br><br>
		<input type="hidden" name="output" id="lon1"><br><br>
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
<script src="https://code.jquery.com/jquery-2.2.4.js"></script>
	<script>
		var x=document.getElementById('output')
		function getLocation(){
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(showPosition);
			}
			else{
				x.innerHTML="Browser not supporting";
			}

		}
		function showPosition(position) {
			x.innerHTML= position.coords.latitude;
			x.innerHTML += "</br>";
			x.innerHTML +=position.coords.longitude;
			
		}
	</script>
