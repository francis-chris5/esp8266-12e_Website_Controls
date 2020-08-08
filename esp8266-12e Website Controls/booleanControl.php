<?php
    require_once("connectionDetails.php");

    $query = $_REQUEST['query'];

    try{
        $conn = new PDO("mysql:host=$DBHost;dbname=$DBName", $DBUsername, $DBPassword);
        
		//$query = change the status for a particular pin in the database
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