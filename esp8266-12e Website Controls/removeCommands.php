<?php
    require_once("connectionDetails.php");

    $command = $_REQUEST['command'];

    try{
        $conn = new PDO("mysql:host=$DBHost;dbname=$DBName", $DBUsername, $DBPassword);
        
		$query = "DELETE FROM textControl WHERE status=\"SENT\";";
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