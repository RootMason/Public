<?php
	error_reporting(0);
	//Create Database Connection
	require('connect.php');
	
	//Test if Connection occurred
	if(mysqli_connect_errno()) { 
		die("Database connection failed: " .
			mysqli_connect_error() .
			" (" . mysqli_connect_errno() . ")"
		);
	} else {
		//echo "Connection success to " . ucfirst($dbname);
	}
?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">

	<head>
		<title>Shipping Tracker</title>
		<link rel="stylesheet" type="text/css" href="tracking_css/style.css">
	</head>

	<body>
	
	<div align="center" id="parent">
	<pre>
	<?php
		$get_no = $_GET[provider];
		
		$query_shipper = "SELECT name from shipping_names WHERE id = $get_no";
		
		$query = "SELECT shipping_provider, date_issued, COUNT(DISTINCT tracking_no) Total FROM tracking_numbers 
		WHERE shipping_provider = $get_no && date_issued = CURDATE(); ";
		
		//echo $query;
		
		//$query = "SELECT * FROM tracking_numbers;";
		
		//$query = "SELECT DATE(date_issued) AS 'Date', "
		//. "COUNT(tracking_no) as 
		
			echo "<table border='1' style='font-size:36px' bgcolor='white'>
			<tr>
			<th>Shipping Provider</th>
			<th>Date Issued</th>
			<th>Total</th>

			</tr>";
		
		$result = mysqli_query($connection, $query);
		$result2 = mysqli_query($connection, $query_shipper);
		//print_r($result);
		
		$shipper = NULL;
		while($row = mysqli_fetch_assoc($result2)) {
			$shipper = $row[name];
		}
	
		while($row = mysqli_fetch_assoc($result)) {
		
		  echo "<tr>";
		  echo "<td> " . $shipper . " </td>";
		  echo "<td> " . $row[date_issued] . " </td>";
		  echo "<td> " . $row[Total] . " </td>";
		  echo "</tr>";
		}
		
		echo "</table>";

		//To debug, here's our Query String:</br> -->
		//echo $result . "</br>";
		//echo $query . "</br>";
		//print_r($result) . "</br>"; 
		//echo $get_no;

	?>
	
	</pre>
	</br>
	
	<!-- Button to go back & pick a Shipping Provider  -->
	<a class="button2" href="index.php?provider=<?php echo $_GET[provider]; ?>" role="button" style="font-size: 80px;" >CONTINUE</br></a>

	</div>
	</body>
	
	<!-- <a href="http://designshack.net/" class="button" style="font-size: 36px; height: 55px;">Check Daily Totals</a> -->

</html>


<?php
	//Close the Connection
	mysqli_close($connection);
?>