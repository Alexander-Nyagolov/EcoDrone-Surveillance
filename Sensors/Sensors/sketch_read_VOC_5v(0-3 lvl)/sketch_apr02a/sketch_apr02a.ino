const int outputA = 13;
const int outputB = 12;
int AValue = 0;
int BValue = 0;

void setup() {
  Serial.begin(9600);
  delay(1000);
}

void loop() {
  AValue = analogRead(outputA);
  float voltageA = AValue * (5.0 / 1023.0);
  Serial.print("A: ");
  Serial.println(voltageA);
  BValue = analogRead(outputB);
  float voltageB = BValue * (5.0 / 1023.0);
  Serial.print("B: ");
  Serial.println(voltageB);
  delay(500);
}
