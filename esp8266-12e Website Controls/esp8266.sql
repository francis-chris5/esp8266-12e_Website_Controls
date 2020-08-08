
CREATE DATABASE esp8266;

CREATE TABLE booleanControl(pinID VARCHAR(4), pinNumber INTEGER, device VARCHAR(64), pinName VARCHAR(32), status INTEGER);
INSERT INTO booleanControl(pinID, pinNumber, device, pinName, status) VALUES("D0", 0, "nothing", "GPIO16", 0);
INSERT INTO booleanControl(pinID, pinNumber, device, pinName, status) VALUES("D1", 1, "nothing", "GPIO5", 0);
INSERT INTO booleanControl(pinID, pinNumber, device, pinName, status) VALUES("D2", 2, "nothing", "GPIO4", 0);
INSERT INTO booleanControl(pinID, pinNumber, device, pinName, status) VALUES("D3", 3, "nothing", "GPIO0", 0);
INSERT INTO booleanControl(pinID, pinNumber, device, pinName, status) VALUES("D4", 4, "nothing", "GPIO2", 0);
INSERT INTO booleanControl(pinID, pinNumber, device, pinName, status) VALUES("D5", 5, "nothing", "GPIO14", 0);
INSERT INTO booleanControl(pinID, pinNumber, device, pinName, status) VALUES("D6", 6, "nothing", "GPIO12", 0);
INSERT INTO booleanControl(pinID, pinNumber, device, pinName, status) VALUES("D7", 7, "nothing", "GPIO13", 0);
INSERT INTO booleanControl(pinID, pinNumber, device, pinName, status) VALUES("D8", 8, "nothing", "GPIO15", 0);


CREATE TABLE textControl(comID INTEGER PRIMARY KEY AUTO_INCREMENT, command VARCHAR(64), status ENUM("HOLD", "SENT"));
INSERT INTO textControl(command, status) VALUES(0, "ready", "HOLD");



CREATE TABLE lastAccess(accessID INTEGER, randomValue INTEGER, accessTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP on UPDATE CURRENT_TIMESTAMP);
INSERT INTO lastAccess(accessID, randomValue) VALUES(0, 3);


CREATE TABLE sensorData(pinID VARCHAR(4), pinNumber INTEGER, sensor VARCHAR(64), pinName VARCHAR(32), status VARCHAR(32));
INSERT INTO sensorData(pinID, pinNumber, sensor, pinName, status) VALUES("A0", 29, "nothing", "ADC0", "null");
INSERT INTO sensorData(pinID, pinNumber, sensor, pinName, status) VALUES("D0", 0, "nothing", "GPIO16", "null");
INSERT INTO sensorData(pinID, pinNumber, sensor, pinName, status) VALUES("D1", 1, "nothing", "GPIO5", "null");
INSERT INTO sensorData(pinID, pinNumber, sensor, pinName, status) VALUES("D2", 2, "nothing", "GPIO4", "null");
INSERT INTO sensorData(pinID, pinNumber, sensor, pinName, status) VALUES("D3", 3, "nothing", "GPIO0", "null");
INSERT INTO sensorData(pinID, pinNumber, sensor, pinName, status) VALUES("D4", 4, "nothing", "GPIO2", "null");
INSERT INTO sensorData(pinID, pinNumber, sensor, pinName, status) VALUES("D5", 5, "nothing", "GPIO14", "null");
INSERT INTO sensorData(pinID, pinNumber, sensor, pinName, status) VALUES("D6", 6,"nothing", "GPIO12", "null");
INSERT INTO sensorData(pinID, pinNumber, sensor, pinName, status) VALUES("D7", 7, "nothing", "GPIO13", "null");
INSERT INTO sensorData(pinID, pinNumber, sensor, pinName, status) VALUES("D8", 8, "nothing", "GPIO15", "null");
