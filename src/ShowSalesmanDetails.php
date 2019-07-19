<?php
 $servername = "localhost";
 $username = "root";
 $password = "mysql";
 $dbname = "adnan_cigtekin";

 $conn = mysqli_connect($servername, $username, $password, $dbname);



    echo "<h3> SELECTED MARKET: ".$_POST['selectedMarketName']."</h3>";

 $sql = "
  SELECT salesman_name
  FROM SALESMAN 
  WHERE salesman_id = ".$_POST['selectedSalesmanName']." 
  GROUP BY salesman_name";

 $result = mysqli_query($conn,$sql);
 $row = mysqli_fetch_array($result);

 //echo("Error description: " . mysqli_error($conn) );


 echo "<h3> SELECTED SALESMAN: ".$row["salesman_name"]."</h3>";

 $sql = "
 SELECT SALESMAN.salesman_name, PRODUCT.product_name, CUSTOMER.customer_name,PRODUCT.product_price,SALE.sale_date
 FROM SALE
 INNER JOIN SALESMAN
 ON SALESMAN.salesman_id = SALE.salesman_id
 INNER JOIN PRODUCT
 ON PRODUCT.product_id = SALE.product_id
 INNER JOIN CUSTOMER
 ON CUSTOMER.customer_id = SALE.customer_id
 HAVING SALESMAN.salesman_name = '".$row[salesman_name]."'";

 $result = mysqli_query($conn,$sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
	echo "<table border='1'>";
	echo "<tr><td>SOLD PRODUCT</td><td>CUSTOMER</td><td>PRICE</td><td>SALE DATE</td></tr>";
    while($row = mysqli_fetch_array($result)) {
        echo "<tr>";

        echo "<td>" . $row["product_name"]. "</td><td>" . $row["customer_name"]. "</td><td>" . $row["product_price"]. "</td><td>".$row["sale_date"]."</td>";
		echo "</tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}

mysqli_close($conn);
?>