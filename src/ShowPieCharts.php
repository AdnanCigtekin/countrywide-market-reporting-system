<?php
 $servername = "localhost";
 $username = "root";
 $password = "mysql";
 $dbname = "adnan_cigtekin";

 // Create connection
 $conn = mysqli_connect($servername, $username, $password, $dbname);

 // Check connection
 if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
 } 

 $sql = "SELECT COUNT(SALE.sale_id), DISTRICT.district_name
 FROM SALE
 INNER JOIN SALESMAN
 ON SALESMAN.salesman_id = SALE.salesman_id
 INNER JOIN MARKET
 ON MARKET.market_id = SALESMAN.market_id
 INNER JOIN CITY
 ON MARKET.city_id = CITY.city_id
 INNER JOIN DISTRICT
 ON DISTRICT.district_id = CITY.district_id
 group by DISTRICT.district_name";

$result = mysqli_query($conn,$sql) or die("Error");

$resForPie = "";
if (mysqli_num_rows($result) > 0) {

    
    while($row = mysqli_fetch_array($result)) {
        $resForPie .= "{y: ".$row["COUNT(SALE.sale_id)"].", label: '".$row["district_name"]."'},\n"; 

    }

} else {
    echo "0 results";
}

$sql = "SELECT COUNT(SALE.sale_id), MARKET.market_name
FROM SALE
INNER JOIN SALESMAN
ON SALESMAN.salesman_id = SALE.salesman_id
INNER JOIN MARKET
ON MARKET.market_id = SALESMAN.market_id
group by MARKET.market_name";

$result = mysqli_query($conn,$sql) or die("Error");
$resForPie2 = "";
if (mysqli_num_rows($result) > 0) {

    
    while($row = mysqli_fetch_array($result)) {
        $resForPie2 .= "{y: ".$row["COUNT(SALE.sale_id)"].", label: '".$row["market_name"]."'},\n"; 

    }

} else {
    echo "0 results";
}

echo "
<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function() {

var chart = new CanvasJS.Chart(\"chartContainer\", {
	animationEnabled: true,
	title: {
		text: \"SALES DIVIDED TO DISTRICTS\"
	},
	data: [{
		type: \"pie\",
		startAngle: 240,
		yValueFormatString: \"##0.00\",
		indexLabel: \"{label} {y}\",
		dataPoints: [
            ".$resForPie."

		]
	}]
});
chart.render();

var chart2 = new CanvasJS.Chart(\"chartContainer2\", {
	animationEnabled: true,
	title: {
		text: \"SALES DIVIDED TO MARKETS\"
	},
	data: [{
		type: \"pie\",
		startAngle: 240,
		yValueFormatString: \"##0.00\",
		indexLabel: \"{label} {y}\",
		dataPoints: [
            ".$resForPie2."

		]
	}]
});
chart2.render();

}
</script>
</head>
<body>
<div id=\"chartContainer\" style=\"height: 370px; width: 100%;\"></div>
<div id=\"chartContainer2\" style=\"height: 370px; width: 100%;\"></div>
<script src=\"https://canvasjs.com/assets/script/canvasjs.min.js\"></script>
</body>
</html>
";




?>