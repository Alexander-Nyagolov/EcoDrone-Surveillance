#include <SoftwareSerial.h>
#include <TinyGPS++.h>
#include <axp20x.h>

TinyGPSPlus gps;
SoftwareSerial ss(3,1);

//HardwareSerial Serial1(1);

void setup()
{
Serial1.begin(115200);
ss.begin(9600);
Serial.begin(9600, SERIAL_8N1, 1, 3); //1-TX 3-RX
}

void loop()
{

while (ss.available() > 0)
gps.encode(ss.read());

Serial.print("Latitude : ");
Serial.println(gps.location.lat(), 5);
Serial.print("Longitude : ");
Serial.println(gps.location.lng(), 4);
Serial.print("Satellites: ");
Serial.println(gps.satellites.value());
Serial.print("Altitude : ");
Serial.print(gps.altitude.feet() / 3.2808);
Serial.println("M");
Serial.print("Time : ");
Serial.print(gps.time.hour());
Serial.print(":");
Serial.print(gps.time.minute());
Serial.print(":");
Serial.println(gps.time.second());
Serial.println("**********************");

smartDelay(1000);

if (millis() > 5000 && gps.charsProcessed() < 10)
Serial.println(F("No GPS data received: check wiring"));
}

static void smartDelay(unsigned long ms)
{
unsigned long start = millis();
do
{
while (Serial1.available())
gps.encode(Serial1.read());
} while (millis() - start < ms);
}
