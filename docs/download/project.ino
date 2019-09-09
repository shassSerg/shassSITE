#include <PID_v1.h>
//#include <I2Cdev.h>


#include "MPU6050_6Axis_MotionApps20.h"



#if I2CDEV_IMPLEMENTATION == I2CDEV_ARDUINO_WIRE
#include "Wire.h"
#endif



const String nameofdevice="3D20C49";
String firmware="v1.0";



unsigned long time_current;//для времени
int time_wait=10000;//время ожидания


double distanceUp=0;
double distanceDown=0;
double distance1=0;
double distance2=0;
double distance3=0;
double distance4=0;

/*
double minHeightNoConnect=1.0;
double HeightNoConnectStep=0.1;*/

double heightGain=0.0; //высота полета

float infoBattery[4]; //информация о батареи
byte packetByte[7]; //буффер для хранение байта, полученного с сервера
/*
//Security
byte key[3];
byte accessbyte=134;
//const startPacket=10;
//int curPacket=10;*/
//--------------------


/*функция получения информации о батареи*/
//PIN
#define pinToCheckBattery 0
#define pinToCheckTempBattery 2
#define pinToCheckCurrentBattery 1
//VARIABLES
float maxTemperatureBattery=-20.0f;
float minTemperatureBattery=50.0f;
float minVoltageBattery=3.0f;
float maxVoltageBattery=4.2f;
float maxCurrentBattery=1.0f;
bool CheckBattery(){
  //значение порта 0-1024
  short valueOfPin=analogRead(pinToCheckBattery);
  
  //напряжение порта 5 -максимальное, 1024 кол-во ступеней
  float bufferFloat=((((float)(valueOfPin)) * (float)(5.0 / 1024.0))/(1024.0))*(1718.0);
  infoBattery[0]=bufferFloat;
  
  //процент заряда батареи
  bufferFloat=((bufferFloat-minVoltageBattery)/(maxVoltageBattery-minVoltageBattery))*100.0;
  infoBattery[1]=bufferFloat;

  //значение порта
  valueOfPin=analogRead(pinToCheckTempBattery);
  //вычисление температуры по датчику LM35
  bufferFloat =(valueOfPin/1023.0)*5.0*1000/10;
  infoBattery[2]=bufferFloat;
  
  //вычисление тока нагрузки
  valueOfPin=analogRead(pinToCheckCurrentBattery);
  bufferFloat =(((valueOfPin/1024.0)*5.0)-2.5)/100;
  infoBattery[3]=bufferFloat;

  //Проверка состояние батареи на предмет готовности к работе: false - не готова
  if (infoBattery[2]>maxTemperatureBattery || 
      infoBattery[2]<minTemperatureBattery || 
      infoBattery[0]<minVoltageBattery || 
      infoBattery[0]>maxVoltageBattery ||
      infoBattery[3]>maxCurrentBattery)
  return false;
  else 
  return true;
}
/*--------------------------------------*/

/*
//проверка ключа для обмена данными
bool GetAccess(byte _key[]){
  for (short i=0; i < sizeof(_key);i++){
  if (Serial.available())
  {
   packetByte = Serial.read();
   if (packetByte!=_key[i]^accessbyte)
   return false;
  }else return false;
  }
  return true;
}*/







#define FRONT_LEFT_MOTOR 6
#define FRONT_RIGHT_MOTOR 9
#define BACK_LEFT_MOTOR 10
#define BACK_RIGHT_MOTOR 11
int engineFL=0;
int engineFR=0;
int engineBL=0;
int engineBR=0;

//ПИД-регулятор
double rollSet, rollInput, rollOutput;
double pitchSet, pitchInput, pitchOutput; 
double yawSet, yawInput, yawOutput; 

//Параметры регулятора
/********************************
*          PID                  *
*       CALIBRACION             *
* kp = Proporcional             *
* ki = Integrativo              *
* kd = Derivativo               *
**********************************/
double constRollKp = 1;
double constRollKi = 0.05;
double constRollKd = 0.25;
double constPitchKp = 1;
double constPitchKi = 0.05;
double constPitchKd = 0.25;
double constYawKp = 1;
double constYawKi = 0.05;
double constYawKd = 0.25;

/*double constRollSlowKp = 1;
double constRollSlowKi = 0.05;
double constRollSlowKd = 0.25;
double constPitchSlowKp = 1;
double constPitchSlowKi = 0.05;
double constPitchSlowKd = 0.25;

double slowPitch = 5;
double slowRoll = 5;*/
/*   
  X: Pitch  
  Y: Roll   
  Z: Yaw    */
PID rollPID(&rollInput, &rollOutput, &rollSet, constRollKp, constRollKi, constRollKd, DIRECT);
PID pitchPID(&pitchInput, &pitchOutput, &pitchSet, constPitchKp, constPitchKi, constPitchKd, DIRECT);
PID yawPID(&yawInput, &yawOutput, &yawSet, constYawKp, constYawKi, constYawKd, DIRECT);

/**************
*     MPU     *
**************/

/*MPU
 * 
 * 
 * 
 */

MPU6050 mpu;
bool dmpReady = false;  // set true if DMP init was successful
uint8_t mpuIntStatus;   // holds actual interrupt status byte from MPU
uint8_t devStatus;      // return status after each device operation (0 = success, !0 = error)
uint16_t packetSize;    // expected DMP packet size (default is 42 bytes)
uint16_t fifoCount;     // count of all bytes currently in FIFO
uint8_t fifoBuffer[64]; // FIFO storage buffer

// orientation/motion vars
Quaternion q;           // [w, x, y, z]         quaternion container
VectorInt16 aa;         // [x, y, z]            accel sensor measurements
VectorInt16 aaReal;     // [x, y, z]            gravity-free accel sensor measurements
VectorInt16 aaWorld;    // [x, y, z]            world-frame accel sensor measurements
VectorFloat gravity;    // [x, y, z]            gravity vector
float euler[3];         // [psi, theta, phi]    Euler angle container
float ypr[3];           // [yaw, pitch, roll]   yaw/pitch/roll container and gravity vector


volatile bool mpuInterrupt = false;
void dmpDataReady() {
    mpuInterrupt = true;
}






/*отправка информации серверу*/
bool SendInfo(byte numberInfo){
  switch(numberInfo){
    /*
    формат ответа
    AV,*Напряжение батареи double*,  
    AP,*Процент заряда батареи double*,  
    AT,*Температура батареи double*,  
    AС,*Ток батареи double*,  
    AMXT,*Максимальная температура батареи double*,  
    AMNT,*минимальная температура батареи double*,  
    AMXV,*максимальное напряжение батареи double*,  
    AMNT,*максимальное напряжение батареи double*,  
    AMXC,*максимальный ток батареи double*,  
    DNAME,*имя устройства string*,  
    DVFW,*версия прошивки string*,  
    FH,*высота полета double*,  
    TIMEW,*время ожидания int*,  
    FPITCH,*текущий наклон double*,  
    FROLL,*текущий поворот double*,  
    FSPITCH,*set наклон double*,  
    FSROLL,*set поворот double*,  
    ...
    */
    case 0: //напряжение батареи
       Serial.print("AV,");
       Serial.println(infoBattery[0]);
    break;
    case 1: //процент заряда батареи
       Serial.print("AP,");
       Serial.println(infoBattery[1]);
    break;
    case 2: //температура батареи
       Serial.print("AT,");
       Serial.println(infoBattery[2]);
    break;
    case 3: //ток батареи
       Serial.print("AA,");
       Serial.println(infoBattery[3]);
    break;
    case 4: //максимальная температура батареи
       Serial.print("AMXT,");
       Serial.println(maxTemperatureBattery);
    break;
    case 5: //минимальная температура  батареи
       Serial.print("AMNT,");
       Serial.println(minTemperatureBattery);
    break;
    case 6: //максимальное напряжение батареи
       Serial.print("AMXV,");
       Serial.println(maxVoltageBattery);
    break;
    case 7: //минимальное напряжение батареи
       Serial.print("AMNV,");
       Serial.println(minVoltageBattery);
    break;
    case 8: //максимальный ток батареи
       Serial.print("AMXC,");
       Serial.println(maxCurrentBattery);
    break;
    case 9: //имя устройства
       Serial.print("DNAME,");
       Serial.println(nameofdevice);
    break;
    case 10: //версия прошивки
       Serial.print("DVFW,");
       Serial.println(firmware);
    break;
    case 11: //высота полета
       Serial.print("FH,");
       Serial.println(heightGain);
    break;
    case 12: //время ожидания
       Serial.print("TIMEW,");
       Serial.println(time_wait);
    break;
    case 13: //текущий наклон
       Serial.print("FPITCH,");
       Serial.println(ypr[1]);
    break;
    case 14: //текущий поворот
       Serial.print("FROLL,");
       Serial.println(ypr[2]);
    break;
    case 15: //set наклон
       Serial.print("FSPITCH,");
       Serial.println(pitchSet);
    break;
    case 16: //set поворот
       Serial.print("FSROLL,");
       Serial.println(rollSet);
    break;
    case 17: //pitch Kp
       Serial.print("PITCHKP,");
       Serial.println(constPitchKp);
    break;
    case 18: //pitchll Ki
       Serial.print("PITCHKI,");
       Serial.println(constPitchKi);
    break;
    case 19: //pitch Kd
       Serial.print("PITCHKD,");
       Serial.println(constPitchKd);
    break;
    case 20: //roll Kp
       Serial.print("ROLLKP,");
       Serial.println(constRollKp);
    break;
    case 21: //roll Ki
       Serial.print("ROLLKI,");
       Serial.println(constRollKi);
    break;
    case 22: //roll Kd
       Serial.print("ROLLKD,");
       Serial.println(constRollKd);
    break;

    case 23: //engine speed FL
       Serial.print("SPEEDFL,");
       Serial.println(engineFL);
    break;
    case 24: //engine speed FR
       Serial.print("SPEEDFR,");
       Serial.println(engineFR);
    break;
    case 25: //engine speed BL
       Serial.print("SPEEDBL,");
       Serial.println(engineBL);
    break;
    case 26: //engine speed BR
       Serial.print("SPEEDBR,");
       Serial.println(engineBR);
    break;

    case 27: //distances
       Serial.print("DISU,");
       Serial.println(distanceUp);
       Serial.print("DISD,");
       Serial.println(distanceDown);
       Serial.print("DIS1,");
       Serial.println(distance1);
       Serial.print("DIS2,");
       Serial.println(distance2);
       Serial.print("DIS3,");
       Serial.println(distance3);
       Serial.print("DIS4,");
       Serial.println(distance4);
    break;
    case 28: //distance Up
       Serial.print("DISU,");
       Serial.println(distanceUp);
    break;
    case 29: //distance down
       Serial.print("DISD,");
       Serial.println(distanceDown);
    break;
    case 30: //distance 1
       Serial.print("DIS1,");
       Serial.println(distance1);
    break;
    case 31: //distance 2
       Serial.print("DIS2,");
       Serial.println(distance2);
    break;
    case 32: //distance 3
       Serial.print("DIS3,");
       Serial.println(distance3);
    break;
    case 33: //distance 4
       Serial.print("DIS4,");
       Serial.println(distance4);
    break;


    case 34: //yaw Kp
       Serial.print("YAWKP,");
       Serial.println(constYawKp);
    break;
    case 35: //yawll Ki
       Serial.print("YAWKI,");
       Serial.println(constYawKi);
    break;
    case 36: //yaw Kd
       Serial.print("YAWKD,");
       Serial.println(constYawKd);
    break;

    case 37: //текущий поворот
       Serial.print("FYAW,");
       Serial.println(ypr[3]);
    break;
    case 38: //set наклон
       Serial.print("FSYAW,");
       Serial.println(yawSet);
    break;
    /*case 34: //minHeightNoConnect
       Serial.print("MINHNC,");
       Serial.print(minHeightNoConnect);
       Serial.print(",");
    break;
    case 35: //HeightNoConnectStep
       Serial.print("STPHNC,");
       Serial.print(HeightNoConnectStep);
       Serial.print(",");
    break;*/
    default:
    return false;
    break;
  }
  return true;
}
/*---------------------------*/



/*установка значений*/
bool SetInfo(byte numberInfo,float value){
  switch(numberInfo){
  /*
  [0-byte] - command
  
  [0-byte] - value 0 
  [0-byte] - value 1
  [0-byte] - value 2 
  [0-byte] - value 3  
  */
   
   case 0: //максимальная температура батареи
       maxTemperatureBattery=value;
    break;
    case 1: //минимальная температура температура батареи
       minTemperatureBattery=value;
    break;
    case 2: //максимальное напряжение температура батареи
       maxVoltageBattery=value;
    break;
    case 3: //минимальное напряжение температура батареи
       minVoltageBattery=value;
    break;
    case 4: //максимальный ток батареи
       maxCurrentBattery=value;
    break;
    case 5: //версия прошивки
       firmware="v"+String(value);
    break;
    case 6: //высота полета
       heightGain=value;
    break;
    case 7: //время полета
       time_wait=value;
    break;
    case 8: //set наклон
       pitchSet=value;
    break;
    case 9: //set поворот
       rollSet=value;
    break;

    case 10: //PID Pitch Kp
       constPitchKp=value;
    break;
    case 11: //PID Pitch Ki
       constPitchKi=value;
    break;
    case 12: //PID Pitch Kd
       constPitchKd=value;
    break;
    case 13: //PID Roll Kp
       constRollKp=value;
    break;
    case 14: //PID Roll Ki
       constRollKi=value;
    break;
    case 15: //PID Roll Kd
       constRollKd=value;
    break;

    //!important не рекомендуется использовать
    case 16: //engine front left
       engineFL=value;
    break;
    case 17: //engine front right
       engineFR=value;
    break;
    case 18: //engine back left
       engineBL=value;
    break;
    case 19: //engine back right
       engineBR=value;
    break;

    case 20: //update PID K pitch
       //pitchPID.SetTunings(constPitchKp, constPitchKi, constPitchKd);
    break;
    case 21: //update PID K roll
      // rollPID.SetTunings(constRollKp, constRollKi, constRollKd);
    break;

    case 22: //update PID limits pitch
        // pitchPID.SetOutputLimits(-value, value);
    break;
    case 23: //update PID limits roll
        // rollPID.SetOutputLimits(-value, value);
    break;
        case 24: //update PID limits roll
        // yawPID.SetOutputLimits(-value, value);
    break;

        case 25: //update PID K roll
      // yawPID.SetTunings(constYawKp, constYawKi, constYawKd);
    break;

    case 26: //PID Yaw Kp
       constYawKp=value;
    break;
    case 27: //PID Yaw Ki
       constYawKi=value;
    break;
    case 28: //PID Yaw Kd
       constYawKd=value;
    break;
    case 29: //set поворот
       yawSet=value;
    break;
   /* case 24: //minHeightNoConnect
         minHeightNoConnect=value;
    break;
    case 25: //HeightNoConnectStep
         HeightNoConnectStep=value;
    break;*/
    default:
    return false;
    break;
  }
  return true;
}
/*---------------------------*/

void setup() {

    // join I2C bus (I2Cdev library doesn't do this automatically)
    #if I2CDEV_IMPLEMENTATION == I2CDEV_ARDUINO_WIRE
        Wire.begin();
        TWBR = 24; // 400kHz I2C clock (200kHz if CPU is 8MHz)
    #elif I2CDEV_IMPLEMENTATION == I2CDEV_BUILTIN_FASTWIRE
        Fastwire::setup(400, true);
    #endif

  //Bluetooth
  Serial.begin(115200);




  //MPU init
  mpu.initialize();

    devStatus = mpu.dmpInitialize();

    // supply your own gyro offsets here, scaled for min sensitivity
    mpu.setXAccelOffset(-3881);
    mpu.setYAccelOffset(-4522);
    mpu.setZAccelOffset(4838);
    mpu.setXGyroOffset(25);
    mpu.setYGyroOffset(27);
    mpu.setZGyroOffset(23);
  

      if (devStatus == 0) {
        // turn on the DMP, now that it's ready
        Serial.println(F("Enabling DMP..."));
        mpu.setDMPEnabled(true);
        
        // enable Arduino interrupt detection
        Serial.println(F("Enabling interrupt detection (Arduino external interrupt 0)..."));
        attachInterrupt(0, dmpDataReady, RISING);
        mpuIntStatus = mpu.getIntStatus();

        // set our DMP Ready flag so the main loop() function knows it's okay to use it
        Serial.println(F("DMP ready! Waiting for first interrupt..."));
        dmpReady = true;

        // get expected DMP packet size for later comparison
        packetSize = mpu.dmpGetFIFOPacketSize();
    } else {
        Serial.print(F("DMP Initialization failed (code "));
        Serial.print(devStatus);
        Serial.println(F(")"));
    }


  //ПИД-регулятор
  pitchInput = 0.0;
  rollInput = 0.0;  
  pitchSet = 0.0;
  rollSet = 0.0;
  //turn the PID on
  pitchPID.SetMode(AUTOMATIC);
  rollPID.SetMode(AUTOMATIC);
  
  pitchPID.SetOutputLimits(-30, 30);
  rollPID.SetOutputLimits(-30, 30);
  //-------------------------------------------------------------------
  
  pinMode(FRONT_LEFT_MOTOR, OUTPUT);
  pinMode(FRONT_RIGHT_MOTOR, OUTPUT);
  pinMode(BACK_LEFT_MOTOR, OUTPUT);
  pinMode(BACK_RIGHT_MOTOR, OUTPUT);
    
}


//чтение пакета
int curindextowritePacket=0;

void loop() {

  
  // если ощибка инициализации не продолжать
  //if (!dmpReady) return;
  
  //проверка состояние дрона
  bool error=!CheckBattery();

  //проверка датчиков дрона
//  error=false;
  
  
    // wait for MPU interrupt or extra packet(s) available
    //while (!mpuInterrupt && fifoCount < packetSize) {
          /*int p1 = spd + (rollOutput / 2) + (pitchOutput / 2);
          int p2 = spd - (rollOutput / 2) + (pitchOutput / 2);
          int p3 = spd + (rollOutput / 2) - (pitchOutput / 2);
          int p4 = spd - (rollOutput / 2) - (pitchOutput / 2);
          
          if(p1 >= 255){
            //reduce speed so can stabalize
            spd -= (p1 - 255);
            continue;
          }
          if(p2 >= 255){
            spd -= (p2 - 255);
            continue;
          }
          if(p3 >= 255){
            spd -= (p3 - 255);
            continue;
          }
          if(p4 >= 255){
            spd -= (p4 - 255);
            continue;
          }
          
          analogWrite(FRONT_LEFT_MOTOR, p1);
          analogWrite(FRONT_RIGHT_MOTOR, p2);
          analogWrite(BACK_LEFT_MOTOR, p3);
          analogWrite(BACK_RIGHT_MOTOR, p4);*/
    //}


    /*СБОР ДАННЫХ С MPU6050*/
    // reset interrupt flag and get INT_STATUS byte
    /*mpuInterrupt = false;
    mpuIntStatus = mpu.getIntStatus();

    // get current FIFO count
    fifoCount = mpu.getFIFOCount();

    // check for overflow (this should never happen unless our code is too inefficient)
    if ((mpuIntStatus & 0x10) || fifoCount == 1024) {
        // reset so we can continue cleanly
        mpu.resetFIFO();

    // otherwise, check for DMP data ready interrupt (this should happen frequently)
    } else if (mpuIntStatus & 0x02) {
        // wait for correct available data length, should be a VERY short wait
        while (fifoCount < packetSize) fifoCount = mpu.getFIFOCount();

        // read a packet from FIFO
        mpu.getFIFOBytes(fifoBuffer, packetSize);
        
        // track FIFO count here in case there is > 1 packet available
        // (this lets us immediately read more without waiting for an interrupt)
        fifoCount -= packetSize;

        
        // display Euler angles in degrees
        mpu.dmpGetQuaternion(&q, fifoBuffer);
        mpu.dmpGetGravity(&gravity, &q);
        mpu.dmpGetYawPitchRoll(ypr, &q, &gravity);
        pitchInput = (ypr[1] * 180/M_PI);
        rollInput = (ypr[2] * 180/M_PI);
        yawInput = (ypr[3] * 180/M_PI);
        /*
        //Update Pids
        pitchPID.Compute();
        rollPID.Compute();
        */

    //}

  
  /*Установка скоростей двигателей*/
 double difference = abs(rollSet-rollInput);
 if (difference!=0){
  /*if(difference<slowRoll) {
    rollPID.SetTunings(constRollSlowKp, constRollSlowKi, constRollSlowKd);
  } else {
    rollPID.SetTunings(constRollKp, constRollKi, constRollKd);
  }*/
  rollPID.Compute();
 }

  difference = abs(pitchSet-pitchInput);
  if (difference!=0){
  /*if(difference<slowPitch) {
    pitchPID.SetTunings(constPitchSlowKp, constPitchSlowKi, constPitchSlowKd);
  } else {
    pitchPID.SetTunings(constPitchKp, constPitchKi, constPitchKd);
  }*/
  pitchPID.Compute();
 }
  difference = abs(yawSet-yawInput);
  if (difference!=0){
  /*if(difference<slowPitch) {
    pitchPID.SetTunings(constPitchSlowKp, constPitchSlowKi, constPitchSlowKd);
  } else {
    pitchPID.SetTunings(constPitchKp, constPitchKi, constPitchKd);
  }*/
  yawPID.Compute();
  }
  
  /*if (error) {
  if (heightGain>minHeightNoConnect) heightGain-=HeightNoConnectStep;
  else (heightGain<minHeightNoConnect) heightGain+=HeightNoConnectStep;
  }*/
  
  engineFL=(int)(heightGain+pitchOutput+rollOutput+yawOutput);
  engineFR=(int)(heightGain-pitchOutput+rollOutput-yawOutput);
  engineBL=(int)(heightGain+pitchOutput-rollOutput-yawOutput);
  engineBR=(int)(heightGain-pitchOutput-rollOutput+yawOutput);

  if (engineFL<0) engineFL=0;
  else if (engineFL>255) engineFL=255;

  if (engineFR<0) engineFR=0;
  else if (engineFR>255) engineFR=255;

  if (engineBL<0) engineBL=0;
  else if (engineBL>255) engineBL=255;
  
  if (engineBR<0) engineBR=0;
  else if (engineBR>255) engineBR=255;

  //analogWrite(FRONT_LEFT_MOTOR,engineFL);
  //analogWrite(FRONT_RIGHT_MOTOR,engineFR); 
  //analogWrite(BACK_LEFT_MOTOR,engineBL);
  //analogWrite(BACK_RIGHT_MOTOR,engineBR); 



  
  //передача/получение данных с сервера //bluetooth! пакеты 7 байт
  if (millis()-time_current>=time_wait && Serial.available()==0){
  //flushSerial();
  }  
  
  if (curindextowritePacket>6 && (packetByte[6]!=packetByte[0]^packetByte[1]^packetByte[2]^packetByte[3]^packetByte[4]^packetByte[5] && (packetByte[0]==0 || packetByte[0]==1)) )
  {
    if (packetByte[0]==0){ //получение информации
        if (!SendInfo(packetByte[1])){
          Serial.println("GET_ERROR");
        }
    }else if (packetByte[0]==1){
        float valueToSet = *((float*)(&packetByte[2]));
        if (!SetInfo(packetByte[1],valueToSet)){
          Serial.println("SET_ERROR");
        }
        else {
          Serial.println("SET_OK");
        }
    }else 
    {
    Serial.println("ERROR_COMMAND");
    }
    curindextowritePacket=0;
    time_current=millis();
  }
  
  if (curindextowritePacket<=6 && Serial.available()){
  packetByte[curindextowritePacket]=(byte)Serial.read();
  curindextowritePacket++;
  }else if (curindextowritePacket>6 && Serial.available()>0) {
    packetByte[0]=packetByte[1];
    packetByte[1]=packetByte[2];
    packetByte[2]=packetByte[3];
    packetByte[3]=packetByte[4];
    packetByte[4]=packetByte[5];
    packetByte[5]=packetByte[6];
    packetByte[6]=(byte)Serial.read();
  }

}
