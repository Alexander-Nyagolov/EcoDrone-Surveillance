/*
  Rui Santos
  Complete project details at https://RandomNerdTutorials.com/esp32-sim800l-publish-data-to-cloud/
  
  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files.
  
  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.
*/
#include <Adafruit_CCS811.h>
#include <Adafruit_Sensor.h>
#include <Adafruit_BME280.h>

// GPRS credentials
const char apn[]      = "internet.a1.bg"; // APN (example: internet.vodafone.pt) use https://wiki.apnchanger.org
const char gprsUser[] = ""; // GPRS User
const char gprsPass[] = ""; // GPRS Password

// SIM card PIN (leave empty, if not defined)
const char simPIN[]   = ""; 

// Server details
// The server variable can be just a domain name or it can have a subdomain. It depends on the service you are using
const char server[] = "alexandernyagolov.com";    // domain name: example.com, maker.ifttt.com, etc
const char resource[] = "/post-data.php";         // resource path, for example: /post-data.php
const int  port = 80;                             // server port number

// Keep this API Key value to be compatible with the PHP code provided in the project page. 
// If you change the apiKeyValue value, the PHP file /post-data.php also needs to have the same key 
String apiKeyValue = "tPmAT5Ab3j7F9";

// TTGO T-Call pins
#define MODEM_RST            5
#define MODEM_PWKEY          4
#define MODEM_POWER_ON       23
#define MODEM_TX             27
#define MODEM_RX             26
#define I2C_SDA              21
#define I2C_SCL              22

const int SENSORS_POWER = 33;
const int COPin = 32;      // MQ-9 CO sensor is connected to GPIO 32 (Analog ADC1_CH6) 
const int OzonePin = 34;   // MQ-131 O3 sensor is connected to GPIO 34
const int outputA = 13;    // Green VOC sensor is connected A to GPIO 13 
const int outputB = 12;    // B to GPIO 12
const int PM_RX = 2;       // PM sensor is connected RX to GPIO 2
const int PM_TX = 15;       // TX to GPIO 4
Adafruit_CCS811 ccs;       // Violet VOC sensor is connected to SCL pin - 22 & SDA pin - 21

int potValue = 0;         // variable for storing the CO sensor value
int AValue = 0;           // variable for storing the A pin sensor value
int BValue = 0;           // variable for storing the B pin sensor value
float VOC = 0.0;

// Set serial for debug console (to Serial Monitor, default speed 115200)
#define SerialMon Serial
// Set serial for AT commands (to SIM800 module)
#define SerialAT Serial1

// Configure TinyGSM library
#define TINY_GSM_MODEM_SIM800      // Modem is SIM800
#define TINY_GSM_RX_BUFFER   1024  // Set RX buffer to 1Kb

// Define the serial console for debug prints, if needed
//#define DUMP_AT_COMMANDS

#include <Wire.h>
#include <TinyGsmClient.h>

#ifdef DUMP_AT_COMMANDS
  #include <StreamDebugger.h>
  StreamDebugger debugger(SerialAT, SerialMon);
  TinyGsm modem(debugger);
#else
  TinyGsm modem(SerialAT);
#endif

// I2C for SIM800 (to keep it running when powered from battery)
TwoWire I2CPower = TwoWire(0);

// TinyGSM Client for Internet connection
TinyGsmClient client(modem);

#define uS_TO_S_FACTOR 1000000UL   /* Conversion factor for micro seconds to seconds */
#define TIME_TO_SLEEP  36        /* Time ESP32 will go to sleep (in seconds) 3600 seconds = 1 hour */

#define IP5306_ADDR          0x75
#define IP5306_REG_SYS_CTL0  0x00

bool setPowerBoostKeepOn(int en){
  I2CPower.beginTransmission(IP5306_ADDR);
  I2CPower.write(IP5306_REG_SYS_CTL0);
  if (en) {
    I2CPower.write(0x37); // Set bit1: 1 enable 0 disable boost keep on
  } else {
    I2CPower.write(0x35); // 0x37 is default reg value
  }
  return I2CPower.endTransmission() == 0;
}

void setup() {
  // Set serial monitor debugging window baud rate to 115200
  SerialMon.begin(115200);
  pinMode(SENSORS_POWER, OUTPUT);
  pinMode(13, OUTPUT);
  
  // Start I2C communication
  I2CPower.begin(I2C_SDA, I2C_SCL, 400000);

  // Keep power when running from battery
  bool isOk = setPowerBoostKeepOn(1);
  SerialMon.println(String("IP5306 KeepOn ") + (isOk ? "OK" : "FAIL"));

  // Set modem reset, enable, power pins
  pinMode(MODEM_PWKEY, OUTPUT);
  pinMode(MODEM_RST, OUTPUT);
  pinMode(MODEM_POWER_ON, OUTPUT);
  digitalWrite(MODEM_PWKEY, LOW);
  digitalWrite(MODEM_RST, HIGH);
  digitalWrite(MODEM_POWER_ON, HIGH);

  // Set GSM module baud rate and UART pins
  SerialAT.begin(115200, SERIAL_8N1, MODEM_RX, MODEM_TX);
  delay(3000);

  // Restart SIM800 module, it takes quite some time
  // To skip it, call init() instead of restart()
  SerialMon.println("Initializing modem...");
  modem.restart();
  // use modem.init() if you don't need the complete restart

  // Unlock your SIM card with a PIN if needed
  if (strlen(simPIN) && modem.getSimStatus() != 3 ) {
    modem.simUnlock(simPIN);
  }

  // Configure the wake up source as timer wake up  
  esp_sleep_enable_timer_wakeup(TIME_TO_SLEEP * uS_TO_S_FACTOR);
}

void loop() {
  digitalWrite(SENSORS_POWER, HIGH);
  digitalWrite(13, HIGH);
  SerialMon.print("Connecting to APN: ");
  SerialMon.print(apn);
  if (!modem.gprsConnect(apn, gprsUser, gprsPass)) {
    SerialMon.println(" fail");
  }
  else {
    SerialMon.println(" OK");
    
    SerialMon.print("Connecting to ");
    SerialMon.print(server);
    if (!client.connect(server, port)) {
      SerialMon.println(" fail");
    }
    else {
      SerialMon.println(" OK");
      AValue = analogRead(outputA);
      BValue = analogRead(outputB);
      float voltageA = AValue * (5.0 / 1023.0);
      float voltageB = BValue * (5.0 / 1023.0);
      if(voltageA >= 20 && voltageB >= 20)
      {
          VOC = 3.5;
      }
      else if(voltageA >= 20 && voltageB >= 1 && voltageB <= 3)
      {
          VOC = 2.5;
      }
      else if(voltageB >= 20 && voltageA >= 1 && voltageA <= 3)
      {
          VOC = 1.5;
      }
      else if(voltageA == 0 && voltageA <= 1 && voltageB == 0 && voltageB <= 1)
      {
          VOC = 0.5;
      }
      // Making an HTTP POST request
      SerialMon.println("Performing HTTP POST request...");
      // Prepare your HTTP POST request data (CO levels)
      String httpRequestData = "api_key=" + apiKeyValue + "&co=" + String(random(200, 400))
                               + "&co2=" + String(random(200, 400)) + "&voc=" + 1.5
                               + "&tvoc=" + String(random(250, 550))
                               + "&ozone=" + String(random(0, 70)) + "&pm1=" + String(random(10, 50))
                               + "&pm25=" + String(random(10, 100)) + "&pm10=" + String(random(10, 50))+"";
      // You can comment the httpRequestData variable above
      // then, use the httpRequestData variable below (for testing purposes without the BME280 sensor)
      // String httpRequestData = "api_key=tPmAT5Ab3j7F9&value1=24.75&value2=49.54&value3=1005.14";
    
      client.print(String("POST ") + resource + " HTTP/1.1\r\n");
      client.print(String("Host: ") + server + "\r\n");
      client.println("Connection: close");
      client.println("Content-Type: application/x-www-form-urlencoded");
      client.print("Content-Length: ");
      client.println(httpRequestData.length());
      client.println();
      client.println(httpRequestData);

      unsigned long timeout = millis();
      while (client.connected() && millis() - timeout < 10000L) {
        // Print available data (HTTP response from server)
        while (client.available()) {
          char c = client.read();
          SerialMon.print(c);
          timeout = millis();
        }
      }
      SerialMon.println();
    
      // Close client and disconnect
      client.stop();
      SerialMon.println(F("Server disconnected"));
      modem.gprsDisconnect();
      SerialMon.println(F("GPRS disconnected"));
    }
  }
  digitalWrite(SENSORS_POWER, LOW);
  digitalWrite(13, LOW);
  // Put ESP32 into deep sleep mode (with timer wake up)
  esp_deep_sleep_start();
}