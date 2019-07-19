
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


    $sql = "
        DROP DATABASE IF EXISTS adnan_cigtekin;
        CREATE DATABASE adnan_cigtekin;
        USE adnan_cigtekin;


        CREATE TABLE IF NOT EXISTS `DISTRICT` (
          `district_id` int(11) NOT NULL,
          `district_name` varchar(50) NOT NULL,
          PRIMARY KEY(`district_id`)
        ) ENGINE=InnoDB;
        
        CREATE TABLE IF NOT EXISTS `CITY` (
          `city_id` int(11) NOT NULL AUTO_INCREMENT,
          `city_name` varchar(50) NOT NULL,
          `district_id` int(11) NOT NULL,
          FOREIGN KEY district_id_fk (`district_id`) REFERENCES `DISTRICT` (`district_id`),
          PRIMARY KEY(`city_id`)
        ) ENGINE=InnoDB;
        
        
        CREATE TABLE IF NOT EXISTS `MARKET` (
          `market_id` int(11) NOT NULL AUTO_INCREMENT,
          `market_name` varchar(50) NOT NULL,
          `city_id` int(11) NOT NULL,
          FOREIGN KEY city_id_fk (`city_id`) REFERENCES `CITY` (`city_id`), 
          /* ASSUMPTION: 
                There are only 10 supermarkets in whole country. Every city has 5 random ones in it.
                We cant create tables for each city. So we make foreign key between cities and markets.
                There will be more than one market which has same name but each market with same name will be
                in different city.
           */
          PRIMARY KEY(`market_id`)
        ) ENGINE=InnoDB;
        
        
        
        
        CREATE TABLE IF NOT EXISTS `SALESMAN` (
          `salesman_id` int(11) NOT NULL AUTO_INCREMENT,
          `salesman_name` varchar(50) NOT NULL,
          `market_id` int(11) NOT NULL,
          FOREIGN KEY market_id_fk (`market_id`) REFERENCES `MARKET` (`market_id`), 
          PRIMARY KEY(`salesman_id`)
        ) ENGINE=InnoDB;
        
        CREATE TABLE IF NOT EXISTS `CUSTOMER` (
          `customer_id` int(11) NOT NULL AUTO_INCREMENT,
          `customer_name` varchar(50) NOT NULL,
          PRIMARY KEY(`customer_id`)
        ) ENGINE=InnoDB;
        
        
        CREATE TABLE IF NOT EXISTS `PRODUCT` (
          `product_id` int(11) NOT NULL AUTO_INCREMENT,
          `product_name` varchar(50) NOT NULL,
          `product_price` varchar(50) NOT NULL,
          PRIMARY KEY(`product_id`)
        ) ENGINE=InnoDB;
        
        
        CREATE TABLE IF NOT EXISTS `SALE` (
          `sale_id` int(11) NOT NULL AUTO_INCREMENT,
          `product_id` int(11) NOT NULL,
          `customer_id` int(11) NOT NULL,
          `salesman_id` int(11) NOT NULL,
          `sale_date` date NOT NULL,
          FOREIGN KEY product_id_fk (`product_id`) REFERENCES `PRODUCT` (`product_id`),
          FOREIGN KEY customer_id_fk (`customer_id`) REFERENCES `CUSTOMER` (`customer_id`),
          FOREIGN KEY salesman_id_fk (`salesman_id`) REFERENCES `SALESMAN` (`salesman_id`),
          PRIMARY KEY(`sale_id`)
        ) ENGINE=InnoDB;
        

    ";
    mysqli_multi_query($conn,$sql);

    //echo("Error description: " . mysqli_error($conn). "\n");
    mysqli_close($conn);


    /////////////////////////INSERT DISTRICTS///////////////////////////////////////////////////////////
    $row = 0;
	$i = -1;
    $filename = "csv/Districts.csv";

    if(!file_exists($filename) || !is_readable($filename))
    return FALSE;
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $header = NULL;
    if (($handle = fopen($filename, 'r')) !== FALSE)
	{
		while (($row = fgetcsv($handle, 1000, ';')) !== FALSE)
		{
			if(!$header)
				$header = $row;
			else{
                $sql = "INSERT INTO `DISTRICT` (`district_id`, `district_name`) VALUES
                ('".$row[0]."','". $row[1]."')";
                mysqli_multi_query($conn,$sql);
                //echo $row[1]."\n";
			}
			$i++;
		}
		fclose($handle);
	}
    
    //echo "Insertion of districts has finished!";
   /// echo("Error description: " . mysqli_error($conn) );
    mysqli_close($conn);
    ////////////////////////////////////////////////////////////////////////////////////////////////////


    ////////////////////INSERT CITIES///////////////////////////////////////////////////////////////////
    $row = 0;
	$i = -1;
    $filename = "csv/Cities.csv";

    if(!file_exists($filename) || !is_readable($filename))
    return FALSE;
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $cityNames = array();

    $header = NULL;
    if (($handle = fopen($filename, 'r')) !== FALSE)
	{
		while (($row = fgetcsv($handle, 1000, ';')) !== FALSE)
		{
			if(!$header)
				$header = $row;
			else{
                $sql = "INSERT INTO `CITY` (`CITY_NAME`, `CITY_ID`, `DISTRICT_ID`) VALUES
                ('".$row[0]."','". $row[1]."','".$row[2]."')";
                mysqli_multi_query($conn,$sql);
                array_push($cityNames,$row[0]);
                //echo $row[1]."\n";
			}
			$i++;
		}
		fclose($handle);
	}
   // print_r($cityNames);
   // echo "Insertion of Cities has finished!";
   // echo("Error description: " . mysqli_error($conn) );
    mysqli_close($conn);
    //////////////////////////////////////////////////////////////////////////////////////////////////

    //////////INSERT PRODUCTS////////////////////////////////////////////////////////////////////////
    
    $row = 0;
	$i = -1;
    $filename = "csv/Products.csv";

    if(!file_exists($filename) || !is_readable($filename))
    return FALSE;
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $header = NULL;
    if (($handle = fopen($filename, 'r')) !== FALSE)
	{
		while (($row = fgetcsv($handle, 2000, ';')) !== FALSE)
		{
                $price = rand(1,100);
                $sql = "INSERT INTO `PRODUCT` (`product_name`,`product_price`) VALUES
                ('".$row[0]."','".$price." TL')";
                mysqli_multi_query($conn,$sql);
                //echo $row[0]."\n";
            
            $i++;
            
		}
		fclose($handle);
	}
    
   // echo "Insertion of products has finished!";
   // echo("Error description: " . mysqli_error($conn) );
    mysqli_close($conn);
    //////////////////////////////////////////////////////////////////////////////////////////////////

    ///////////////////////////////INSERT MARKETS/////////////////////////////////////////////////////

    $row = 0;
	$i = -1;
    $filename = "csv/MarketNames.csv";

    if(!file_exists($filename) || !is_readable($filename))
    return FALSE;
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $marketNames = array();

    $header = NULL;
    if (($handle = fopen($filename, 'r')) !== FALSE)
	{
		while (($row = fgetcsv($handle, 2000, ';')) !== FALSE)
		{
            if(!$header)
                $header = $row;
            else{
                array_push($marketNames,$row[1]);
               // echo $row[1]."\n";
            }
            $i++;
            
		}
        fclose($handle);
        //print_r($marketNames);
	}   
    $marketID = -4;
    for($i = 0; $i < sizeof($cityNames)+1;$i++){
        
        $marketIndex = 0;
        $currentInCity = array();
        while($marketIndex != 5){
            
            $selectedItem = 0;
            do{
                $selectedItem = rand(0,9);
               // echo $selectedItem;
            }while( in_array($selectedItem,$currentInCity) !== false);

            $sql = "INSERT INTO `MARKET` (`market_id`, `market_name`, `city_id`) VALUES
            ('".$marketID."','". $marketNames[$selectedItem]."','".$i."')";
            mysqli_multi_query($conn,$sql);
            $marketIndex +=1;
            $marketID += 1;
            array_push($currentInCity,$selectedItem);
        }
    }
   // echo "Insertion of markets has finished!";
   // echo("Error description: " . mysqli_error($conn) );

    mysqli_close($conn);
    //////////////////////////////////////////////////////////////////////////////////////////////////

    //////////////////INSERT CUSTOMERS///////////////////////////////////////////////////////////////

    $row = 0;
	$i = -1;
    $filename = "csv/Names.csv";
    $filename2 = "csv/Surnames.csv";

    if(!file_exists($filename) || !is_readable($filename))
        return FALSE;
    if(!file_exists($filename2) || !is_readable($filename2))
        return FALSE;
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $HumanNames = array();
    $HumanSurnames = array();


    if (($handle = fopen($filename, 'r')) !== FALSE)
	{
		while (($row = fgetcsv($handle, 2000, ';')) !== FALSE)
		{

            array_push($HumanNames,$row[0]);
            //echo $row[0]."\n";

            $i++;
            
		}
        fclose($handle);
        //print_r($HumanNames);
	}   

    if (($handle = fopen($filename2, 'r')) !== FALSE)
	{
		while (($row = fgetcsv($handle, 2000, ';')) !== FALSE)
		{

            array_push($HumanSurnames,$row[0]);
            //echo $row[0]."\n";

            $i++;
            
		}
        fclose($handle);
        //print_r($HumanSurnames);
	} 

    $CUSTOMER_NAME_LIMIT = 1650;
    $currentFullNames = array();
    for($i = 0; $i < $CUSTOMER_NAME_LIMIT+1;$i++){
        
        do{
            $selectedName = $HumanNames[rand(0,499)];
            $selectedSurname = $HumanSurnames[rand(0,499)];

            $newfullName = $selectedName." ".$selectedSurname;

            //echo $newfullName;
        }while( in_array($newfullName,$currentFullNames) !== false);

        array_push($currentFullNames,$newfullName);


        $sql = "INSERT INTO `CUSTOMER` (`customer_id`, `customer_name`) VALUES
        ('".$i."','". $newfullName."')";
        mysqli_multi_query($conn,$sql);


    }
   // echo "Insertion of customers has finished!";
    //echo("Error description: " . mysqli_error($conn) );

    mysqli_close($conn);


    /////////////////////////////////////////////////////////////////////////////////////////////////


    /////////////////INSERT SALESMANS////////////////////////////////////////////////////////////////
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $SALESMAN_NAME_LIMIT = 1215;

    $MARKET_AMOUNT = 405;

    $currentFullNames = array();



    $currentMarketID = 1;
    $flag = 0;
    for($i = 0; $i < $SALESMAN_NAME_LIMIT+1;$i++){
        
        do{
            $selectedName = $HumanNames[rand(0,499)];
            $selectedSurname = $HumanSurnames[rand(0,499)];

            $newfullName = $selectedName." ".$selectedSurname;

            //echo $newfullName;
        }while( in_array($newfullName,$currentFullNames) !== false);

        array_push($currentFullNames,$newfullName);
        
        $sql = "INSERT INTO `SALESMAN` (`salesman_id`, `salesman_name`,`market_id`) VALUES
        ('".$i."','". $newfullName."','".$currentMarketID."')";
        mysqli_multi_query($conn,$sql);
        $flag += 1;
        if($flag == 3){
            $flag = 0;
            $currentMarketID += 1;
        }

    }
    //echo "Insertion of salesmans has finished!";
    //echo("Error description: " . mysqli_error($conn) );

    mysqli_close($conn);

    /////////////////////////////////////////////////////////////////////////////////////////////////

    ////////////////////////////////INSERT SALES//////////////////////////////

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $currentCustomerID = 1;
    $salesID = 1;
    for($i = 0; $i < $CUSTOMER_NAME_LIMIT+1;$i++){
        $selectedProductID = rand(1,200);
        $selectedSalesman = rand(1,1215);

        $start = strtotime("1999-12-12");
 
        //End point of our date range.
        $end = strtotime("2019-12-12");
         
        //Custom range.
        $timestamp = rand($start, $end);


        //Format that timestamp into a readable date string.
        $randomDate = date("y-m-d", $timestamp);
        $selectedCust = $i +1;
        $sql = "INSERT INTO `SALE` (`sale_id`, `product_id`,`customer_id`,`salesman_id`,`sale_date`) VALUES
        ('".$salesID."','". $selectedProductID."','".$selectedCust."','".$selectedSalesman."','".$randomDate."')";
        mysqli_multi_query($conn,$sql);

        $salesID += 1;
        for($j = 0; $j < 4;$j++){
            //60% chance to create a sale
            if(rand(0,100) < 40){
                continue;
            }
            $selectedProductID = rand(1,200);
            $selectedSalesman = rand(1,1215);
            
            $start = strtotime("1999-12-12");
 
            //End point of our date range.
            $end = strtotime("2019-12-12");
             
            //Custom range.
            $timestamp = rand($start, $end);


            //Format that timestamp into a readable date string.
            $randomDate = date("y-m-d", $timestamp);

            //echo "\$randomday: $randomday\n";

            //$finalDate = date("Y-m-d", $datestart + ($randomday * $daystep));
          //  echo $randomDate;

            $sql = "INSERT INTO `SALE` (`sale_id`, `product_id`,`customer_id`,`salesman_id`,`sale_date`) VALUES
            ('".$salesID."','". $selectedProductID."','".$i."','".$selectedSalesman."','".$randomDate."')";
            mysqli_multi_query($conn,$sql);
            $salesID += 1;
        }

        

    }

    //echo("Error description: " . mysqli_error($conn) );

    mysqli_close($conn);
    ///////////////////////////////////////////////////////////////////////////

    ///////////BUTTONS ///////////////////////////////////////////
    echo "<form action='ShowSelectCities.php' method='post'>";
    echo '<input type="submit" value="A">';
    echo "</form>";

    echo "<form action='ShowSelectMarket.php' method='post'>";
    echo '<input type="submit" value="B">';
    echo "</form>";

    echo "<form action='ShowPieCharts.php' method='post'>";
    echo '<input type="submit" value="C">';
    echo "</form>";

    ///////////////////////////////////////////////////////////


   

    // mysqli_close($conn);

    // $conn = mysqli_connect($servername, $username, $password, $dbname);
    // $sql = "select * from DISTRICT";
    // $result = mysqli_query($conn,$sql) or die("11");

    // if (mysqli_num_rows($result) > 0) {
    //     // output data of each row
    //     echo "<table border='1'>";
    //     echo "<tr><td>DISTRICT NAME</td></tr>";
    //     while($row = mysqli_fetch_array($result)) {
    //         echo "<tr>";
    //         echo "<td>" . $row["district_name"]. "</td>";
    //         echo "</tr>";
    //     }
    //     echo "</table>";
    // } else {
    //     echo "0 results";
    // }




?>