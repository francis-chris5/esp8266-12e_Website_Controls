
/*
 * Libraries needed to make an HTTP request
 */
#include <Arduino.h>
#include <ESP8266WiFi.h>
#include <ESP8266WiFiMulti.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>

  /*
   * Library to parse through JSON data
   */
#include <ArduinoJson.h>


ESP8266WiFiMulti WiFiMulti;


  /*
   * URL's to connect to, splitting into parts to concatenate 
   * as needed is often a good idea, though not necessary
   */
String baseURL = "<URL STARTER FILES ARE HOSTED AT -use http not https>";
String rx_boolean = "tx_boolean.php?mode=j";



/*
 * Here is a structure to hold the data sent back from the 
 * HTTP request, just some datafields to match what's in
 * the database.
 * And an array of these structures matching the size of 
 * the payload that will be returned
 */
struct pin{
  const char* pinID;
  int pinNumber;
  const char* device;
  const char* pinName;
  int state;
};

typedef struct pin Pin;

Pin esp8266Pins[9];


void setup() {
  /*
   * initialize the pins on the devboard and serial monitor
   * in case it's needed
   * For this example I connected an LED to pin D5
   */
  pinMode(D5, OUTPUT);
  Serial.begin(115200);

  /*
   * connect to the WiFi access point
   */
  WiFi.mode(WIFI_STA);
  WiFiMulti.addAP("<WI-FI ACCESS POINT>", "<WI-FI PASSWORD>");
}//end setup()



void loop() {
  /*
   * If the Wi-Fi connected concatenate together the URL 
   * and make the HTTP request
   */
  if ((WiFiMulti.run() == WL_CONNECTED)) {
    WiFiClient client;
    HTTPClient http;
    String booleanURL = baseURL + rx_boolean;
    if (http.begin(client, booleanURL)) {
     int httpCode = http.GET();
     if (httpCode > 0) {
        if (httpCode == HTTP_CODE_OK || httpCode == HTTP_CODE_MOVED_PERMANENTLY) {   
          String payload = http.getString();
          /*
           * echo the payload in case a check is needed, and
           * a couple line breaks to tell where each batch is
           * without reading through specifically
           */
          Serial.println(payload);
          Serial.println();
          Serial.println();

          /*
           * call method to process string -> json -> struct Pin array
           * then put the needed element from the array in a name
           * that's easier to use and check it's state, I chose to simply
           * ignore the case of PWM set to 1.
           */
          processRawData(payload);

          Pin p5 = esp8266Pins[5];
          
          if(p5.state == 0){
            digitalWrite(D5, LOW);
          }
          else if(p5.state == 1){
            digitalWrite(D5, HIGH);
          }
          else{
            analogWrite(D5, p5.state);
          }
          
        }
      } 
      else {
        /*
         * Some error handling if sending the packet failed
         */
        Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
      }
      http.end();
    }
    else {
        /*
         * some error handling if the connection failed
         */
      Serial.printf("[HTTP} Unable to connect\n");
    }
  }

  /*
   * wait a few seconds before sending the next HTTP request
   */
  delay(10000);
}//end loop()




void processRawData(String payload){
  /*
   * put the lines of the payload data (one json object per line) into
   * an array of strings
   */
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


  /*
   * parse the json data from the array of strings and
   * put into the array of pin structures
   */
  DynamicJsonBuffer json(512);
  for(int i = 0; i < 9; i++){
    JsonObject& root = json.parseObject(row[i]);
    esp8266Pins[i].pinID = root["pinID"];
    esp8266Pins[i].pinNumber = root["pinNumber"];
    esp8266Pins[i].device = root["device"];
    esp8266Pins[i].pinName = root["pinName"];
    esp8266Pins[i].state = root["state"];
  }

}//end processRawData
