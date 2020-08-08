<?php
    require_once("connectionDetails.php");

    $command = $_REQUEST['command'];

    try{
        $conn = new PDO("mysql:host=$DBHost;dbname=$DBName", $DBUsername, $DBPassword);
        
		$query = "INSERT INTO textControl(command, status) VALUES(\"".$command."\", \"HOLD\");";
		$update = $conn->prepare($query);
        $update->execute();
        $comData = $update->fetchAll(PDO::FETCH_ASSOC);

		echo "success";

       $conn = null;
    }
    catch(PDOException $e){
        echo "failure";
    }
?>