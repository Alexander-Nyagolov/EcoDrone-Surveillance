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
  BValue = analogRead(outputB);
  float voltageA = AValue * (5.0 / 1023.0);
  float voltageB = BValue * (5.0 / 1023.0);
  if(voltageA >= 20 && voltageB >= 20)
  {
      Serial.print("Level: 3"); 
  }
  else if(voltageA >= 20 && voltageB >= 1 && voltageB <= 3)
  {
      Serial.print("Level: 2"); 
  }
  else if(voltageB >= 20 && voltageA >= 1 && voltageA <= 3)
  {
      Serial.print("Level: 1"); 
  }
  else if(voltageA == 0 && voltageA <= 1 && voltageB == 0 && voltageB <= 1)
  {
      Serial.print("Level: 0"); 
  }
  Serial.println("");
  Serial.print("A: ");
  Serial.println(voltageA);
  Serial.print("B: ");
  Serial.println(voltageB);
  delay(2500);
}
