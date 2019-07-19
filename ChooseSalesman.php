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


    $sql = "SELECT SALESMAN.salesman_name, SALESMAN.salesman_id
    FROM SALE
    INNER JOIN SALESMAN
    ON SALESMAN.salesman_id = SALE.salesman_id
    INNER JOIN MARKET
    ON MARKET.market_id = SALESMAN.market_id
    WHERE MARKET.market_name = '".$row["market_name"]."'
    GROUP BY SALESMAN.salesman_name";

    $result = mysqli_query($conn,$sql);
    //echo("Error description: " . mysqli_error($conn) );

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        echo "<form action='ShowSalesmanDetails.php' method='post'>";
        echo '<input type="hidden"  name="selectedMarketName" value="'.$marketName.'">';
        echo '<select name="selectedSalesmanName">';

        while($row = mysqli_fetch_array($result)) {
            echo "<option value='" . $row["salesman_id"] . "'>";
            echo $row["salesman_name"];
            echo "</option>";
        }
        echo '</select>';
        echo '<input type="submit" value="GO">';
        echo "</form>";
    } else {
        echo "0 results";
    }
?>