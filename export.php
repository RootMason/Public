<?php
    //Move to require $connection
    require('connect2.php');

    //Take our $_GET variables and make them name-friendly
    $provider = $_GET['provider'];
    $date1 = $_GET['date1'];
    $date2 = $_GET['date2'];
    $tracking_no = $_GET['tracking_no'];
    $person = $_GET['person'];
	$pallets = $_GET['pallets'];

    // Define Excel (.xls) file name... this is what it'll be called when it is saved.
    $xls_filename = 'export_'.date('Y-m-d').'.xls'; 

    //Open our variables
    $providerSelect = "";
    $date1Select = "";
    $daterangeSelect = "";
    $trackingSelect = "";
    $personSelect = "";
	$palletSelect = "";

	/**********************************************************************************************************
	//    START of MySQL Query
	***********************************************************************************************************/

    //Prepare a MySQL statement
    $sql = "SELECT tracking_numbers.id, shipping_names.name, tracking_numbers.date_issued, tracking_numbers.time_issued, tracking_numbers.tracking_no, tracking_numbers.person_name, tracking_numbers.pallet_no, tracking_numbers.box_no FROM tracking_numbers INNER JOIN shipping_names ON tracking_numbers.shipping_provider = shipping_names.id WHERE tracking_numbers.id >= 1 ";
    if (!empty($provider)) {
        $providerSelect .= "AND shipping_provider = $provider ";
        $sql .= $providerSelect;
    }
    //This is where we QUERY by either DATE($date1), or by DATERANGE($date1 & $date2)
    if (!empty($date1) && empty($date2)) {
        $date1Select .= "AND date_issued = '$date1' ";
        $sql .= $date1Select;
    } else {
        $daterangeSelect .= "AND date_issued >= '$date1' AND date_issued <= '$date2' ";   
    }

    if (!empty($tracking_no)) {
        $trackingSelect .= "AND tracking_no = $tracking_no ";
        $sql .= $trackingSelect;
    }

    if (!empty($person)) {
        $personSelect .= "AND person_name = '$person'";
        $sql .= $personSelect;
    }

	if (!empty($pallets)) {
		$palletSelect .= "AND pallet_no >= 1";
		$sql .= $palletSelect;
	}
    $sql .= ";";

    // Select database
    $Db = @mysql_select_db($DB_DBName, $Connect) or die("Failed to select database:<br />" . mysql_error(). "<br />" . mysql_errno());
    // Execute query
    $result = @mysql_query($sql,$Connect) or die("Failed to execute query:<br />" . mysql_error(). "<br />" . mysql_errno());
 
	/*********************************************************************************************
    //     END of MySQL Query
	**********************************************************************************************/

	/*********************************************************************************************
    //     START of Formatting for Excel
	**********************************************************************************************/

    // Header info settings
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=$xls_filename");
    header("Pragma: no-cache");
    header("Expires: 0");

    //Define our separators (defines columns in Excel & tabs in Word)
    $sep = "\t"; // tabbed character
 
    // Start of printing column header names as names of MySQL fields
    for ($i = 0; $i<mysql_num_fields($result); $i++) {
      echo mysql_field_name($result, $i) . "\t";
    }
    print("\n");
    // End of printing column header names

    // Start WHILE loop to get data
    while($row = mysql_fetch_row($result))
    {
      $schema_insert = "";
      for($j=0; $j<mysql_num_fields($result); $j++)
      {
        if(!isset($row[$j])) {
          $schema_insert .= "NULL".$sep;
        }
        elseif ($row[$j] != "") {
          $schema_insert .= "\"=\"\"$row[$j]\"\"\"".$sep;
        }
        else {
          $schema_insert .= "".$sep;
        }
      }
      $schema_insert = str_replace($sep."$", "", $schema_insert);
      $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
      $schema_insert .= "\t";
      print(trim($schema_insert));
      print "\n";
    }
 ?>