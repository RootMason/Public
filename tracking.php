
<?php
	//Sets ERROR REPORTING to Level0 (OFF)
	error_reporting(0);
	//Links 
	require('connect.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
    <?php 
        //Define our GET variables with easy names
        $provider = $_GET[provider]; 
        $person = $_GET[person]; 

        //A QUERY to the Table: shipping_providers, so we can show the name of the provider, not just the number
        $providerNameQuery = mysqli_query($connection, "SELECT name FROM shipping_names WHERE id = $provider");
        $providerName = "";

        while($row = mysqli_fetch_assoc($providerNameQuery)) {
            $providerName = $row[name];
        }
    ?>
	<head>
        <meta http-equiv="Content-Type" content="text/html">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Steve Clark">
	
		<title>Shipping Tracker</title>
		
        <!-- CSS -->
            <!-- Bootstrap Core CSS -->
            <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/paper/bootstrap.min.css">
            <!-- Font Awesome Icons -->
            <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
            <!-- tracking_css/style.css -->	
            <link rel="stylesheet" type="text/css" href="tracking_css/style.css">
        <!-- End CSS -->

        <!-- JS -->
            <!-- Core JQuery -->
            <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
            <!-- Core Bootstrap JS -->
            <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
            <!-- This is an add-in so students HAVE to press the SUBMIT key rather than just hitting ENTER or AUTO-SUBMITTING -->
            <script type="text/javascript">
                function stopRKey(evt) {
                  var evt = (evt) ? evt : ((event) ? event : null);
                  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
                  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
                }
                document.onkeypress = stopRKey;
            </script> 
		
			<script type="text/javascript">
				function dynInput(cbox) {
					var x = document.getElementById("check_popout").checked;
					
					if (x === true && cbox.checked) {
						var input = document.createElement("input");
						var palletLabel = document.createElement("label");
						palletLabel.innerHTML = "<b>#Pallets:&nbsp&nbsp</b>";
						palletLabel.id = "palletsLabel";
						input.type = "text";
						input.id = "pallets";
						input.name = "palletsName";
						input.innerHTML = "#Pallets";
						var input2 = document.createElement("input");
						var boxesLabel = document.createElement("label");
						boxesLabel.id = "boxesLabel";
						boxesLabel.innerHTML = "<b>#Boxes:&nbsp&nbsp</b>";
						input2.type = "text";
						input2.id = "boxes";
						input2.name = "boxesName";
						input2.innerHTML = "#Boxes";
						var breakLine = document.createElement("br");
						breakLine.id = "breakLine";
					
						document.getElementById("insertInputs").appendChild(palletLabel);
						document.getElementById("insertInputs").appendChild(input);
						document.getElementById("insertInputs").appendChild(breakLine);
						document.getElementById("insertInputs").appendChild(boxesLabel);
						document.getElementById("insertInputs").appendChild(input2);
                        console.log(x);
					} else if (x === false) {
                        if (isIE === true || isIE11 === true) {
                            $('#pallets').remove();
                            $('#palletsLabel').remove();
                            $('#boxes').remove();
                            $('#boxesLabel').remove();
                            $('#breakLine').remove();
                        } else {
                            document.getElementById("pallets").remove();
                            document.getElementById("palletsLabel").remove();
                            document.getElementById("boxes").remove();
                            document.getElementById("boxesLabel").remove();
                            document.getElementById("breakLine").remove();
                            console.log(x);
                        }
					}
				}
                
                var isIE = (navigator.userAgent.indexOf("MSIE") != -1);
                console.log('isIE10orLower: ' + isIE);
				var isIE11 = (!(window.ActiveXObject) && "ActiveXObject" in window)
                console.log('isIE11: ' + isIE11);
				
			</script>
        
        <!-- End JS -->
    </head>

	<body onLoad="uncheck()">
		<div class="container">
            
            <!-- Fixed navbar -->
            <nav class="navbar navbar-default navbar-fixed-top">
              <div class="container">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded="false" aria-controls="navbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand blue" href="index.php">Shipping Tracker</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Select Shipping Provider</a></li>
                        <li class="active"><a href="#">Shipping Tracker - <?php echo $providerName; ?></a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                         <li><a href="https://www.bookstore.arizona.edu/shipping_query/date.html">Database Query</a></li>
                         <li><a href="https://www.bookstore.arizona.edu/apps">BookStore Apps</a></li>
                        <li><a class="red" target="_blank" href="http://150.135.85.7/MIS/Lists/Support%202/new.aspx?Source=http://bknet/support">Contact MIS</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
              </div>
            </nav>
            
            <div id="mainPanel" class="col-md-6 col-md-offset-3 noPadding">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h5 class="panel-title noMargin"><?php echo $providerName; ?></h5>
                    </div>

                    <div class="panel-body">
                        
                        <!-- This span 'message' contains nothing until the form is submitted. When the form is submitted, AJAX is used to add a success or 
                        alert div                                                                                                                      -->
                        <span id="message" style="display:none;"> 

                        </span>
                        
                        <?php echo "<form id=\"shipmentTrackerEnter\" action=\"insert.php?provider=$provider\">"; ?>
                        
                            <!-- Tracking Number -->
                            <div id="trackingNumber" class="form-group">
                                <input id="trackingNumberInput" type="text" name="tracking_no" class="form-control" id="inputEmail" placeholder="Tracking Number" autofocus>
                            </div>
                        
                            <!-- Initials -->
                            <div id="userInitials" class="form-group">
                                <input type="text" value="<?php echo $person; ?>" name="person_name" class="form-control" maxlength="2" onblur="this.value=this.value.toUpperCase()" placeholder="Initials">
                            </div>
						
							<!-- Checkbox Popout -->
							<div id="checkboxPopout" class="form-group">
								<input type="checkbox" id="check_popout" onclick="dynInput(this);"><b>&nbsp;&nbsp;Pallets?</b>
								<p id="insertInputs"></p>
							</div>

							<!-- Submit -->
                            <button id="submit" class="btn btn-md btn-default col-xs-6 col-xs-offset-3" type="submit" name="submit">Enter</button>
                        </form></br>
                        
                        <!-- Daily Totals Toggle -->
<!--
                        <button id="dailyTotalsToggle" type="button" class="btn btn-lg btn-default" data-toggle="collapse" data-target="#dailyTotalsTable"><?php echo $providerName; ?> Daily Totals</button></br></br>
                        <div id="dailyTotalsTable" class="collapse">
-->
                            <table id="totalsTable" class="table table-striped table-hover">
                                <caption><?php echo $providerName; ?> Daily Totals</caption>
                                <thead>
                                    <tr>
                                        <th>Provider</th>
                                        <th>Date Issued</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
									//Query to SQL for Shipping Totals
									//COUNT(DISTINCT) will COUNT only unique numbers within the string [duplicates'll be tossed) & name as Total
									//The Query will only return items that equal the Provider# ($provider) from the current date [CURDATE()]
                                    $query = "SELECT shipping_provider, date_issued, COUNT(DISTINCT tracking_no) Total FROM tracking_numbers 
                                    WHERE shipping_provider = $provider && date_issued = CURDATE(); ";

                                    $result = mysqli_query($connection, $query);
                                    while($row = mysqli_fetch_assoc($result)) {

                                      echo "<tr>";
                                        echo "<td> " . $providerName . " </td>";
                                        echo "<td> " . $row[date_issued] . " </td>";
                                        echo "<td id=\"providerTotal\"> " . $row[Total] . " </td>";
                                      echo "</tr>";
                                    }
                                ?>
                                </tbody>
                            </table>
                        <!--</div>-->
                        
                        <!-- Back to Select A Provider -->
                        <a href="index.php"><button class="btn btn-lg btn-primary"><span class="fa fa-arrow-left" aria-hidden="true"></button></a>
                    </div>
                </div>
            </div>
					
<!--
			<table style="width:100%">
				<tr>
					<td><text>Tracking Number: </text></td>
					<td><input type="text" name="tracking_no" align="center" style="text-align: center; font-size: 40px; font-weight: bold; height: 80px; width: 700px;" /></td>
				</tr>
				<tr>
					<td><text>Enter Initials (ie. SC): </text></td>
					<td><input type="text" onblur="this.value=this.value.toUpperCase()" name="person_name" align="center" style="text-align: center; font-size: 40px; font-weight: bold; height: 80px; width: 700px;" /></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td><a href="<?php echo "query.php?provider=$provider\" method=\"post\"" ?>" class="button" style="font-size: 36px; height: 55px; color: black;">Check Daily Totals</a></td>
				</tr>
				<tr>
					<td></td>
					<td><a href="index.php" class="button" style="font-size: 36px; height: 55px; color: black;">Select A Provider</a></td>
				</tr>
			</table>
-->
			
			<!-- Debugging for the GET variable -->
			<?php //print_r($_GET); echo $provider; ?>
			
        </div>
		
	</body>
    
    <script>
		
		//function uncheck() {
			// Uncheck all checkboxes on page load    
		//	$(':checkbox:checked').removeAttr('checked');
		//}
        
        $(document).ready(function () {
			  $(".navbar-toggle").on("click", function () {
				    $(this).toggleClass("active");
			  });
		});
        
        //Submits from with AJAX so that the page does not refresh
		$(function () {

			$('#shipmentTrackerEnter').on('submit', function (e) {

				e.preventDefault();
                
				
				$.ajax({
					type: 'post',
					url: 'insert.php?provider=<?php echo $provider ?>',
					data: $('#shipmentTrackerEnter').serialize(),
					dataType: 'json',
					
					success: function (data) { 
                        
                        var success = data.msg;
                        
                        if(success == "error1"){
                            alert('Your Tracking# does meet length requirements');
                        } 
                         
                        $('#trackingNumber').addClass(data.trackingNumberColor);
                        $('#userInitials').addClass(data.initialsColor);
                        
                        setTimeout("$('#trackingNumber').removeClass('" + data.trackingNumberColor + "');", 1000);
                        setTimeout("$('#userInitials').removeClass('" + data.initialsColor + "');", 1000);
                        
						if (success.indexOf("Success") > -1) {
                            $('#providerTotal').load(document.URL +  ' #providerTotal');
                            $('#trackingNumberInput').val('').focus();
						}
            
					}
					
				});
			});
		});
    </script>

</html>