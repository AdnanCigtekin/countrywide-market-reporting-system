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
 SELECT COUNT(PRODUCT.product_name), SALESMAN.salesman_name
 FROM SALE
 INNER JOIN PRODUCT
 ON PRODUCT.product_id = SALE.product_id
 INNER JOIN SALESMAN
 ON SALESMAN.salesman_id = SALE.salesman_id
 INNER JOIN MARKET
 ON MARKET.market_id = SALESMAN.market_id
 WHERE MARKET.market_name = '".$row["market_name"]."'
 GROUP BY SALESMAN.salesman_name;";

 $result = mysqli_query($conn,$sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
	echo "<table border='1'>";
	echo "<tr><td>SOLD ITEM AMOUNT</td><td>SALESMAN NAME</td></tr>";
    while($row = mysqli_fetch_array($result)) {
        echo "<tr>";

        echo "<td>" . $row["COUNT(PRODUCT.product_name)"]. "</td><td>" . $row["salesman_name"]. "</td>";
		echo "</tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}

mysqli_close($conn);
?>