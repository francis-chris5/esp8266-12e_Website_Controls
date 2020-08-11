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
        $select = $conn->prepare("SELECT * FROM textControl WHERE comID = (SELECT MIN(comID) FROM textControl)");
        $select->execute();
        $data = $select->fetchAll(PDO::FETCH_ASSOC);
		
		
		if($mode == "x"){
				//in xml format
			$xml = new DOMDocument("1.0", "UTF-8");
			$root = $xml->createElement("instructions");
			$root = $xml->appendChild($root);
			foreach($data as $row){
				$com = $xml->createElement("com");
				$com = $root->appendChild($com);
				$com->appendChild($xml->createElement("comID", $row['comID']));
				$com->appendChild($xml->createElement("command", $row['command']));
				$com->appendChild($xml->createElement("status", $row['status']));
			}
			header("Content-type: text/xml; charset=utf-8");
			echo $xml->saveXML();
		}
		else if($mode == "j"){
				//in json format
			foreach($data as $row){
				echo json_encode(array("comID"=>$row['comID'], "command"=>$row['command'], "status"=>$row['status']));
				if(next($data)){
					echo "\n";
				}
			}
				
			/*
			foreach($data as $row){
				echo "{";
				echo "\"comID\": ".$row['comID'].", ";
				echo "\"command\": \"".$row['command']."\", ";
				echo "\"status\": \"".$row['status']."\"}\n";
			}
			*/
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