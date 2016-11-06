<?php
	//Sets ERROR REPORTING
	error_reporting(1);
	//Links to PHP FUNCTION that creates our connection to the database
	require('connect.php');

    //Take our $_GET variables and make them name-friendly
    $provider = $_GET[provider];
    $date1 = $_GET[date1];
    $date2 = $_GET[date2];
    $tracking_no = $_GET[tracking_no];
    $person = $_GET[person];
	$pallets = $_GET[pallet];

    //Query shipping_providers table so we can return Provider Names instead of just Numbers
    $providerNameQuery = mysqli_query($connection, "SELECT name FROM shipping_names WHERE id = $provider");
        $providerName = "";

        while($row = mysqli_fetch_assoc($providerNameQuery)) {
            $providerName = $row[name];
        }


    
?>

<!DOCTYPE html>
<html lang="en"><head>
    <link rel="icon" type="image/x-icon" href="http://desktop.thvcg.com/web2/favicon.ico"/>
    
	<meta http-equiv="Content-Type" content="text/html">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Steve Clark">

    <title>Shipping Query</title>

    <!-- CSS -->
		<!-- Bootstrap Core CSS (Bootswatch Flatly Theme)-->
		<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/flatly/bootstrap.min.css">
        <!-- DateTimePicker -->
		<link rel="stylesheet" type="text/css" media="screen" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.0.0/css/bootstrap-datetimepicker.min.css" />
		<!-- Font Awesome -->
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
		<!-- Fonts -->
		<link rel="stylesheet" type="text/css" href='http://fonts.googleapis.com/css?family=Roboto'>
		<!-- CSS/style.css -->
		<link rel="stylesheet" type="text/css" href="style.css">
	<!-- End CSS -->
	
	<!-- JS -->
		<!-- Core JQuery -->
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<!-- Core Bootstrap JS -->
		<script type="text/javascript" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <!-- DateTimePicker JS -->
		<script type="text/javascript" src="js/moment.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.0.0/js/bootstrap-datetimepicker.min.js"></script>
		<script type="text/javascript" src="js/locales/bootstrap-datetimepicker.ru.js"></script>
	<!-- End JS -->
	
	<!--<script>window["_GOOG_TRANS_EXT_VER"] = "1";</script>-->
    
    </head>

	<body>
      
        <?php
			/**********************************************************************************************
			// DEBUGGING; Make sure all the variables can be called back
            // ECHO back all the variables:
            // echo $provider."</br>".$date1."</br>".$date2."</br>".$tracking_no."</br>".$person."</br>";
			***********************************************************************************************/
        ?>

        <div class="container">
            <!-- Static navbar -->
            <div id="navbar" class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        
                    </div>
                    <div class="navbar-collapse collapse" style="height: 1px;">
                        <ul class="nav navbar-nav">
                            <li><a href="date.html"><i class="glyphicon glyphicon-search"></i> Database Query</a></li>
                            <li><a href="https://www.bookstore.arizona.edu/shipping/index.php"><i class="glyphicon glyphicon-search"></i> Shipping Tracker</a></li>
                        </ul>

                    </div><!--/.nav-collapse -->
                </div><!--/.container-fluid -->
            </div>
        </div>
        
        <!-- This is for "forwarding" our data to the EXPORT.PHP page -->
        <div align="center">
            <div style="display:inline-block;">
                <form id="Export" action="export.php" method="GET" >
                    <input type="hidden" name="provider" value="<?php echo $provider; ?>" />
                    <input type="hidden" name="date1" value="<?php echo $date1; ?>" />
                    <input type="hidden" name="date2" value="<?php echo $date2; ?>" />
                    <input type="hidden" name="tracking_no" value="<?php echo $tracking_no; ?>" />
                    <input type="hidden" name="person" value="<?php echo $person; ?>" />
                    <input type="hidden" name="pallets" value="<?php echo $pallets; ?>" />
                    <input class="btn btn-primary" type="submit" value="Export to Excel" />
                </form>
            </div>
        </div>
        
        <!--The table we will present our QUERIED info in-->
        <table id="totalsTable" class="table table-striped table-hover">
            
            <thead>
                <tr>
                    <!-- "th" is "Table Header" -->
                    <th>Provider</th>
                    <th>Date Issued</th>
                    <th>Time Issued</th>
                    <th>Tracking Number</th>
                    <th>Initials</th>
                    <th>#Pallets</th>
                    <th>#Boxes</th>
                </tr>
            </thead>
            <tbody>
            <pre>
            <?php

					/*******************************************************************************************************
				    // MySQL Query; IF statement used to exclude elements from our SELECT ($select1) statement
                    // $select1 is our base statement. IF any of the following are NOT EMPTY(!empty), APPEND to $select1
					// The initial WHERE clause in $select1 is so we ONLY APPEND "ANDs" to our QUERY($select1)
					// The logic here is pretty badass...
					********************************************************************************************************/
                    $select1 = "SELECT * FROM tracking_numbers WHERE id >= 1 ";
                    if (!empty($provider)) {
                        $providerSelect .= "AND shipping_provider = $provider ";
                        $select1 .= $providerSelect;
                    }
                    //This is where we query by either $date1, or by daterange ($date1 & $date2)
                    if (!empty($date1) && empty($date2)) {
                        $date1Select .= "AND date_issued = '$date1' ";
                        $select1 .= $date1Select;
                    } else {
                        $daterangeSelect .= "AND date_issued >= '$date1' AND date_issued <= '$date2' ";   
                    }
					//IF NOT EMPTY, APPEND $tracking_no
                    if (!empty($tracking_no)) {
                        $trackingSelect .= "AND tracking_no = $tracking_no ";
                        $select1 .= $trackingSelect;
                    }
					//IF NOT EMPTY, APPEND $person
                    if (!empty($person)) {
                        $personSelect .= "AND person_name = '$person'";
                        $select1 .= $personSelect;
                    }
					if (!empty($pallets)) {
						$palletSelect .= "AND pallet_no >= 1";
						$select1 .= $palletSelect;
					}
                $select1 .= ";";
		
				/**********************************************************************************
                //DEBUGGING; ECHO our appended $select1 variable and see if it looks correct
                //echo $select1;
				***********************************************************************************/

                //Initiate the $connection & our $select1 statement & put all that in $result
                $result = mysqli_query($connection, $select1);

                //WHILE Loop to echo back what $result has in it ($row by $row)
                while($row = mysqli_fetch_assoc($result)) {
                    
                    echo "<tr>";
                    if ($provider != 0) {
                        echo "<td> " . $providerName . " </td>";
                    } else {
                        $anyproviderNameQuery = mysqli_query($connection, "SELECT name FROM shipping_names WHERE id = $row[shipping_provider]");
                        $anyproviderName = "";

                        while($row1 = mysqli_fetch_assoc($anyproviderNameQuery)) {
                            $anyproviderName = $row1[name];
                        }
                        echo "<td> " . $anyproviderName . " </td>";   
                    }
                    echo "<td> " . $row[date_issued] . " </td>";
                    echo "<td> " . $row[time_issued] . " </td>";
                    echo "<td> " . $row[tracking_no] . " </td>";
                    echo "<td> " . $row[person_name] . " </td>";
                    echo "<td> " . $row[pallet_no] . " </td>";
                    echo "<td> " . $row[box_no] . " </td>";
                    echo "</tr>";
                }
                                    
            ?>
            </pre>
            </tbody>
        </table>
        
    </body>
</html>