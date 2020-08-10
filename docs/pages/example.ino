

/*
 * A whole bunch of initialization stuff. Make sure
 * to change the values for the address where the 
 * starter files are hosted at, along with the Wi-Fi
 * access point and password
 */
#include <Arduino.h>
#include <ESP8266WiFi.h>
#include <ESP8266WiFiMulti.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>

#include <ArduinoJson.h>


ESP8266WiFiMulti WiFiMulti;

String baseURL = "URL WHERE STARTER-FILES ARE HOSTED AT";
String rx_boolean = "tx_boolean.php?mode=j";
String rx_command = "tx_command.php?mode=j";
String removeCommands = "removeCommands.php";


struct pin{
  const char* pinID;
  int pinNumber;
  const char* device;
  const char* pinName;
  int state;
};

typedef struct pin Pin;

Pin esp8266Pins[9];


struct com{
  const char* comID;
  const char* command;
  const char* state;
};
typedef struct com Com;
Com nextCom;


int blueState = 0;
int greenState = 0;
int redState = 0;




void setup() {
  pinMode(D2, OUTPUT);
  pinMode(D5, OUTPUT);
  pinMode(D6, OUTPUT);
  Serial.begin(115200);
  WiFi.mode(WIFI_STA);
  WiFiMulti.addAP("WI-FI ACCESS POINT", "WI-FI PASSWORD");
}//end setup()





/*
 * The main loop just calls the request methods if 
 * it connected to Wi-Fi and waits a few seconds to
 * avoid spamming the server --decrease the odds of web
 * page and microcontroller both trying to access the
 * database simultaneously.
 */
void loop() {
  if ((WiFiMulti.run() == WL_CONNECTED)){
    booleanRequest();
    textRequest();
   }
   else{
     Serial.printf("[HTTP} Unable to connect\n");
   }
  toggleLED();
  delay(8000);
}//end loop()





/*
 * This method makes an HTTP request for the
 * transmit boolean php script to run (tx_boolean.php),
 * and calls the method to process through the data
 * if the server responded.
 */
void booleanRequest(){
  WiFiClient client;
  HTTPClient http;
  delay(1000);
  String booleanURL = baseURL + rx_boolean;
  if (http.begin(client, booleanURL)) {
   int httpCode = http.GET();
   if (httpCode > 0) {
      if (httpCode == HTTP_CODE_OK || httpCode == HTTP_CODE_MOVED_PERMANENTLY) {   
        String payload = http.getString();
        processBooleanData(payload);
      }
    } 
    else {
      Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
    }
  }
  http.end();
}//end booleanRequest()





/*
 * This method makes an HTTP request for the
 * transmit command php script to run (tx_command.php),
 * and calls the method to process through the data
 * if the server responded.
 */
void textRequest(){
  WiFiClient client;
  HTTPClient http;
  delay(1000);
  String textURL = baseURL + rx_command;
  if (http.begin(client, textURL)) {
   int httpCode = http.GET();
   if (httpCode > 0) {
      if (httpCode == HTTP_CODE_OK || httpCode == HTTP_CODE_MOVED_PERMANENTLY) {   
        String payload = http.getString();
        if(payload.length() > 0){
          clearRequest();
          processTextData(payload);
        }
      }
    } 
    else {
      Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
    }
  }
  http.end();
}//end textRequest()



/*
 * This method makes the HTTP request to remove
 * alread sent commands from the database
 * (removeCommands.php) to assure that only one
 * text based command can come through at a time.
 * This is called from within the textRequest() method,
 * so only runs when needed.
 */
void clearRequest(){
  WiFiClient client;
  HTTPClient http;
  delay(1000);
  String removeURL = baseURL + removeCommands;
  if(http.begin(client, removeURL)){
    int httpCode = http.GET();
    if(httpCode > 0){
      if(httpCode == HTTP_CODE_OK || httpCode == HTTP_CODE_MOVED_PERMANENTLY){
        //Serial.println("old commands removed");
      }
    }
    else {
      Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
    }
  }
  http.end();
}//end clearCommand()




/*
 * This method breaks the payload up by line-breaks,
 * there should be one json object per line, and then
 * parses through the json to put in an array of the
 * pin structures set up with datafields to match what's
 * in the database.
 * It then sets the state of each control pin based on the
 * value in the database.
 */
void processBooleanData(String payload){
  String row[9];
  int startPos = 0;
  int endPos = 0;
  for(int i = 0; i < 9; i++){
    endPos = payload.indexOf('\n', startPos);
    if(i < 8){
      row[i] = payload.substring(startPos, endPos);
      startPos = endPos + 1;
    }
    else{
      row[i] = payload.substring(startPos);
    }
  }
  DynamicJsonBuffer json(512);
  for(int i = 0; i < 9; i++){
    JsonObject& root = json.parseObject(row[i]);
    esp8266Pins[i].pinID = root["pinID"];
    esp8266Pins[i].pinNumber = root["pinNumber"];
    esp8266Pins[i].device = root["device"];
    esp8266Pins[i].pinName = root["pinName"];
    esp8266Pins[i].state = root["state"];
  }
  blueState = esp8266Pins[2].state;
  greenState = esp8266Pins[5].state;
  redState = esp8266Pins[6].state;
}//end processBooleanData()





/*
 * This method parses the payload into the command
 * structure set up with datafields to match the 
 * database. Then sets the on/off state of the pins
 * off of a few keywords.
 * To try and keep the example kind of simple, this is only on
 * for the 8 seconds until the next pass of the loop, it
 * should really follow this up by updating the values in
 * the database so the processBooleanData() method doesn't
 * override it on the next pass.
 */
void processTextData(String payload){
  DynamicJsonBuffer json(512);
  JsonObject& root = json.parseObject(payload);
  nextCom.comID = root["comID"];
  nextCom.command = root["command"];
  nextCom.state = root["status"];
  String command = String(nextCom.command);
  if(command == "BLUE_ON"){
    blueState = 1;
  }
  else if(command == "BLUE_OFF"){
    blueState = 0;
  }
  else if(command == "GREEN_ON"){
    greenState = 1;
  }
  else if(command == "GREEN_OFF"){
    greenState = 0;
  }
  else if(command == "RED_ON"){
    redState = 1;
  }
  else if(command == "RED_OFF"){
    redState = 0;
  }
}//end processTextData()






/*
 * This is the method that actually turns LED's on and
 * off after the data from the server has been processed
 * through.
 */
void toggleLED(){
  if(blueState == 0){
    digitalWrite(D2, LOW);
  }
  else if(blueState == 1){
    digitalWrite(D2, HIGH);
  }
  else{
    analogWrite(D2, blueState);
  }
  if(greenState == 0){
    digitalWrite(D5, LOW);
  }
  else if(greenState == 1){
    digitalWrite(D5, HIGH);
  }
  else{
    analogWrite(D5, greenState);
  }
  if(redState == 0){
    digitalWrite(D6, LOW);
  }
  else if(redState == 1){
    digitalWrite(D6, HIGH);
  }
  else{
    analogWrite(D6, redState);
  }
}//end toggleLED()
