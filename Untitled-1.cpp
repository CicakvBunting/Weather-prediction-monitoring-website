// MAX 38cm x 38cm ni alat
#include <Servo.h>

Servo servoMotor;

// Define pin numbers
const int StepX = 2;
const int DirX = 5;
const int StepY = 3;
const int DirY = 6;
const int StepZ = 4;
const int DirZ = 7;
// const int xLimitPin = 9;
// const int yLimitPin = 10;
// const int zLimitPin = 11;

// Define constants
const int jumlahsteptotal = 3200;
const float panjangperrotasi = 0.8; // panjang berapa cm per rotasi
const float panjangstep = panjangperrotasi / jumlahsteptotal; // 0.8/3500, 1 langkah = 0.00022857cm
const int delaymotor = 100; // kecepatan 0-500 semakin tinggi semakin lama
// kalau x lebih banyak belum bareng
int Xnow, Ynow;
//Y negatif ke atas, positif ke bawah
float modyjalan;
float modxjalan;
float maxnum;
float xkoreksi = 0, ykoreksi = 0, zkoreksi = 0;

void setup() {
  Serial.begin(9600);
  servoMotor.attach(12);
  pinMode(StepX, OUTPUT);
  pinMode(DirX, OUTPUT);
  pinMode(StepY, OUTPUT);
  pinMode(DirY, OUTPUT);
  pinMode(StepZ, OUTPUT);
  pinMode(DirZ, OUTPUT);
  pinMode(9, INPUT_PULLUP);
  pinMode(10, INPUT_PULLUP);
  // Serial.println(jumlahsteptotal);
  Xnow = 0;
  Ynow = 0;
  // pinMode(xLimitPin, INPUT_PULLUP);
  // pinMode(yLimitPin, INPUT_PULLUP);
  // pinMode(zLimitPin, INPUT_PULLUP);

  //0.99x+0.2148
  // int degree=45;
  // float kalkulasidegree=(0.99*degree)+0.2148+20;
  // servoMotor.write(80);
  // delay(5000);
  // int sudut=45;
  // int angled=(sudut*1.1)+10;
  // servoMotor.write(angled);
  // delay(200000);
  inisialisasi();
}

void moveStepper(float stepX, float stepY) {
  //Serial.println("jalan");
  
  //arah X
  // set direction, HIGH for clockwise, LOW for anticlockwise
  if (stepX <= 0) {
    stepX = stepX * (-1);
    digitalWrite(DirX, HIGH);
  } else {
    digitalWrite(DirX, LOW);
  }
  //arah Y dan A
  if (stepY <= 0) {
    stepY = stepY * (-1);
    digitalWrite(DirY, HIGH);
  } else {
    digitalWrite(DirY, LOW);
  } 


  // Determine the maximum distance that either axis needs to travel
  if(stepX>stepY){maxnum =stepX;}
  else {maxnum=stepY;}
  // Serial.print("\nmaxnum");
  // Serial.print(maxnum);
  // Serial.print("\n");
  if(maxnum==stepX)
  {
    modyjalan=(stepX/stepY);
    modxjalan=1;
  }else{
    modxjalan=(stepY/stepX);
    modyjalan=1;
  }

  Serial.println("mod jalan x,y:");
  Serial.print(modxjalan);
  Serial.print(",");
  Serial.print(modyjalan);


  // Serial.println(modyjalan);
  // Serial.println(modxjalan);

  while (stepX != 0 || stepY != 0) {
    // motor X,Y,A

    if (stepY != 0 || stepX != 0) {
      for (float i = 0; i < 100; i++) {
        if(stepY!=0 && (int(stepX) % modyjalan)==0 )
        {
        digitalWrite(StepY, HIGH);
        delayMicroseconds(delaymotor);
        digitalWrite(StepY, LOW);
        delayMicroseconds(delaymotor);
        }
        if (stepX != 0&& (int(stepY) % modxjalan)==0 ) {
          digitalWrite(StepX, HIGH);
          delayMicroseconds(delaymotor);
          digitalWrite(StepX, LOW);
          delayMicroseconds(delaymotor);
        }
      }
    }
    if(stepY!=0 && (int(stepX) % modyjalan)==0)stepY--;
    if(stepX!= 0&& (int(stepY) % modxjalan)==0)stepX--;
  }
}

void moveStepperZ(float stepZ) {
  //Serial.println("jalan");
  
  //arah X
  // set direction, HIGH for clockwise, LOW for anticlockwise
  if (stepZ <= 0) {
    stepZ = stepZ * (-1);
    digitalWrite(DirZ, HIGH);
  } else {
    digitalWrite(DirZ, LOW);
  }

  while (stepZ != 0 ) {
    // motor Z

 
      for (int i = 0; i < 100; i++) {
        digitalWrite(StepZ, HIGH);
        delayMicroseconds(delaymotor);
        digitalWrite(StepZ, LOW);
        delayMicroseconds(delaymotor);
      }
    if(stepZ!=0)stepZ--;
  }
}

void inisialisasi(){

  digitalWrite(DirX, HIGH);
  digitalWrite(DirY, HIGH);

  while (digitalRead(9)==HIGH || digitalRead(10)==HIGH) {
    // motor X,Y,A

      for (int i = 0; i < 100; i++) {
        // int limitX = digitalRead(9);
        // int limitY = digitalRead(10);
        if(digitalRead(10)==HIGH)
        {
        digitalWrite(StepY, HIGH);
        delayMicroseconds(100);
        digitalWrite(StepY, LOW);
        delayMicroseconds(100);
        }
        if (digitalRead(9)==HIGH&&digitalRead(10)==LOW) {
          digitalWrite(StepX, HIGH);
          delayMicroseconds(100);
          digitalWrite(StepX, LOW);
          delayMicroseconds(100);
        }
      }
  }

}

void preinplane(double angle){
int titik_tengahx=10;
int titik_tengahy=10;
double radians = angle * PI / 180.0;
  float xpre = titik_tengahx * sin(radians);
  float ypre = titik_tengahy * cos(radians);
  xpre=round(xpre*100)/100;
  ypre=round(ypre*100)/100;
  float Xpre = xpre / 0.0025;
  float Ypre = ypre / 0.0025;
  Serial.println(angle);
  Serial.println("pre inplane jalan ke koordinat ");
  Serial.print(xpre);
  Serial.print(",");
  Serial.print(ypre);
  moveStepper(Xpre, Ypre);
  delay(5000);

}

void inputcoor()
{

}

void loop() {
  // Serial.print("X Limit: ");
  //   Serial.println(digitalRead(xLimitPin));
  //   Serial.print("Y Limit: ");
  //   Serial.println(digitalRead(yLimitPin));
  //   Serial.print("Z Limit: ");
  //   Serial.println(digitalRead(zLimitPin));
  //   delay(1000);
  // while(1){
  // int limitX = digitalRead(9);
  // int limitY = digitalRead(10);
  // Serial.println(limitX);
  // Serial.println(limitY);
  // }
  //pemilihan
  Serial.print("\nPilih Mode Input? \n1. Derajat/Degree\n2. koordinat/coordinate");
    while (!Serial.available());
    if (Serial.available() > 0) 
    {
      inputString = Serial.readStringUntil('\n');
    }
    if(inputString == "1")
    {
      inputdegree();
    }
    else
    {
      inputcoor();
    }


  servoMotor.write(0);
  float xValue = 0, yValue = 0, zValue = 0;

  String inputString;

  //input section
  if(xkoreksi!=0||ykoreksi!=0||zkoreksi!=0){
    Serial.print("\nmasukkan koreksi koordinat:");
    Serial.print(xkoreksi);
    Serial.print(",");
    Serial.print(ykoreksi);
    Serial.print(",");
    Serial.print(zkoreksi);

    xkoreksi = 0, ykoreksi = 0, zkoreksi = 0;
  }
  Serial.print("\nMasukkan Koordinat (format: x,y,z):\n");
  while (!Serial.available());
  if (Serial.available() > 0) {
  inputString = Serial.readStringUntil('\n');
  }

  int commaPos1 = inputString.indexOf(',');
  int commaPos2 = inputString.lastIndexOf(',');

  if (commaPos1 != -1 && commaPos2 != -1) {
  xValue = inputString.substring(0, commaPos1).toFloat();
  yValue = inputString.substring(commaPos1 + 1, commaPos2).toFloat();
  zValue = inputString.substring(commaPos2 + 1).toFloat();
  }

  Serial.print("\nKoordinat X(mm): ");
  Serial.println(xValue);

  Serial.print("Koordinat Y(mm): ");
  Serial.println(yValue); 

  Serial.print("Koordinat Z(mm): ");
  Serial.println(zValue);

  float Xmm = xValue / 0.0025;
  float Ymm = yValue / 0.0025;
  float Zmm = zValue / 0.0025;


  // Serial.println(Xmm);
  // Serial.println(Ymm);
  // Serial.println(Zmm);
  if (Zmm !=0)
  {
    moveStepperZ(Zmm);
  }
  if (Xmm != 0 || Ymm != 0) {
    //distance = sqrt((xValue-Xnow)^2 + (yValue-Ynow)^2);
    double angleRadians = atan2(yValue, xValue);
    int angleDegrees = (int) round(degrees(angleRadians)); //derajat jarum
    Serial.print("\nangleDegrees ");
    Serial.print(angleDegrees);
    // servoMotor.write(angleDegrees);
    float kalkulasidegree=(angleDegrees*1.1)+10;
    servoMotor.write(kalkulasidegree);
    delay(1000);
    preinplane(angleDegrees);
    moveStepper(Xmm, Ymm);
    Serial.print("\nApakah ada koreksi? \nketik 1 untuk ya\nketik 2 untuk tidak");
      while (!Serial.available());
      if (Serial.available() > 0) {
      inputString = Serial.readStringUntil('\n');
      }
      if(inputString == "1"){
        Serial.print("\nmasukkan koordinat saat penusukan(x,y,z):");
        while (!Serial.available());
        if (Serial.available() > 0) {
        inputString = Serial.readStringUntil('\n');
        }
        int commaPos1 = inputString.indexOf(',');
        int commaPos2 = inputString.lastIndexOf(',');

        if (commaPos1 != -1 && commaPos2 != -1) {
        xkoreksi = inputString.substring(0, commaPos1).toFloat();
        ykoreksi = inputString.substring(commaPos1 + 1, commaPos2).toFloat();
        zkoreksi = inputString.substring(commaPos2 + 1).toFloat();
        }
        xkoreksi=xValue+(xValue-xkoreksi);
        ykoreksi=yValue+(yValue-ykoreksi);
        zkoreksi=zValue+(zValue-zkoreksi);

      }
    moveStepper(-Xmm, -Ymm);
    inisialisasi();
    servoMotor.write(0);
  }
  delay(5000);
}