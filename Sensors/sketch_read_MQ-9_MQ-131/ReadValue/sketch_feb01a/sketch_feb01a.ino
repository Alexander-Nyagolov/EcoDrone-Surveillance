// MQ-9 sensor is connected to GPIO 36 (Analog ADC1_CH6) 
const int potPin = 32;

// variable for storing the CO sensor value
int potValue = 0;

void setup() {
  Serial.begin(115200);
  delay(1000);
}

void loop() {
  // Reading CO sensor value
  potValue = analogRead(potPin);
  Serial.println(potValue);
  delay(500);
}
