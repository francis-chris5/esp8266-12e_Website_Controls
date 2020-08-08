<?php
    require_once("connectionDetails.php");
    try{
			//boolean controls
       $conn = new PDO("mysql:host=$DBHost;dbname=$DBName", $DBUsername, $DBPassword);
        $select = $conn->prepare("SELECT * FROM booleanControl WHERE 1;");
        $select->execute();
        $data = $select->fetchAll(PDO::FETCH_ASSOC);

        echo "<table border='1'>";
        echo "<tr class='tableHeaders'>";
        for($i = 0; $i < $select->columnCount(); $i++){
            echo "<td>".$select->getColumnMeta($i)['name']."</td>";
        }
        echo "</tr>";

       foreach($data as $row){
            echo "<tr>";
            foreach($row as $item){
                echo "<td>".$item."</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
		
		echo "<br><br>";
		
					//text controls
        $select = $conn->prepare("SELECT * FROM textControl WHERE 1;");
        $select->execute();
        $data = $select->fetchAll(PDO::FETCH_ASSOC);

        echo "<table border='1'>";
        echo "<tr class='tableHeaders'>";
        for($i = 0; $i < $select->columnCount(); $i++){
            echo "<td>".$select->getColumnMeta($i)['name']."</td>";
        }
        echo "</tr>";

       foreach($data as $row){
            echo "<tr>";
            foreach($row as $item){
                echo "<td>".$item."</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
		
		echo "<button onclick=\"clearCommands()\">Clear Sent Commands</button>";
		
		
		echo "<br><br>";
		
		
		
					//sensor data
        $select = $conn->prepare("SELECT * FROM sensorData WHERE 1;");
        $select->execute();
        $data = $select->fetchAll(PDO::FETCH_ASSOC);

        echo "<table border='1'>";
        echo "<tr class='tableHeaders'>";
        for($i = 0; $i < $select->columnCount(); $i++){
            echo "<td>".$select->getColumnMeta($i)['name']."</td>";
        }
        echo "</tr>";

       foreach($data as $row){
            echo "<tr>";
            foreach($row as $item){
                echo "<td>".$item."</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
		
		
		echo "<br><br>";
		
		
		
					//access log
        $select = $conn->prepare("SELECT * FROM lastAccess WHERE 1;");
        $select->execute();
        $data = $select->fetchAll(PDO::FETCH_ASSOC);

        echo "<table border='1'>";
        echo "<tr class='tableHeaders'>";
        for($i = 0; $i < $select->columnCount(); $i++){
            echo "<td>".$select->getColumnMeta($i)['name']."</td>";
        }
        echo "</tr>";

       foreach($data as $row){
            echo "<tr>";
            foreach($row as $item){
                echo "<td>".$item."</td>";
            }
            echo "</tr>";
        }
        echo "</table>";



			// close the connection to the database
        $conn = null;
    }
    catch(PDOException $e){
			// handle any errors that occur
        echo "could not query database: ".$e->getMessage();
    }
?>