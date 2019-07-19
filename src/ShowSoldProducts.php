<?php
 $servername = "localhost";
 $username = "root";
 $password = "mysql";
 $dbname = "adnan_cigtekin";

 $conn = mysqli_connect($servername, $username, $password, $dbname);

 $sql = "
  SELECT market_name
  FROM MARKET 
  WHERE market_id = ".$_POST['selectedMarketName']." 
  GROUP BY market_name";

 $result = mysqli_query($conn,$sql);
 $row = mysqli_fetch_array($result);

 //echo("Error description: " . mysqli_error($conn) );


 echo "<h3> SELECTED MARKET: ".$row["market_name"]."</h3>";

 $sql = "
 SELECT COUNT(PRODUCT.product_name), PRODUCT.product_name
 FROM SALE
 INNER JOIN PRODUCT
 ON PRODUCT.product_id = SALE.product_id
 INNER JOIN SALESMAN
 ON SALESMAN.salesman_id = SALE.salesman_id
 INNER JOIN MARKET
 ON MARKET.market_id = SALESMAN.market_id
 WHERE MARKET.market_name = '".$row["market_name"]."'
 GROUP BY(PRODUCT.product_name)";

 $result = mysqli_query($conn,$sql);
 $resForPie = "";
if (mysqli_num_rows($result) > 0) {
    // output data of each row
	echo "<table border='1'>";
	echo "<tr><td>count</td><td>product name</td></tr>";
    while($row = mysqli_fetch_array($result)) {
        echo "<tr>";

        echo "<td>" . $row["COUNT(PRODUCT.product_name)"]. "</td><td>" . $row["product_name"]. "</td>";
        $resForPie .= "{y: ".$row["COUNT(PRODUCT.product_name)"].", label: '".$row["product_name"]."'},\n"; 
		echo "</tr>";
    }
	echo "</table>";
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
		text: \"PRODUCTS SOLD\"
    },

	data: [{
		type: \"bar\",
		startAngle: 240,
		yValueFormatString: \"##0.00\",
		
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
<div id=\"chartContainer\" style=\"height: 1000px; width: 100%;\"></div>

<script src=\"https://canvasjs.com/assets/script/canvasjs.min.js\"></script>
</body>
</html>
";


mysqli_close($conn);
?>