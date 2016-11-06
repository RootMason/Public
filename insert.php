<?php
class ajaxValidate {
	
	function formValidate() {

		include '/connect.php';
		
		// Validate the submission =====================================================		
			
				$pallets = "";
				$boxes = "";
		
				$trackingNumber     =		$_POST['tracking_no'];
				$initials			=		$_POST['person_name'];
                $provider           =       $_GET['provider'];
				
				if(isset($_POST['palletsName']) && !empty($_POST['palletsName'])) {
					$pallets		=		$_POST['palletsName'];	
				}
				if(isset($_POST['boxesName']) && !empty($_POST['boxesName'])) {
					$boxes			=		$_POST['boxesName'];	
				}

				
		$return	=	array();	        //Declare the array for what will be returned
		$return['msg'] 		= '';		//Declare the msg to be returned as nothing
		$errorMessage = "";

		
		
		if (!isset($trackingNumber) || empty($trackingNumber)) {
			$errorMessage .= "Tracking Number";
            $return['trackingNumberColor'] = "has-error";
		}	
				
		if (!isset($initials) || empty($initials)) {
			$errorMessage .= "Initials";
            $return['initialsColor'] = "has-error";
		}
							
		if(!empty($errorMessage)) {
			$return['msg'] =	"error";
		}
        
        //Length Checking**************************************************************************
        if (empty($errorMessage)){
            if ((strlen($trackingNumber) < 9 || strlen($trackingNumber) > 18) && $provider == 1) {
                $errorMessage .= "TrackingNo";
                $return['trackingNoColor'] = "has-error";
            }
            
            if ((strlen($trackingNumber) < 9 || strlen($trackingNumber) > 10) && $provider == 2) {
                $errorMessage .= "TrackingNo";
                $return['trackingNoColor'] = "has-error";
            }
            
            if ((strlen($trackingNumber) < 22 || strlen($trackingNumber) > 34) && $provider == 3) {
                $errorMessage .= "TrackingNo";
                $return['trackingNoColor'] = "has-error";
            }
            
            if ((strlen($trackingNumber) < 10 || strlen($trackingNumber) > 32) && $provider == 4) {
                $errorMessage .= "TrackingNo";
                $return['trackingNoColor'] = "has-error";
            }
            
            if ((strlen($trackingNumber) < 12 || strlen($trackingNumber) > 34) && $provider == 5) {
                $errorMessage .= "TrackingNo";
                $return['trackingNoColor'] = "has-error";
            }
            
            if ((strlen($trackingNumber) < 7 || strlen($trackingNumber) > 11) && $provider == 6) {
                $errorMessage .= "TrackingNo";
                $return['trackingNoColor'] = "has-error";
            }
            
            if ((strlen($trackingNumber) < 7 || strlen($trackingNumber) > 34) && $provider == 7) {
                $errorMessage .= "TrackingNo";
                $return['trackingNoColor'] = "has-error";
            }
            
            if ((strlen($trackingNumber) < 10 || strlen($trackingNumber) > 22 || strlen($trackingNumber) !== 34) && $provider == 8) {
                $errorMessage .= "TrackingNo";
                $return['trackingNoColor'] = "has-error";
            }
            
            if ((strlen($trackingNumber) < 13 || strlen($trackingNumber) > 20) && $provider == 9) {
                $errorMessage .= "TrackingNo";
                $return['trackingNoColor'] = "has-error";
            }
            
            if ((strlen($trackingNumber) < 15 || strlen($trackingNumber) > 20) && $provider == 10) {
                $errorMessage .= "TrackingNo";
                $return['trackingNoColor'] = "has-error";
            }
            
            if ((strlen($trackingNumber) < 9 || strlen($trackingNumber) > 10) && $provider == 11) {
                $errorMessage .= "TrackingNo";
                $return['trackingNoColor'] = "has-error";
            }
            
            if ((strlen($trackingNumber) < 8 || strlen($trackingNumber) > 10) && $provider == 12) {
                $errorMessage .= "TrackingNo";
                $return['trackingNoColor'] = "has-error";
            }
            
            if ((strlen($trackingNumber) < 9 || strlen($trackingNumber) > 15) && $provider == 13) {
                $errorMessage .= "TrackingNo";
                $return['trackingNoColor'] = "has-error";
            }
            
            if (strlen($trackingNumber) !== 9 && $provider == 14) {
                $errorMessage .= "TrackingNo";
                $return['trackingNoColor'] = "has-error";
            }
                
            if ((strlen($trackingNumber) < 10 || strlen($trackingNumber) > 34) && $provider == 15) {
                $errorMessage .= "TrackingNo";
                $return['trackingNoColor'] = "has-error";
            }
                
            if ((strlen($trackingNumber) !== 22 || strlen($trackingNumber) !== 30 || strlen($trackingNumber) !== 34) && $provider == 16) {
                $errorMessage .= "TrackingNo";
                $return['trackingNoColor'] = "has-error";
            }
                
            if ((strlen($trackingNumber) !== 10 || strlen($trackingNumber) !== 20) && $provider == 18) {
                $errorMessage .= "TrackingNo";
                $return['trackingNoColor'] = "has-error";
            }

            if(!empty($errorMessage)) {
                $return['msg'] =	"error1";
            } 
        }
		//End length checking**********************************************************************
            
	// Proceed with submission process if fields are not blank
		if (empty($errorMessage)){	
			if (!empty($pallets && $boxes)) {
				$query = "INSERT INTO tracking_numbers (shipping_provider,date_issued,time_issued,tracking_no,person_name,pallet_no,box_no) VALUES ('$_GET[provider]',NOW(),NOW(),'$trackingNumber','$_POST[person_name]','$pallets','$boxes')";
				$result = mysqli_query($connection, $query);
				$return['msg'] =  	"Success";
				$return['trackingNumberColor'] = "has-success";
				$return['initialsColor'] = "has-success";
			} elseif(empty($pallets && $boxes)) {
				$query = "INSERT INTO tracking_numbers (shipping_provider,date_issued,time_issued,tracking_no,person_name) VALUES ('$_GET[provider]',NOW(),NOW(),'$trackingNumber','$_POST[person_name]')";
				$result = mysqli_query($connection, $query);
				$return['msg'] =  	"Success";
				$return['trackingNumberColor'] = "has-success";
				$return['initialsColor'] = "has-success";
			}
		}
		
		//Return the response back to the form page
		return json_encode($return);
	}
}

	$ajaxValidate = new ajaxValidate;
	echo $ajaxValidate->formValidate();
?>