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
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			echo "<GPIO>\n";
			foreach($data as $row){
				echo "\t<pin>\n";
				echo "\t\t<pinID>".$row['pinID']."</pinID>\n";
				echo "\t\t<pinNumber>".$row['pinNumber']."</pinNumber>\n";
				echo "\t\t<device>".$row['device']."</device>\n";
				echo "\t\t<pinName>".$row['pinName']."</pinName>\n";
				echo "\t\t<status>".$row['status']."</status>\n";
				echo "\t</pin>\n\n";
			}
			echo "</GPIO>\n";
		}
		else if($mode == "j"){
				//in json format
			foreach($data as $row){
				echo "{";
				echo "\"pinID\": \"".$row['pinID']."\", ";
				echo "\"pinNumber\": ".$row['pinNumber'].", ";
				echo "\"device\": \"".$row['device']."\", ";
				echo "\"pinName\": \"".$row['pinName']."\", ";
				echo "\"status\": ".$row['status']."}\n";
			}
		}
		else if($mode == "c"){
				//in csv format
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