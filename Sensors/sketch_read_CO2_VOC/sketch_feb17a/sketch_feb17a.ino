#include <Wire.h>
#include <Adafruit_Sensor.h>
#include <Adafruit_CCS811.h>




Adafruit_CCS811 ccs;

void setup() {
Serial.begin(9600);

Serial.println("CCS811 test");


}



void loop() {
if(ccs.available()){
float temp = ccs.calculateTemperature();
if(!ccs.readData()){
Serial.print("CO2: ");
Serial.print(ccs.geteCO2());
Serial.print("ppm, TVOC: ");
Serial.print(ccs.getTVOC());
Serial.print("ppb Temp:");
Serial.println(temp);
}
else{
Serial.println("ERROR!");
while(1);
}
}
delay(500);
}
