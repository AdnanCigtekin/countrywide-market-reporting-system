<?php
    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "adnan_cigtekin";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $sql = "SELECT city_name,city_id FROM CITY ";
    $result = mysqli_query($conn,$sql) or die("Error");

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        echo "<form action='ShowCitySalesInformation.php' method='post'>";
        echo '<select name="selectedCityName">';
        
        while($row = mysqli_fetch_array($result)) {
            $SehirAdi = mb_convert_encoding($row["city_name"],"UTF-8","ISO-8859-9");
            echo "<option value='" . $row["city_id"] . "'>";
            echo $SehirAdi;
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