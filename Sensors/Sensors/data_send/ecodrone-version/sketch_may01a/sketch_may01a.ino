/*
  Rui Santos
  Complete project details at https://RandomNerdTutorials.com/esp32-sim800l-publish-data-to-cloud/
  
  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files.
  
  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.
*/
#include <Adafruit_CCS811.h>
#include <SoftwareSerial.h>
SoftwareSerial pmsSerial(15, 2); // TX, RX

// GPRS credentials
const char apn[]      = "internet.a1.bg"; // APN (example: internet.vodafone.pt) use https://wiki.apnchanger.org
const char gprsUser[] = ""; // GPRS User
const char gprsPass[] = ""; // GPRS Password

// SIM card PIN (leave empty, if not defined)
const char simPIN[]   = ""; 

// Server details
// The server variable can be just a domain name or it can have a subdomain. It depends on the service you are using
const char server[] = "ecodrone-surveillance.com";    // domain name: example.com, maker.ifttt.com, etc
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

// Start-up pin
#define STARTPIN             25

const int COPin = 35;      // MQ-9 CO sensor is connected to GPIO 35 (Analog ADC1_CH6) 
const int OzonePin = 34;   // MQ-131 O3 sensor is connected to GPIO 34

// Green VOC sensor is connected to:
const int outputA = 13;    // A to GPIO 13 
const int outputB = 12;    // B to GPIO 12

// Violet VOC sensor is connected to
Adafruit_CCS811 ccs;       // SCL pin - 22 & SDA pin - 21

// Variables for storage
int pm1 = 0;
int pm25 = 0;
int pm100 = 0;
int particles_03um = 0;
int particles_05um = 0;
int particles_10um = 0;
int particles_25um = 0;
int particles_50um = 0;
int particles_100um = 0; 
int potValue = 0;         // CO sensor value
int ozoneValue = 0;       // O3 sensor value
int AValue = 0;           // A pin sensor value
int BValue = 0;           // B pin sensor value
float voltageA = 0.0;     // Calculated value of A
float voltageB = 0.0;     // Calculated value of B
float VOC = 0.0;          // VOC - green sensor final value
int co2 = 400;            // Default CO2 value of violet sensor
int tvoc = 0;             // TVOC value of violet sensor

// Counters
int br = 0;               // co2 and voc records
int brO = 0;              // ozone records

// Set serial for debug console (to Serial Monitor, default speed 115200)
#define SerialMon Serial
// Set serial for AT commands (to SIM800 module)
#define SerialAT Serial1

// Configure TinyGSM library
#define TINY_GSM_MODEM_SIM800      // Modem is SIM800
#define TINY_GSM_RX_BUFFER   1024  // Set RX buffer to 1Kb

// Define the serial console for debug prints, if needed
//#define DUMP_AT_COMMANDS

#include <TinyGsmClient.h>

#ifdef DUMP_AT_COMMANDS
  #include <StreamDebugger.h>
  StreamDebugger debugger(SerialAT, SerialMon);
  TinyGsm modem(debugger);
#else
  TinyGsm modem(SerialAT);
#endif

// TinyGSM Client for Internet connection
TinyGsmClient client(modem);

#define uS_TO_S_FACTOR 1000000UL   /* Conversion factor for micro seconds to seconds */
#define TIME_TO_SLEEP  10        /* Time ESP32 will go to sleep (in seconds) 3600 seconds = 1 hour */

void setup() {
  // Set serial monitor debugging window baud rate to 115200
  SerialMon.begin(115200);

  // PM sensor baud rate is 9600
  pmsSerial.begin(9600);

  pinMode(STARTPIN, OUTPUT);
  
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
 
struct pms5003data {
  uint16_t framelen;
  uint16_t pm10_standard, pm25_standard, pm100_standard;
  uint16_t pm10_env, pm25_env, pm100_env;
  uint16_t particles_03um, particles_05um, particles_10um, particles_25um, particles_50um, particles_100um;
  uint16_t unused;
  uint16_t checksum;
};
 
struct pms5003data data;
  
void loop() {
  digitalWrite(STARTPIN, HIGH); // Turn on sensors
  delay(10*1000);
  if(!ccs.begin())
  {
    Serial.println("Failed to start sensor! Please check your wiring.");
    while(1);
  }
  
  // Wait for the sensor to be ready
  while(!ccs.available());
  
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
       for(int i=0;i<10;i++)
       {
       potValue += analogRead(COPin);
       if(analogRead(OzonePin) > 0)
       {
         ozoneValue += analogRead(OzonePin);
         brO++;
       }
       
       if(ccs.available()){
        if(!ccs.readData()){
          if(ccs.geteCO2() > 400 && ccs.getTVOC() > 0)
          {
            co2 += ccs.geteCO2();
            tvoc += ccs.getTVOC();
            br++;
          }
        }
        else{
          Serial.println("ERROR!");
          while(1);
        }
       }
       
        if (readPMSdata(&pmsSerial)) {
        // reading data was successful!
        pm1 += data.pm10_env;
        pm25 += data.pm25_env;
        pm100 += data.pm100_env;
        particles_03um += data.particles_03um;
        particles_05um += data.particles_05um;
        particles_10um += data.particles_10um;
        particles_25um += data.particles_25um;
        particles_50um += data.particles_50um;
        particles_100um += data.particles_100um;
        }
       
        AValue += analogRead(outputA);
        BValue += analogRead(outputB);
        voltageA += AValue * (5.0 / 1023.0);
        voltageB += BValue * (5.0 / 1023.0);
      delay(2000);
      }
      if(voltageA/10 >= 20 && voltageB/10 >= 20)
        {
            VOC = 3.5;
        }
        else if(voltageA/10 >= 20 && voltageB/10 >= 1 && voltageB/10 <= 3)
        {
            VOC = 2.5;
        }
        else if(voltageB/10 >= 20 && voltageA/10 >= 10 && voltageA/10 <= 3)
        {
            VOC = 1.5;
        }
        else if(voltageA/10 == 0 && voltageA/10 <= 1 && voltageB/10 == 0 && voltageB/10 <= 1)
        {
            VOC = 0.5;
        }

        potValue = potValue/10;
        if(br != 0)
        {
          co2 = (co2)/br+1;
          tvoc = tvoc/br;
        }
        if(brO != 0)
        {
          ozoneValue = ozoneValue/brO;
        }
        pm1 = pm1/10;
        pm25 = pm25/10;
        pm100 = pm100/10;
        particles_03um = particles_03um/10;
        particles_05um = particles_05um/10;
        particles_10um = particles_10um/10;
        particles_25um = particles_25um/10;
        particles_50um = particles_50um/10;
        particles_100um = particles_100um/10; 
        
      // Making an HTTP POST request
      SerialMon.println("Performing HTTP POST request...");
      
      // Prepare your HTTP POST request data (CO levels)
      String httpRequestData = "api_key=" + apiKeyValue + "&co=" + String(potValue) + "&co2=" + String(co2) 
                        + "&voc=" + String(VOC) + "&pm1=" + String(pm1) + "&pm25=" + String(pm25) + "&pm10=" + String(pm100)
                        + "&particles_03um=" + String(particles_03um) + "&particles_05um=" + String(particles_05um)
                        + "&particles_10um=" + String(particles_10um) + "&particles_25um=" + String(particles_25um)
                        + "&particles_50um=" + String(particles_50um) + "&particles_100um=" + String(particles_100um);
      if(tvoc > 0)
      {
       httpRequestData += "&tvoc=" + String(tvoc);
      }
      if(ozoneValue > 0)
      {
        httpRequestData += "&ozone=" + String(ozoneValue);
      }
    
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
  digitalWrite(STARTPIN, LOW); // Turn off sensors
  // Put ESP32 into deep sleep mode (with timer wake up)
  esp_deep_sleep_start();
}
 
boolean readPMSdata(Stream *s) {
  if (! s->available()) {
    return false;
  }
  
  // Read a byte at a time until we get to the special '0x42' start-byte
  if (s->peek() != 0x42) {
    s->read();
    return false;
  }
 
  // Now read all 32 bytes
  if (s->available() < 32) {
    return false;
  }
    
  uint8_t buffer[32];    
  uint16_t sum = 0;
  s->readBytes(buffer, 32);
 
  // get checksum ready
  for (uint8_t i=0; i<30; i++) {
    sum += buffer[i];
  }
 
  /* debugging
  for (uint8_t i=2; i<32; i++) {
    Serial.print("0x"); Serial.print(buffer[i], HEX); Serial.print(", ");
  }
  Serial.println();
  */
  
  // The data comes in endian'd, this solves it so it works on all platforms
  uint16_t buffer_u16[15];
  for (uint8_t i=0; i<15; i++) {
    buffer_u16[i] = buffer[2 + i*2 + 1];
    buffer_u16[i] += (buffer[2 + i*2] << 8);
  }
 
  // put it into a nice struct :)
  memcpy((void *)&data, (void *)buffer_u16, 30);
 
  if (sum != data.checksum) {
    Serial.println("Checksum failure");
    return false;
  }
  // success!
  return true;
}
