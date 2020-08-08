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
		$mode = "k"; 
	}
	
	

    try{
        $conn = new PDO("mysql:host=$DBHost;dbname=$DBName", $DBUsername, $DBPassword);
        $select = $conn->prepare("SELECT * FROM textControl WHERE 1");
        $select->execute();
        $data = $select->fetchAll(PDO::FETCH_ASSOC);
		
		
		if($mode == "x"){
			//in xml format
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			echo "<instructions>\n";
			foreach($data as $row){
				echo "\t<com>\n";
				echo "\t\t<comID>".$row['comID']."</comID>\n";
				echo "\t\t<command>".$row['command']."</command>\n";
				echo "\t\t<status>".$row['status']."</status>\n";
				echo "\t</com>\n\n";
			}
			echo "</instructions>\n";
		}
		else if($mode == "j"){
				//in json format
			foreach($data as $row){
				echo "{";
				echo "\"comID\": ".$row['comID'].", ";
				echo "\"command\": \"".$row['command']."\", ";
				echo "\"status\": \"".$row['status']."\"}\n";
			}
		}
		else if($mode == "c"){
							//in csv format
			echo "comID,command,status\n";
			foreach($data as $row){
				echo $row['comID'].",".$row['command'].",".$row['status']."\n";
			}
		}
		else if($mode == "k"){
			foreach($data as $row){
				echo "[".$row['command'].",".$row['status']."]";
			}
			echo "\n";
		}
		
		$update = $conn->prepare("UPDATE textControl SET status = \"SENT\" WHERE 1");
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