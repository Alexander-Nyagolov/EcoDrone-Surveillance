const int outputA = 13;
const int outputB = 12;
int AValue = 0;
int BValue = 0;
int A1Value = 0;
int B1Value = 0;

void setup() {
  Serial.begin(9600);
  pinMode(14, OUTPUT);
}

void loop() {
  digitalWrite(14, HIGH);
  delay(6000);
  
  AValue = analogRead(outputA);
  BValue = analogRead(outputB);
  float voltageA = AValue * (5.0 / 1023.0);
  float voltageB = BValue * (5.0 / 1023.0);
  Serial.println("");
  Serial.print("A1: ");
  Serial.println(voltageA);
  Serial.print("B1: ");
  Serial.println(voltageB); 
  delay(500);
  
  digitalWrite(14, LOW);
  delay(1500);
  A1Value = analogRead(outputA);
  B1Value = analogRead(outputB);
  float voltageA1 = A1Value * (5.0 / 1023.0);
  float voltageB1 = B1Value * (5.0 / 1023.0);
  Serial.println("");
  Serial.print("A2: ");
  Serial.println(voltageA1);
  Serial.print("B2: ");
  Serial.println(voltageB1);
  delay(2500);
}
