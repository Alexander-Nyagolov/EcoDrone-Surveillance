#include <PMS.h>
#include <SoftwareSerial.h>
SoftwareSerial pmsSerial(32, 14); // RX, TX

PMS pms(pmsSerial);
PMS::DATA data;

void setup()
{
  Serial.begin(115200);  
  pmsSerial.begin(9600);  
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
