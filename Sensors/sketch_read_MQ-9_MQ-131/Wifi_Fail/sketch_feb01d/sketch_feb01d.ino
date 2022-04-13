#include <WiFi.h>
String apiKey = "tPmAT5Ab3j7F9"; // Enter your Write API key from ThingSpeak
const char* ssid = "tnt_EXT"; // replace with your wifi ssid and wpa2 key
const char* pass = "ant3tnt2nt1";
const char* server = "http://alexandernyagolov.com/post-data.php";
WiFiClient client;
// MQ-9 sensor is connected to GPIO 36 (Analog ADC1_CH6) 
const int potPin = 36;

// variable for storing the CO sensor value
int potValue = 0;
void setup()
{
Serial.begin(115200);
delay(10);
Serial.println("Connecting to ");
Serial.println(ssid);
WiFi.begin(ssid, pass);
while (WiFi.status() != WL_CONNECTED)
{
delay(500);
Serial.print(".");
}
Serial.println("");
Serial.println("WiFi connected");
}
void loop()
{
potValue = analogRead(potPin);
if (isnan(potValue))
{
Serial.println("Failed to read from MQ-5 sensor!");
return;
}
 
if (client.connect(server, 80)) // "184.106.153.149" or api.thingspeak.com
{
String postStr = apiKey;
postStr += "&field1=";
postStr += String(potValue/1023*100);
postStr += "r\n";
client.print("POST /update HTTP/1.1\n");
client.print("Host: api.alexandernyagolov.com\n");
client.print("Connection: close\n");
client.print("X-THINGSPEAKAPIKEY: " + apiKey + "\n");
client.print("Content-Type: application/x-www-form-urlencoded\n");
client.print("Content-Length: ");
client.print(postStr.length());
client.print("\n\n");
client.print(postStr);
Serial.print("Gas Level: ");
Serial.println(potValue/1023*100);
Serial.println("Data Send to Server!");
}
delay(500);
client.stop();
Serial.println("Waiting...");
 
// thingspeak needs minimum 15 sec delay between updates.
delay(1500);
}
