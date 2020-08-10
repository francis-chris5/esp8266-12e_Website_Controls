<?php
    require_once("connectionDetails.php");
	
	if(isset($_REQUEST['state'])){
		$state = $_REQUEST['state'];
	}
	else{
		$state = "";
	}
	if(isset($_REQUEST['pin'])){
		$pin = $_REQUEST['pin'];
	}
	else{
		$pin = "";
	}

    $query = "UPDATE booleanControl SET status = ".$state." WHERE pinNumber = ".$pin;

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