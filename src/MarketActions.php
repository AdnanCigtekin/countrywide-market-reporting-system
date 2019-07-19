<?php
 $servername = "localhost";
 $username = "root";
 $password = "mysql";
 $dbname = "adnan_cigtekin";

 $conn = mysqli_connect($servername, $username, $password, $dbname);

 $sql = "SELECT market_name FROM MARKET WHERE market_id = ".$_POST['selectedMarketName']." GROUP BY market_name";
 $result = mysqli_query($conn,$sql) or die("Error");
 $row = mysqli_fetch_array($result);



 echo "<h3> SELECTED MARKET: ".$row["market_name"]."</h3>";

 echo "<form action='ShowSoldProducts.php' method='post'>";
 echo '<input type="hidden"  name="selectedMarketName" value="'.$_POST['selectedMarketName'].'">';
 echo '<input type="submit"  value="Product">';
 echo "</form>";

 echo "<form action='ShowAllSalesmans.php' method='post'>";
 echo '<input type="hidden"  name="selectedMarketName" value="'.$_POST['selectedMarketName'].'">';
 echo '<input type="submit" value="Salesman">';
 echo "</form>";
 
 echo "<form action='ChooseSalesman.php' method='post'>";
 echo '<input type="hidden"  name="selectedMarketName" value="'.$_POST['selectedMarketName'].'">';
 echo '<input type="submit" value="Choose Salesman">';
 echo "</form>";

 echo "<form action='ChooseCustomer.php' method='post'>";
 echo '<input type="hidden"  name="selectedMarketName" value="'.$_POST['selectedMarketName'].'">';
 echo '<input type="submit" value="Invoice">';
 echo "</form>";
 mysqli_close($conn);
?>