<?php
    require_once("connectionDetails.php");
	
		/*
		 * MODE:
		 * x = xml, j = json, c = csv, k = custom
		 * default to xml (rss feed)
		 */
	if(isset($_REQUEST['mode']) && ($_REQUEST['mode'] == "x" || $_REQUEST['mode'] == "j" || $_REQUEST['mode'] == "c" || $_REQUEST['mode'] == "k")){
		$mode =  $_REQUEST['mode'];
	}
	else{
		$mode = "x"; 
	}

    try{
        $conn = new PDO("mysql:host=$DBHost;dbname=$DBName", $DBUsername, $DBPassword);
        $select = $conn->prepare("SELECT * FROM booleanControl WHERE 1");
        $select->execute();
        $data = $select->fetchAll(PDO::FETCH_ASSOC);
		
		if($mode == "x"){
				//in xml format
			$xml = new DOMDocument("1.0", "UTF-8");
			$root = $xml->createElement("GPIO");
			$root = $xml->appendChild($root);
			foreach ($data as $row){
				$pin = $xml->createElement("pin");
				$pin = $root->appendChild($pin);
				$pin->appendChild($xml->createElement("pinID", $row['pinID']));
				$pin->appendChild($xml->createElement("pinNumber", $row['pinNumber']));
				$pin->appendChild($xml->createElement("device", $row['device']));
				$pin->appendChild($xml->createElement("pinName", $row['pinName']));
				$pin->appendChild($xml->createElement("status", $row['status']));
			}
			header("Content-type: text/xml; charset=utf-8");
			echo $xml->saveXML();
		}
		else if($mode == "j"){
				//in json format
			foreach($data as $row){
				echo json_encode(array("pinID"=>$row['pinID'], "pinNumber"=>$row['pinNumber'], "device"=>$row['device'], "pinName"=>$row['pinName'], "state"=>$row['status']));
				if(next($data)){
					echo "\n";
				}
			}
		}
		else if($mode == "c"){
				//in csv format (NOT A .csv file -a string formated to create file or associative array)
			echo "pinID,pinNumber,device,pinName,status\n";
			foreach($data as $row){
				echo $row['pinID'].",".$row['pinNumber'].",".$row['device'].",".$row['pinName'].",".$row['status']."\n";
			}
		}
		else if($mode == "k"){
				//just the status, split string on commas into an array
			foreach($data as $row){
				if(next($data)){
					echo $row['status'].",";
				}
				else{
					echo $row['status'];
				}
			}
		}
		
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