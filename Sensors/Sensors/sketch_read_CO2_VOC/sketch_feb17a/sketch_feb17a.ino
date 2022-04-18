#include <Wire.h>
#include <Adafruit_Sensor.h>
#include <Adafruit_CCS811.h>

#define I2C_SDA 18
#define I2C_SCL 19


TwoWire I2CBME = TwoWire(0);
Adafruit_CCS811 ccs;

void setup() {
Serial.begin(9600);
  Serial.println(F("BME280 test"));
  I2CBME.begin(I2C_SDA, I2C_SCL, 400000);
pinMode(33, OUTPUT);
  digitalWrite(33, HIGH);
Serial.println("CCS811 test");

if(!ccs.begin(0x75, &I2CBME)){
Serial.println("Failed to start sensor! Please check your wiring.");
while(1);
}

//calibrate temperature sensor
while(!ccs.available());
float temp = ccs.calculateTemperature();
ccs.setTempOffset(temp - 25.0);
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
