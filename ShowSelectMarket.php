<?php
    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "adnan_cigtekin";
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $sql = "SELECT market_id,market_name FROM MARKET GROUP BY market_name";
    $result = mysqli_query($conn,$sql) or die("Error");


    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        echo "<form action='MarketActions.php' method='post'>";
        echo '<select name="selectedMarketName">';
        
        while($row = mysqli_fetch_array($result)) {
            echo "<option value='" . $row["market_id"] . "'>";
            echo $row["market_name"];
            echo "</option>";
        }
        echo '</select>';
        echo '<input type="submit" value="GO">';
        echo "</form>";
    } else {
        echo "0 results";
    }

    mysqli_close($conn);
?>