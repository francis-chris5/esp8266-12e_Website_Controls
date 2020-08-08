<?php
    require_once("connectionDetails.php");

		/*
		 * Requires at least two values to update database
		 * EXAMPLE_URL: domain/rx_sensor.php?pinID=A0&status=good
		 */

	if(isset($_REQUEST['pinID']) && isset($_REQUEST['status'])){
		$query = "UPDATE sensorData SET status = '".$_REQUEST['status']."' WHERE pinID = '".$_REQUEST['pinID']."';";
	}
	else if(isset($_REQUEST['pinNumber']) && isset($_REQUEST['status'])){
		$query = "UPDATE sensorData SET status = '".$_REQUEST['status']."' WHERE pinNumber = '".$_REQUEST['pinNumber']."';";
	}
	else if(isset($_REQUEST['sensor']) && isset($_REQUEST['status'])){
		$query = "UPDATE sensorData SET status = '".$_REQUEST['status']."' WHERE sensor = '".$_REQUEST['sensor']."';";
	}
	else if(isset($_REQUEST['pinName']) && isset($_REQUEST['status'])){
		$query = "UPDATE sensorData SET status = '".$_REQUEST['status']."' WHERE pinName = '".$_REQUEST['pinName']."';";
	}
	else{
		$query = "";
	}
    

    try{
        $conn = new PDO("mysql:host=$DBHost;dbname=$DBName", $DBUsername, $DBPassword);
        
		
		$select = $conn->prepare($query);
        $select->execute();
        $data = $select->fetchAll(PDO::FETCH_ASSOC);
		
		echo "success";

       $conn = null;
    }
    catch(PDOException $e){
        echo "failure";
    }
?>