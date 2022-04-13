#include "PMS.h"
#include "SoftwareSerial.h"

SoftwareSerial rf(1);

PMS pms(Serial);
PMS::DATA data;

void setup()
{
  Serial.begin(115200);   // GPIO1, GPIO3 (TX/RX pin on ESP-12E Development Board)
  rf.begin(115200);  // GPIO2 (D4 pin on ESP-12E Development Board)
}

void loop()
{
  if (pms.read(data))
  {
    Serial.print("Dust Concentration");
    Serial.print("PM1.0 :" + String(data.PM_AE_UG_1_0) + "(ug/m3)");
    Serial.print("PM2.5 :" + String(data.PM_AE_UG_2_5) + "(ug/m3)");
    Serial.print("PM10  :" + String(data.PM_AE_UG_10_0) + "(ug/m3)");
    
    delay(1000);
  }
}
