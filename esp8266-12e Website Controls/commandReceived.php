<?php
	require_once("connectionDetails.php");

	if(isset($_REQUEST['comID'])){
		$comID = $_REQUEST['comID'];
	}
	else{
		$comID = "";
	}

	try{
        $conn = new PDO("mysql:host=$DBHost;dbname=$DBName", $DBUsername, $DBPassword);
		
		$update = $conn->prepare("UPDATE textControl SET status = \"SENT\" WHERE comID=".$comID);
		$update->execute();
		$result = $update->fetchAll(PDO::FETCH_ASSOC);
		
		$rand = rand(1, 99);
		$logTime = $conn->prepare("UPDATE lastAccess SET randomValue = ".$rand." WHERE accessID = 0");
		$logTime->execute();
		$timestamp = $logTime->fetchAll(PDO::FETCH_ASSOC);
		
        $conn = null;
    }
    catch(PDOException $e){
        echo "could not query database: ".$e->getMessage();
    }
?>