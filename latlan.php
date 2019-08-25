<!DOCTYPE html>
<html>
<head>
	<title>get latitude and longitude</title>
</head>
<body>
	
		<button onclick="getLocation()">
			GET LOCATION
		</button>

		<div id="output"></div>
	
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
			x.innerHTML= "latitude="+position.coords.latitude;
			x.innerHTML += "</br>";
			x.innerHTML += "latitude="+position.coords.longitude;
			
		}
	</script>
</body>
</html>