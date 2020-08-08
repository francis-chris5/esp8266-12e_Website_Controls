
CREATE DATABASE esp8266;

/*
	create a database
	table for on/off controls --send and receive rows
	table for data to display --to and from device rows
	table for pwm/analog controls
*/
	
	/* control via booleans
	 * conID will probably be arbritary and unused --could carefully use pin number here (D3, A4, etc for name access)
	 * pinNumber will be the integer representation of pin on the dev-board, left off the 'D' from number to more easily parse string --if json is used instead of custom protocol (security) that will not be necessary
	 * name will be the name on the chip itself
	 * status will be an integer representing pin state (0 or 1, 0-255, 0-1024, etc. for pwm)
	 *
	 *
	 * example inserts are for aruino uno/nano
	 */
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



	/*
	 *control via text instructions
	 * up to 64 character instruction (only 1 row in table???)
	 * initially stored with a status of hold, 
	 * once retreived status changes to sent
	 * microcontroller will only run the command if status is hold
	 */
CREATE TABLE textControl(comID INTEGER PRIMARY KEY AUTO_INCREMENT, command VARCHAR(64), status ENUM("HOLD", "SENT"));
INSERT INTO textControl(command, status) VALUES(0, "ready", "HOLD");



	/*
	 * really only one row in this table, which receives a random number each time instructions from the database are accessed by the microcontroller
	 */
CREATE TABLE lastAccess(accessID INTEGER, randomValue INTEGER, accessTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP on UPDATE CURRENT_TIMESTAMP);
INSERT INTO lastAccess(accessID, randomValue) VALUES(0, 3);



	/*
	 * sensor outputs
	 * the microcontroller will update this table with url requests
	 * the web-page will display what's on this table
	 * (I think I need more here, but can't put my finger on it)
	 */
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
