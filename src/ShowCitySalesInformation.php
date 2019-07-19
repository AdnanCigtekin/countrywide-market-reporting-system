<?php
    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "adnan_cigtekin";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } 

    $sql = "SELECT COUNT(MARKET.market_name), MARKET.market_name
            FROM SALE
            INNER JOIN SALESMAN 
            ON SALESMAN.salesman_id = SALE.salesman_id 
            INNER JOIN MARKET 
            ON SALESMAN.market_id = MARKET.market_id
            WHERE MARKET.city_id = ". $_POST['selectedCityName'] ."
            GROUP BY MARKET.market_name";
//echo $sql;
$result = mysqli_query($conn,$sql) or die("Error");
$resForPie = "";
if (mysqli_num_rows($result) > 0) {
    // output data of each row
	echo "<table border='1'>";
	echo "<tr><td>count</td><td>market_name</td></tr>";
    while($row = mysqli_fetch_array($result)) {
		echo "<tr>";
        echo "<td>" . $row["COUNT(MARKET.market_name)"]. "</td><td>" . $row["market_name"]. "</td>";
        $resForPie .= "{y: ".$row["COUNT(MARKET.market_name)"].", label: '".$row["market_name"]."'},\n"; 
		echo "</tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}
//echo("Error description: " . mysqli_error($conn) );




echo "
<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function() {

var chart = new CanvasJS.Chart(\"chartContainer\", {
	animationEnabled: true,
	title: {
		text: \"PRODUCTS SOLD\"
	},
	data: [{
		type: \"bar\",
		startAngle: 240,
		yValueFormatString: \"##0.00\",
		indexLabel: \"{label} {y}\",
		dataPoints: [
            ".$resForPie."

		]
	}]
});
chart.render();



}
</script>
</head>
<body>
<div id=\"chartContainer\" style=\"height: 370px; width: 100%;\"></div>

<script src=\"https://canvasjs.com/assets/script/canvasjs.min.js\"></script>
</body>
</html>
";


mysqli_close($conn);
?>