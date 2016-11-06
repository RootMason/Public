
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
	<head>
        <meta http-equiv="Content-Type" content="text/html">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Steve Clark">
        
		<title>Shipping Provider</title>
		
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
        <!-- End JS -->
    </head>

    <body>
	
	<!-- <?php // $link_name = "Second Page."; $id = 1; ?>
	<a href="index2.php?id=<?php //echo $id; ?>"><?php //echo $link_name; ?></a> 
	-->
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
                        <a class="navbar-brand blue" href="https://www.bookstore.arizona.edu/shipping/">Shipping Tracker</a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="#">Select Shipping Provider</a></li>
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
                        <h5 class="panel-title noMargin">Select a Shipping Provider</h5>
                    </div>

                    <div class="panel-body">
                        <form name="shipping_provider" method="GET" action="tracking.php" id="form.center">
                            <div class="form-group">
                                <select name="provider" class="form-control" tabindex="1">
                                    <option value="1">UPS</option>
                                    <option value="2">UPS Freight</option>
                                    <option value="3">FedEx</option>
                                    <option value="4">FedEx Freight</option>
                                    <option value="5">FedEx Express</option>
                                    <!-- <option value="6">Roadway</option> -->
                                    <option value="7">YRC</option>
                                    <!-- <option value="8">Yellow</option> -->
                                    <option value="9">Ingram</option>
                                    <option value="10">OnTrack</option>
                                    <!-- <option value="11">Reddeway</option> -->
                                    <!-- <option value="12">Roadrunner</option> -->
                                    <option value="13">ULine</option>
                                    <option value="14">DATS</option>
                                    <!-- <option value="15">Estes</option> -->
                                    <!-- <option value="16">USPS</option> -->
									<option value="18">DHL</option>
                                    <option value="17">Other</option>
                                </select>
                            </div>

                            <button class="btn btn-lg btn-primary" type="submit" name="submit" style="float:right;"><i class="fa fa-arrow-right"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
	
    <script>
        $(document).ready(function () {
			  $(".navbar-toggle").on("click", function () {
				    $(this).toggleClass("active");
			  });
		});
    </script>
</html>
	