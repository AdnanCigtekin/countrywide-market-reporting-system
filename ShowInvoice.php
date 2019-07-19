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
    $marketName = $row["market_name"];
   echo "<h3> SELECTED MARKET: ".$marketName."</h3>";




    $sql = "SELECT MARKET.market_id, MARKET.market_name, PRODUCT.product_name, CUSTOMER.customer_name, PRODUCT.product_price,SALE.sale_date
    FROM SALE
    INNER JOIN CUSTOMER
    ON CUSTOMER.customer_id = SALE.customer_id
    INNER JOIN SALESMAN
    ON SALESMAN.salesman_id = SALE.salesman_id
    INNER JOIN MARKET
    ON MARKET.market_id = SALESMAN.market_id
    INNER JOIN PRODUCT
    ON PRODUCT.product_id = SALE.product_id
    WHERE CUSTOMER.customer_id = ".$_POST['selectedCustomerID']." 
    HAVING MARKET.market_name = '".$row["market_name"]."'";

    $result2 = mysqli_query($conn,$sql);
    //$row = mysqli_fetch_array($result);

    //echo $sql;
    if (mysqli_num_rows($result2) > 0) {
        // output data of each row
        echo "<table border='1'>";
        echo "<tr><td>customer name</td><td>product name</td><td>product price</td><td>sale date</td><td>TOTAL COST</td></tr>";
        $totalcost = 0;
        while($row2 = mysqli_fetch_array($result2)) {
            echo "<tr>";
            echo "<td>" .$row2["customer_name"]. "</td><td>" . $row2["product_name"]. "</td><td>" . $row2["product_price"]. "</td><td>" . $row2["sale_date"]. "</td><td></td>";
            $totalcost += $row2["product_price"];
            echo "</tr>";
        }


       // echo $totalcost;

           
        echo "<tr>";
        echo "<td></td><td></td><td></td><td></td><td>".$totalcost." TL</td>";
        echo "</tr>";
               
        echo "</table>";
    } else {
        echo "0 results";
    }
   // echo("Error description: " . mysqli_error($conn) );

    mysqli_close($conn);
?>