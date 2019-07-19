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

   echo "<h3> SELECTED MARKET: ".$row["market_name"]."</h3>";


    $sql = "SELECT CUSTOMER.customer_name, CUSTOMER.customer_id
    FROM SALE
    INNER JOIN SALESMAN
    ON SALESMAN.salesman_id = SALE.salesman_id
    INNER JOIN MARKET
    ON MARKET.market_id = SALESMAN.market_id
    INNER JOIN CUSTOMER
    ON CUSTOMER.customer_id = SALE.customer_id
    WHERE MARKET.market_name = '".$row["market_name"]."'
    GROUP BY CUSTOMER.customer_name";

    $result = mysqli_query($conn,$sql);
   // echo("Error description: " . mysqli_error($conn) );

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        echo "<form action='ShowInvoice.php' method='post'>";
        echo '<input type="hidden"  name="selectedMarketName" value="'.$_POST['selectedMarketName'].'">';
        echo '<select name="selectedCustomerID">';

        while($row = mysqli_fetch_array($result)) {
            echo "<option value='" . $row["customer_id"] . "'>";
            echo $row["customer_name"];
            echo "</option>";
        }
        echo '</select>';
        echo '<input type="submit" value="GO">';
        echo "</form>";
    } else {
        echo "0 results";
    }
?>