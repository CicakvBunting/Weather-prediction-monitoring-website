<html>
<body>

<?php
// data = {
//     'Solar Irradiance': {irradiance},
//     'Wind Speed': {windspeed},
//     'Current' : {karusfomo},
//     'Voltage' : {kvoltfomo},
//     'Relative Humidity' : {humidity},
//     'Surface Temperature PV' : {tempfomo} ,
//     'Relative Temperature' : {temperature}    
// }
include("database/connection.php");
include("database/functions.php");

if(!$conn){
	echo "Error: " . mysqli_connect_error();
	exit();
}

echo "Connection Success!<br><br>";

$solar = $_GET["Solar Irradiance"];
$wind = $_GET["Wind Speed"];
$current = $_GET["Current"];
$voltage = $_GET["Voltage"];
$humi = $_GET["Relative Humidity"];
$surtem = $_GET["Surface Temperature PV"];
$temp = $_GET["Relative Temperature"];

// `solarirradiance`, `relativetemperature`, `relativehumidity`, `windspeed`, `surfacetemperaturearray`, `surfacetemperatureweather`
$query = "INSERT INTO test (solarirradiance,relativetemperature,relativehumidity,windspeed,surfacetemperaturearray,voltage,current) VALUES ('$solar', '$temp','$humi','$wind','$surtem','$voltage','$current')";
$result = mysqli_query($conn,$query);

echo "Insertion Success!<br>";

?>
</body>
</html>