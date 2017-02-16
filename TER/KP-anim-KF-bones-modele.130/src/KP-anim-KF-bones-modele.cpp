/*****************************************************************************
File: KP-anim.cpp

Virtual Humans
Master in Computer Science
Christian Jacquemin, University Paris-Sud

Copyright (C) 2014 University Paris-Sud
This file is provided without support, instruction, or implied
warranty of any kind.  University Paris-Sud makes no guarantee of its
fitness for a particular purpose and is not liable under any
circumstances for any damages or loss whatsoever arising from the use
or inability to use this file or items derived from it.
******************************************************************************/
#include "utils-KP-bones-modele.h"
#include "udp.h"

// screen size
int height = 900;//768
int width = 1400;//1024
float near = 1.0f;

//La vitesse de la main droite
float vitesseDribble = 6;

//nombre d'os
int nombreBone = 8;
//nombre de keyframe
int nombreKF = 6;

/* Définition des paramètes dynamiques */
#define G 9.8 // m/s^2
#define B 0.2 // Coeficient Amortissement 0.8

// perspective projection
bool perspective = false;

// mesh modification
#define ANIMATION_STEP  0.001
#define ANGULAR_STEP    1

// initial time
double InitialTime;

// texture
cv::Mat image[1];
GLuint textureID[1];

//frame count
long NbFrames = 0;

// light position
GLfloat lightPosition[3] = { 20.0f , 0.0f , 40.0f };

// eye
GLfloat eyePosition[3] = { 8.0f  , -15.0f , 5.2f };//2.0

// mouse control
double mouse_pos_x = 0, mouse_pos_y = 0;
float DistanceFactor = 1.0;

// the current object
Object *bodyObject;
Object *ballObject;

// the current object
Shader *bodyShader;

GLfloat mat_specularYELLOW[] ={0.75,0.75,0.75,1.0};
GLfloat mat_ambientYELLOW[] ={1,1,0,1.0};
GLfloat mat_diffuseYELLOW[] ={0.50,0.50,0.50,1.0};
GLfloat mat_shininessYELLOW[] ={128.0};
//draw 3d grid
void Draw3DSGrid();

// Postion actuel du ballon : t, on a déjà définit la position de ballon dans le fichier .h par BallTranslation
float sphere_x = -0.77;//-0.87
float sphere_y = -1.86;//-1.86
float sphere_z =  4.5;//5.18


// Postion precedent du ballon : t-1
float sphere_ix= -0.77;//0.87
float sphere_iy= -1.86;//-1.86
float sphere_iz=  4.5;;//5.18

// Vitesse du ballon : t
float sphere_vx;
float sphere_vy;
float sphere_vz;
// Vitesse precedent du ballon : t-1

float sphere_ivx = 0.0;
float sphere_ivy = 0.0;
float sphere_ivz = -11.37;//-5.0

// accélération du ballon
float sphere_ax;
float sphere_ay;
float sphere_az;
// accélération precedent du ballon
float sphere_iax = 0.0;
float sphere_iay = 0.0;
float sphere_iaz = -G;

//Hauteur maximum du ballon
float hauteurMax = 0.0;

// Pas de temps, controler l'animation du ballon
double dt = 0.014;//0.024

//La centre de la main
float centreMain_x, centreMain_y, centreMain_z;

//La distance entre deux points sur la main
float dist_x, dist_y, dist_z;
float dist,distEuclidean;

//La distance entre la main et le ballon
float distBallon_x, distBallon_y, distBallon_z;
float distBallon,distEuclideanBallon;

//La distance sur l'axe z
float distance_z;

//parametre de rebontir
bool  rebondir = false;
//parametre de temps
double temps = 0, tempsBallon = 0, tempsMain =0;
//Le temps intervale entre deux points animation de la main
float interval;
//La vitesse de la main en tout temps et en tout lieu
float vitesse;
//Le nombre de fois d'interpolation actuel et precdent 
int cpt = 0;
int cptPrecedent = 0;
//Le nombre de fois d'exectution d'animation du ballon dans une boucle
int cptBalle = 0;
//Le nombre de fois du ballon quand le ballon touche la main
int cptDribble = 0;
//Le nombre de fois d'exectution de la fonction de la main auqnd le ballon touche la main
int cptDribble_Main =0;
//Compteur de posture quand on change a posture initial
int cptPosture = 0;
//Le nombre d'exectution de la fonction de la main pendant l'interpolation
int intervalBoucle = 0;
//La position de la precedent
float centreMain_x_precedent, centreMain_y_precedent, centreMain_z_precedent;
//parametre booleen de marche
//bool marche = false;

//La vitesse moyenne de la main
float vitesseMoyen = -11.37;
// function prototypes
int main(int argc, char **argv);

float linear_weight( float distance , float radius , int exponent );


//////////////////////////////////////////////////////////////////
// ANIMATION
//////////////////////////////////////////////////////////////////


int tab_Bones_indices[14] = { -1 , -1 , -1 , -1 , -1 , -1 , -1 , -1, -1 , -1 , -1 , -1 , -1 , -1 };
//36 est la longeur de string
char tab_Bones_ID[14][36] = { "Body" , "Head" , "Left_Shoulder" , "Left_Upperarm" , "Left_Hand" , "Right_Shoulder" , "Right_Upperarm" , "Right_Hand", "Left_Thigh" , "Left_Shin" , "Left_Foot" , "Right_Thigh" , "Right_Shin" , "Right_Foot" };
float tab_Bones_KF_a[14][6] = { 
//Body
    { 0.00 ,  0.00 , 0.00 , 0.00 , 0.00 , 0.00  }  ,
//Head 
    { 5.00 ,  12.00 , 15.00 , 12.00 , 10.00 , 8.00  }  , 
//Left_Shoulder
    { -17.03 ,  -17.03  , -17.03  , -17.03  , -17.03  , -17.03    }  ,
//Left_Upperarm
    { -106.6 , -106.6 , -106.6 , -106.6 , -106.6 , -106.6  }  , 
//Left_Hand
    { 9.997 ,  9.997 , 9.997, 9.997 , 9.997 , 9.997  }  , 
//Right_Shoulder
    { 56.00 ,  80.00 , 56.00 , 56.00, 56.00, 80.00 }  , 
//Right_Upperarm
    { 36.00 ,  36.00 , 36.00 , 36.00, 36.00, 36.00  }  ,
//Right_Hand 
    { 0.00 , -35.00 , -20.00 , 0.00, 20.00, 35.00 }  , 
//Left_Thigh
    { 30.182 , 20.10 , 0.00 , 0.00 , -20.109 , 0.00 }  , 
//Left_Shin
    { -33.182, 0.00  , 0.00 , 0.00 , 0.00, 0.00 }  , 
//Left_Foot
    { 0.00 ,  0.00 , 0.00 , 0.00 , 0.00 , 0.00 }  , 
//Right_Thigh
    { 0.00 ,  -20.00, 0.00 , 32.204 , 20.115 , 0.00 }  , 
//Right_Shin
    { 0.00 ,  0.00 , 0.00 , -34.188 , 0.00 , 0.00 }  ,
//Right_Foot
    { 0.00 ,  0.00 , 0.00 , 0.00 , 0.00 , 0.00 }  
 }; 
float tab_Bones_KF_x[14][6] = { 
    { 0.00 ,  0.00 , 0.00 , 0.00 , 0.00 , 0.00 }  , 
    { 1.00 ,  1.00 , 1.00 , 1.00 , 1.00 , 1.00 }  , 
//Left_Shoulder 
    { 1.00 ,  1.00 , 1.00 , 1.00 , 1.00 , 1.00 }  , 
//Left_Upperarm
    { 1.00 ,  1.00 , 1.00 , 1.00 , 1.00 , 1.00 }  , 
//Left_Hand
    { 1.00 ,  1.00 , 1.00 , 1.00 , 1.00 , 1.00 }  , 
//Right_Shoulder    
    { 0.00 ,  0.00 , 0.00 , 0.00 , 0.00 , 0.00 }  , 
//Right_Upperarm
    { 0.00 , -0.30 , -0.15 , 0.00 ,0.15, 0.30  }  , 
//Right_Hand 
    { 0.00 ,  1.00 , 1.00  , 0.00 ,1.00, 1.00  }  , 
//Left_Thigh
    { 0.71 ,  0.71 , 0.00 , 0.00 , 0.716  , 0.00 }  , 
//Left_Shin
    { 1.00 ,  0.00 , 0.00 , 0.00 , 0.00  , 0.00 }  , 
//Left_Foot
    { 0.00 ,  0.00 , 0.00 , 0.00 , 0.00 , 0.00 }  , 
//Right_Thigh
    { 0.00 ,  0.55 , 0.00 , 0.56 , 0.554 , 0.00 }  , 
//Right_Shin
    { 0.00 ,  0.00 , 0.00 , 1.00 , 0.00  , 0.00 }  ,
//Right_Foot
    { 0.00 ,  0.00 , 0.00 , 0.00 , 0.00  , 0.00 }  

 }; 
float tab_Bones_KF_y[14][6] = { 
    { 0.00 ,  0.00 , 0.00 , 0.00 , 0.00 , 0.00 }  , 
    { 0.00 ,  0.00 , 0.00 , 0.00 , 0.00 , 0.00 }  , 
//Left_Shoulder 
    { 0.00 ,  0.00 , 0.00 , 0.00 , 0.00 , 0.00 }  , 
//Left_Upperarm
    { 0.00 ,  0.00 , 0.00 , 0.00 , 0.00 , 0.00 }  , 
//Left_Hand
    { 0.00 ,  0.00 , 0.00 , 0.00 , 0.00 , 0.00 }  , 
//Right_Shoulder
    { 0.00 , -0.70 ,-0.30 , 0.00 , 0.30 , 0.60 }  , 
//Right_Upperarm
    { 0.00 ,  0.00 , 0.00 , 0.00 , 0.00 , 0.00 }  , 
//Right_Hand 
    { 0.00 ,  0.00 , 0.00 , 0.00 , 0.00 , 0.00 }  , 
//Left_Thigh
    { -0.335, -0.335 , 0.00 , 0.00 , -0.178 , 0.00 }  , 
//Left_Shin
    { 0.00 ,  0.00 , 0.00 , 0.00 , 0.00  , 0.00 }  , 
//Left_Foot
    { 0.00 ,  0.00 , 0.00 , 0.00 , 0.00  , 0.00 }  , 
//Right_Thigh
    { 0.00 , 0.129 , 0.00 , 0.129 , 0.129, 0.00 }  , 
//Right_Shin
    { 0.00,  0.00  , 0.00 , 0.023 , 0.00 , 0.00 }  ,
//Right_Foot
    { 0.00 ,  0.00 , 0.00 , 0.00 , 0.00  , 0.00 }  

 }; 
float tab_Bones_KF_z[14][6] = { 
    { 0.00 ,  0.00 , 0.00 , 0.00 , 0.00 , 0.00 }  , 
    { 0.00 ,  0.00 , 0.00 , 0.00 , 0.00 , 0.00 }  , 
//Left_Shoulder 
    { 0.00 ,  0.00 , 0.00 , 0.00 , 0.00 , 0.00 }  ,
//Left_Upperarm 
    { 0.00 ,  0.00 , 0.00 , 0.00 , 0.00 , 0.00 }  ,
//Left_Hand 
    { 0.00 ,  0.00 , 0.00 , 0.00 , 0.00 , 0.00 }  , 
//Right_Shoulder
    { 1.00 ,  1.00 , 1.00 , 1.00 , 1.00 , 1.00 }  , 
//Right_Upperarm
    { 1.00 ,  1.00 , 1.00 , 1.00 , 1.00 , 1.00 }  , 
//Right_Hand 
    { 0.00 ,  0.00 , 0.00 , 0.00 , 0.00 , 0.00 }  , 
//Left_Thigh
    { -0.788 , -0.788, 0.00, 0.00 , -0.738  , 0.00 }  , 
//Left_Shin
    {-0.537,  0.00 , 0.00 , 0.00 , 0.00 , 0.00 }  , 
//Left_Foot
    { 0.00 ,  0.00 , 0.00 , 0.00 , 0.00  , 0.00 }  , 
//Right_Thigh
    { 0.00 ,  0.611 , 0.00 , 0.615 , 0.611 , 0.00 }  , 
//Right_Shin
    { 0.00 ,  0.00 , 0.00 , 0.382 , 0.00 , 0.00 }  ,
//Right_Foot
    { 0.00 ,  0.00 , 0.00, 0.00 , 0.00  , 0.00 }  

 }; 


//////////////////////////////////////////////////////////////////
// KEYPOINT AND POINT WEIGHTING
//////////////////////////////////////////////////////////////////

// a keypoint weighting scheme: linear weighting

float linear_weight( float distance , float radius , int exponent ) {
  if( distance < radius ) {
    return (radius - distance) / radius;
  }
  else {
    return 0.f;
  }
}

//////////////////////////////////////////////////////////////////
// INTERACTION
//////////////////////////////////////////////////////////////////

////////////////////////////////////////
// keystroke interaction
void char_callback(GLFWwindow* window, unsigned int key)
{
  switch (key) {
  case '<':
    DistanceFactor *= 1.1;
    break;
  case '>':
    DistanceFactor /= 1.1;
    break;
  case '+':
    eyePosition[2] += 0.1;
    break;
  case '-':
    eyePosition[2] -= 0.1;
    break;
  case '1':
    bodyObject->CurrentActiveKeyPoint = 0;
    bodyObject->CurrentActiveBone = 0;
    break;
  case '2':
    bodyObject->CurrentActiveKeyPoint = 1;
    bodyObject->CurrentActiveBone = 1;
    break;
  case '3':
    bodyObject->CurrentActiveKeyPoint = 2;
    bodyObject->CurrentActiveBone = 2;
    break;
  case '4':
    bodyObject->CurrentActiveKeyPoint = 3;
    bodyObject->CurrentActiveBone = 3;
    break;
  case '5':
    bodyObject->CurrentActiveKeyPoint = 4;
    bodyObject->CurrentActiveBone = 4;
    break;
  case '6':
    bodyObject->CurrentActiveKeyPoint = 5;
    bodyObject->CurrentActiveBone = 5;
    break;
  case '7':
    bodyObject->CurrentActiveKeyPoint = 6;
    bodyObject->CurrentActiveBone = 6;
    break;
  case '8':
    bodyObject->CurrentActiveKeyPoint = 7;
    bodyObject->CurrentActiveBone = 7;
    break;
  case '9':
    bodyObject->CurrentActiveKeyPoint = 8;
    bodyObject->CurrentActiveBone = 8;
    break;
  case 'X':
    bodyObject->TabKPs[bodyObject->CurrentActiveKeyPoint].translation.x
      += ANIMATION_STEP;
    bodyObject->animate_points_in_mesh();
    bodyObject->meshChanged = true;
    break;
  case 'x':
    bodyObject->TabKPs[bodyObject->CurrentActiveKeyPoint].translation.x
      -= ANIMATION_STEP;
    bodyObject->animate_points_in_mesh();
    bodyObject->meshChanged = true;
    break;
  case 'Y':
    bodyObject->TabKPs[bodyObject->CurrentActiveKeyPoint].translation.y
      += ANIMATION_STEP;
    bodyObject->animate_points_in_mesh();
    bodyObject->meshChanged = true;
    break;
  case 'y':
    bodyObject->TabKPs[bodyObject->CurrentActiveKeyPoint].translation.y
      -= ANIMATION_STEP;
    bodyObject->animate_points_in_mesh();
    bodyObject->meshChanged = true;
    break;
  case 'Z':
    bodyObject->TabKPs[bodyObject->CurrentActiveKeyPoint].translation.z
      += ANIMATION_STEP;
    bodyObject->animate_points_in_mesh();
    bodyObject->meshChanged = true;
    break;
  case 'z':
    bodyObject->TabKPs[bodyObject->CurrentActiveKeyPoint].translation.z
      -= ANIMATION_STEP;
    bodyObject->animate_points_in_mesh();
    bodyObject->meshChanged = true;
    break;
  case 'v':
    ballObject->BallTranslation[0] +=0.1;//z
    break;
  case 'V':
    ballObject->BallTranslation[0] -=0.1;//z
    break;
  case 'b':
    ballObject->BallTranslation[1] +=0.1;//x
    break;
  case 'B':
    ballObject->BallTranslation[1] -=0.1;//x
    break;
  case 'n':
    ballObject->BallTranslation[2] +=0.1;//y
    break;
  case 'N':
    ballObject->BallTranslation[2] -=0.1;//y
    break;
  case 'l':
    lightPosition[1] -= 1;
    break;
  case 'L':
    lightPosition[1] += 1;
    break;
//Controler la vitesse de la main droite
  case 'a':
    vitesseDribble -= 0.1;
    break;
  case 'A':
    vitesseDribble += 0.1;
    break;
  case 'm':
    nombreBone = 14;
    //marche = true;
    //while(marche){
    bodyObject -> objectTranslation[1] -=0.2;
    //ballObject -> BallTranslation[1] -=0.1;//x
    //};    
    break;
  case 'M':
    //marche = false;
    nombreBone = 8;
    break;

  default:
    printf ("La touche %d nŽest pas active.\n", key);
    break;
  }
}

////////////////////////////////////////
// mouse interaction
bool drag = false;
void mouse_callback(GLFWwindow* window, int button, int action, int mods)
{
  if (!drag && action == GLFW_PRESS && button == GLFW_MOUSE_BUTTON_LEFT) {
    double x = 0;
    double y = 0;
    glfwGetCursorPos (window, &x , &y);
    mouse_pos_x = x;
    mouse_pos_y = y;
    drag = true;
  }
  if (action == GLFW_RELEASE && button == GLFW_MOUSE_BUTTON_LEFT) {
    drag = false;
  }
}


////////////////////////////////////////
// UDP message processing

void processUDPMessages( void ) {
  // reads incoming UDP messages
  if( SocketToLocalServer >= 0 ) {
    char    message[1024];
    // init message buffer: Null values
    memset(message,0x0,1024);

    // receive message
    int n = recv(SocketToLocalServer, message, 1024, 0);
    if( n >= 0 ) {
      // scans the message and extract string & float values
      char MessID[512];
      float MessVector[4];
      int keyFrame;
      printf( "Message size %d\n" , n );
      printf( "Rec.: [%s]\n" , message );

      // receives a string of format "%s %d %f %f %f"
      // built from: keypoint ID, no of Keyframe, translation of keypoint
      // scan the message and assign keypoints with corresponding translation
      sscanf( message , "%s %d %f %f %f %f" , MessID , &keyFrame ,
	      MessVector , MessVector + 1 , MessVector + 2 , MessVector + 3 );
      printf( "ID [%s] KF [%d] rot (%.3f,%.3f,%.3f,%.3f)\n" , MessID , keyFrame ,
	      MessVector[0] , MessVector[1] , MessVector[2] , MessVector[3] );

      // find current keypoint index from keypoint ID
      bodyObject->CurrentActiveKeyPoint = bodyObject->KeypointIndex( MessID );

      // find current keypoint index from keypoint ID
      bodyObject->CurrentActiveBone = bodyObject->BoneIndex( MessID );

      if( bodyObject->CurrentActiveBone >= 0
	  && (MessVector[1] || MessVector[2] || MessVector[3]) ) {
	glm::vec3 axis = glm::normalize( glm::vec3( MessVector[1] ,
						    MessVector[2] ,
						    MessVector[3] ) );
	float angle = M_PI * MessVector[0] / 180.0;

	// transforms the rotation in a 4x4 matrix
	bodyObject->TabBones[bodyObject
		   ->CurrentActiveBone].boneAnimationRotationMatrix
	  = glm::rotate( glm::mat4(1.0f), angle , axis );

	// changes the position of the points according
	// to bone rotations
	bodyObject->animate_points_in_mesh();

	// stores the mesh in the graphic board
	bodyObject->meshChanged = true;

	return;
     }

      printf("UDP message with unknown Bone or KeyPoint (%s)\n" , MessID );
      return;

    }
  }
}

//////////////////////////////////////////////////////////////////
  // keypoint interpolation
//////////////////////////////////////////////////////////////////
void KF_Interpolation( void ) {

  double t = (RealTime() - InitialTime)*vitesseDribble;//intervale de seconde, 3 est l'accélération de la main

  //printf( "%f \n" , InitialTime);
  //printf( "%f \n" , RealTime() );

  // 1 pose per second
  // KEYFRAME INDEX IS THE INTEGER NUMBER OF SECONDS
  // current frame
  int indKF = (int)floor(t) % nombreKF;//floor: la limite inférieur of t   % : prendre le modulo de 8
  //printf( "indKF:%d\n " , indKF );

  // next frame
  int indNextKF = (indKF + 1) % nombreKF;
    //printf( "indNextKF :%d\n " , indNextKF );
  cptPosture ++;////Compteur de posture quand on change a posture initial

  if (indKF == 5){

     cptPosture = 0;

  }
//Le nombre de fois d'exectution actuel  
  cpt++;
//Le nombre de fois d'exectution de la fonction de la main auqnd le ballon touche la main
  cptDribble_Main ++;
    //printf( "cptPosture :%d\n " , cptPosture );
if (indKF == 0 && cptPosture == 1 ){
        intervalBoucle = cpt-cptPrecedent;//Calculer le nombre d'execution d'une boucle quand la main revient a la position initiale
        cptPrecedent = cpt;//Le nombre de fois d'execution de boucle precedent  

      //printf( "nombre de boucle d'interpolation :%d\n" ,intervalBoucle  );
	}
  // INTERPOLATION VALUE IS THE DECIMAL OF SECONDS
  float alpha = t - floor( (int)t);

  // assigns the translation to CurrentActiveKeyPoint
  for( int ind = 0 ; ind < nombreBone ; ind++ ) {//nombreBone est le nombre de Bones
    int boneIndex = tab_Bones_indices[ind];
    //printf( "bones :%d\n" ,nombreBone  );
    /////////////////////////////// TODO ///////////////////////////
    // transforms into quaternions the indKF and indNextKF
    // angle/axis values of the 4 posed bones
    glm::quat quat1; // quaternion of indKF pose, quaternion of floating-point numbers.
    glm::quat quat2; // quaternion of indNextKF pose

    float angle1 = DEGTORAD(tab_Bones_KF_a[ind][indKF]);//Changer le dégré à radian
    quat1 = glm::angleAxis(angle1,glm::vec3(tab_Bones_KF_x[ind][indKF],
			    tab_Bones_KF_y[ind][indKF],
			    tab_Bones_KF_z[ind][indKF]));//Combiner l'angle de rotation et l'axis de rotation

    float angle2 = DEGTORAD(tab_Bones_KF_a[ind][indNextKF]);
    quat2 = glm::angleAxis(angle2,glm::vec3(tab_Bones_KF_x[ind][indNextKF],
			    tab_Bones_KF_y[ind][indNextKF],
			    tab_Bones_KF_z[ind][indNextKF]));

    /////////////////////////////// TODO ///////////////////////////
    // assigns to boneAnimationRotationMatrix of bone no boneIndex
    // the mix of quat1 and quat2 by coeficient alpha

    glm::quat quatInterpolation = glm::slerp(quat1,quat2,alpha);//fonction d'interpolation

    glm::vec3 axis = glm::axis(quatInterpolation);//Retourne l'axis de rotation de quaternion .
    float angle3 = glm::angle(quatInterpolation);//Retourne l'angle de rotation de quaternion .

    glm::vec3 NewAxis = glm::normalize(axis);//Normaliser le quaternion

    bodyObject->TabBones[boneIndex].boneAnimationRotationMatrix = glm::rotate( glm::mat4(1.0f), angle3 , NewAxis );

  }

  // changes the position of the vertices according to keypoint translations
  bodyObject->animate_points_in_mesh();
  // stores the mesh in the graphic board
  bodyObject->meshChanged = true;
}

//////////////////////////////////////////////////////////////////
// UPDATE FUNCTION
//////////////////////////////////////////////////////////////////
void updates( void ) {
  // process incoming messages from the interfaces
  processUDPMessages();

  // keypoint interpolation
  KF_Interpolation();
  
  //Animation du ballon   
  idle_function();

  // if the mesh is changed -> it is reloaded on the graphic board
  if( bodyObject->meshChanged ) {
    // 1. copy back to the point buffer
    bodyObject->copy_mesh_points();
    // 2. update the buffer for the graphic board
    bodyObject->update_buffer_points();
  }
  if( ballObject->meshChanged ) {
    // 1. copy back to the point buffer
    ballObject->copy_mesh_points();
    // 2. update the buffer for the graphic board
    ballObject->update_buffer_points();
  }

}

//////////////////////////////////////////////////////////////////
// SKELETON ANIMATION
//////////////////////////////////////////////////////////////////

void render_one_bone( Bone *bone , glm::mat4 parentModelMatrix ) {//Afficher bones
  if( !bone )
    return;

  /////////////////////////////// TODO ///////////////////////////
  // OpenGL transformations for drawing (structure)
  // local model matrix: combination of parent local matrix
  // with initial transformations (rotation and translation)

  glm::mat4 localModelMatrix = parentModelMatrix *
    bone->boneInitialTranslationMatrix * bone->boneInitialRotationMatrix;

  // computes the initial joint transformation matrices from
  // the initial rotation and translation matrices (should be
  // made once and for all in the future)

  if( bone->parentBone ) {
    /////////////////////////////// TODO ///////////////////////////
    // initial joint transformation: the initial tranformation
    // of the parents composed with local initial tranformations

    bone->initialJointTransformation
	= bone -> parentBone ->initialJointTransformation//区别
	* bone -> boneInitialTranslationMatrix
 	* bone -> boneInitialRotationMatrix;

    /////////////////////////////// TODO ///////////////////////////
    // current joint transformation: current joint transformation
    // of the parents combined with local initial transfomration and
    // animation rotation matrix

    bone->currentJointTransformation
	= bone ->  parentBone -> currentJointTransformation
	* bone -> boneInitialTranslationMatrix
 	* bone -> boneInitialRotationMatrix
	* bone -> boneAnimationRotationMatrix;

  }
  else {
    /////////////////////////////// TODO ///////////////////////////
    // local initial joint transformation

    bone->initialJointTransformation
	= bone -> boneInitialTranslationMatrix
 	* bone -> boneInitialRotationMatrix;
    /////////////////////////////// TODO ///////////////////////////
    // current joint transformation: local initial transfomration and
    // animation rotation matrix

    bone->currentJointTransformation
	= bone -> boneInitialTranslationMatrix
 	* bone -> boneInitialRotationMatrix
	* bone -> boneAnimationRotationMatrix;
  }

  // the point coordinates are in the mesh local coordinate system
  // we need to compose the current joint transformation by the
  // inverse of the initial joint transformation (for each mesh)

  /////////////////////////////// TODO ///////////////////////////
  /// calculates the inverse of the initial joint transformation

      glm::mat4 matRelative = bone -> currentJointTransformation
	*glm::inverse(bone -> initialJointTransformation);

   //glm::vec4 barycenter( 0.0f , 0.0f , 0.0f , 1.0f );
  for( int ind = 0 ; ind < MAX_MESHES ; ind++ ) {
    /////////////////////////////// TODO ///////////////////////////
    // differential transformation from current transformation
    // to initial transformation for mesh skinning
    // combines the current joint transformation by the inverse
    // of the initial joint transformation

	 bone->pointAnimationMatrix[ ind ] = matRelative;

  }


  /////////////////////////////// TODO ///////////////////////////
  // OpenGL transformations for drawing (animation)
  // combination of local model matrix and bone animation matrix
  // localModelMatrix = ???;

  localModelMatrix = localModelMatrix * bone -> boneAnimationRotationMatrix;
//bone -> boneAnimationRotationMatrix est le matrix de bone

  // bone graphical rendering
  glUniformMatrix4fv(bodyShader->uniform_object_model, 1, GL_FALSE,
		     glm::value_ptr(localModelMatrix));
  GLfloat boneColor[3] = {1,1,1};
  glUniform3fv(bodyShader->uniform_object_objectColor,
	       1 , boneColor);

  // draw triangle strips from the currently bound VAO
  // with current in-use shader
  glBindVertexArray (bone->vao);
  glDrawArrays(GL_TRIANGLES , 0 , 2 * 3 );

  // recursive call
  render_one_bone( bone->daughterBone , localModelMatrix );

  // recursive call
  render_one_bone( bone->sisterBone , parentModelMatrix );
}

void render_bones( glm::mat4 modelMatrix ) {
  // calls rendering on the root bone (the first in the table of bones)
  render_one_bone( bodyObject->TabBones , modelMatrix );
}



/* Encapsulation des fonctions matériaux */
void SetMaterial(GLfloat spec[], GLfloat amb[], GLfloat diff[], GLfloat shin[])
{
    glMaterialfv(GL_FRONT, GL_SPECULAR, spec);
    glMaterialfv(GL_FRONT, GL_SHININESS, shin);
    glMaterialfv(GL_FRONT, GL_AMBIENT, amb);
    glMaterialfv(GL_FRONT, GL_DIFFUSE, diff);
}

/* Dessin d'une grille 3D */
void Draw3DSGrid()
{

    SetMaterial(mat_specularYELLOW, mat_ambientYELLOW, mat_diffuseYELLOW, mat_shininessYELLOW);

    // Draw a 1x1 grid along the X and Z axis'
    float i;
    for( i = -50; i <= 50; i += 5)
    {
        // Start drawing some lines
        glBegin(GL_LINES);

        // Do the horizontal lines (along the x)
        glVertex3f(i - bodyObject->objectTranslation[0], -50 - bodyObject->objectTranslation[1], 0);
        glVertex3f(i - bodyObject->objectTranslation[0],  50 - bodyObject->objectTranslation[1], 0);

        // Do the vertical lines (along the z)
        glVertex3f(-50 - bodyObject->objectTranslation[0], i - bodyObject->objectTranslation[1], 0);
        glVertex3f( 50 - bodyObject->objectTranslation[0], i - bodyObject->objectTranslation[1], 0);

        // Stop drawing lines
        glEnd();
    }
}


/* Défintion de la fonction IDLE */
void idle_function()
{
    cptBalle ++;//Le nombre de fois d'exectution d'animation du ballon dans une boucle

    ////////////////////////////////////
    // Numerical integration
    sphere_vx = sphere_ivx + (sphere_iax * dt);
    sphere_vy = sphere_ivy + (sphere_iay * dt);
    sphere_vz = sphere_ivz + (sphere_iaz * dt);

    sphere_x = sphere_ix + (sphere_ivx * dt);
    sphere_y = sphere_iy + (sphere_ivy * dt);
    sphere_z = sphere_iz + (sphere_ivz * dt);

    //printf(" z: %f\n", sphere_z);

    if(cptBalle< intervalBoucle){//si la main n'est pas revenu au point initial, on calculer le hauteur maximal du ballon

        if(sphere_z > hauteurMax && rebondir){//Dans la phase de rebondir
           hauteurMax = sphere_z;
           //printf(" z Max: %f\n", hauteurMax);
        }
    }
    else if(cptBalle == intervalBoucle){//si la main revient au point initial
         //printf(" aller: %d\n", cptDribble); //Le nombre de fois du ballon quand le ballon touche la main
         //cptDribble_Main : Le nombre de fois d'exectution de la fonction de la main quand le ballon touche la main

         if((cptDribble == 1 && hauteurMax < 4.25)  || cptDribble == 0 || (cptDribble == 0 && hauteurMax > 4.75)||(cptDribble_Main > intervalBoucle+3)){
	 //si le ballon est tres bas ou le ballon n'est pas touche a la main ou l'intervale entre deux dribble est plus lent que le temps de la main revient au point initial
         dt += 0.0005;
         //printf(" cptDribble_Main: %d\n", cptDribble_Main);
         //printf(" operation: %s\n", "+++++++");
         //printf(" dt: %f\n", dt);
         }
         else if((cptDribble == 1 && hauteurMax > 4.75) || cptDribble > 1){// le ballon est tres haut ou le ballon touche plusieur fois de la main pendant le temps de la main aller retour
         dt -= 0.0005;
         //printf(" cptDribble_Main: %d\n", cptDribble_Main);
         //printf(" operation: %s\n", "-------");
	 //printf(" dt: %f\n", dt);
	 }
         hauteurMax =0.0;
        }

    if(cptBalle == intervalBoucle){

            cptDribble = 0;
       }

    if(cptBalle > intervalBoucle){
	    cptBalle = 0;
       }


    //printf("vitesse x :%.2f vitesse y: %.2fvitesse z: %.2f\n",sphere_vx,sphere_vy,sphere_vz);
    //printf("cpt: %d, position : %f\n", cptBallon,sphere_z);
///////////////////////////////////////////////////////////////////////////////
    centreMain_x = bodyObject ->handCenter_x;
    centreMain_y = bodyObject ->handCenter_y;
    centreMain_z = bodyObject ->handCenter_z;

    //printf("x: %f y: %f z: %f\n", centreMain_x,  centreMain_y,  centreMain_z);

//Calculer la distance euclidienne entre deux points animations de la main
    dist_x = centreMain_x - centreMain_x_precedent; 
    dist_y = centreMain_y - centreMain_y_precedent;
    dist_z = centreMain_z - centreMain_z_precedent;

    dist = pow(dist_x, 2) + pow(dist_y, 2)+ pow(dist_z, 2);       
    distEuclidean = sqrt(dist);
    //printf( "distEuclidean :%f \n" ,centreMain_z - centreMain_z_precedent);

//Calculer le temps intervale entre ces deux points
    double t = RealTime() - InitialTime;
    interval = t-temps;


//Mettre a jour la point precedent
//if(cptBallon % 5 ==4){
    centreMain_x_precedent = centreMain_x;
    centreMain_y_precedent = centreMain_y;
    centreMain_z_precedent = centreMain_z;

    temps = t;
//La vitesse de la main en tout temps et en tout lieu
    vitesse = distEuclidean/interval;
    //printf( "vitesse :%f \n" ,vitesse  );
//}

//Calculer la distance euclidienne entre le centre de la main et le ballon
    distBallon_x = centreMain_x - sphere_x; 
    distBallon_y = centreMain_y - sphere_y;
    distBallon_z = centreMain_z - sphere_z;

    dist = pow(distBallon_x, 2) + pow(distBallon_y, 2)+ pow(distBallon_z, 2);       
    distEuclideanBallon = sqrt(dist);

///////////////////////////////////////////////////////////////////////////////

//la distance entre la main et le ballon sur l'axe z
    distance_z =  centreMain_z - sphere_z;                

///////////////////////////////////////////////////////////////////////////////
    // Collision test

    if(sphere_z<=0){
	
        sphere_vz = -sphere_vz;
        sphere_z = sphere_iz;
	rebondir=true;//si le ballon rebondit sur le sol, il peut rebondir sur le main, sinon il peut pas

    }

    if(distEuclideanBallon <= 0.9 && rebondir && distance_z > 0){//&& sphere_z< centreMain_z

//obtenir la vitesse de la main
        sphere_vz = vitesseMoyen;//La vitesse moyenne de la main
        sphere_z = sphere_iz;
	cptDribble ++;//Le nombre de fois du ballon quand le ballon touche la main
	rebondir=false;
	cptDribble_Main = 0;
        //printf( "vitesse :%f \n" ,vitesse  );
        //printf("cpt: %d, position : %f\n", cptBallon,sphere_z);

    }

///////////////////////////////////////////////////////////////////////////////
    // Acceleration calculation

    sphere_ax = 0 - sphere_vx * B;
    sphere_ay = 0 - sphere_vy * B;
    sphere_az = -G  - sphere_vz * B;
    //printf("x: %f y: %f z: %f\n", sphere_ax,  sphere_ay,  sphere_az);

///////////////////////////////////////////////////////////////////////////////
    // System update

    sphere_ix = sphere_x;
    sphere_iy = sphere_y;
    sphere_iz = sphere_z;

    sphere_ivx = sphere_vx;
    sphere_ivy = sphere_vy;
    sphere_ivz = sphere_vz;

    sphere_iax = sphere_ax;
    sphere_iay = sphere_ay;
    sphere_iaz = sphere_az;

}

//////////////////////////////////////////////////////////////////
// DRAWING FUNCTION
//////////////////////////////////////////////////////////////////

void draw( GLFWwindow* window ) {

  NbFrames++;

  // tell GL to only draw onto a pixel if the shape is closer to the viewer
  glEnable (GL_DEPTH_TEST); // enable depth-testing
  glDepthFunc (GL_LESS); // depth-testing interprets a smaller value as "closer"

  // MVP matrices
  glm::mat4 projectionPerspMatrix; // Store the perspective projection matrix
  glm::mat4 viewPerspMatrix; // Store the view matrix
  glm::mat4 modelPerspMatrix; // Store the model matrix
/////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////Ballon///////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
  //glm::mat4 ballprojectionPerspMatrix; // Store the perspective projection matrix
  //glm::mat4 ballviewPerspMatrix; // Store the view matrix
  glm::mat4 ballmodelPerspMatrix; // Store the model matrix

  // projection matrix
  projectionPerspMatrix
    = glm::frustum(-0.512f , 0.512f , -0.384f , 0.384f , near, 200.0f);

  // Camera matrix
  viewPerspMatrix
    = glm::lookAt(
		  glm::vec3(DistanceFactor * eyePosition[0] + bodyObject->objectTranslation[0] ,
			    eyePosition[1] + bodyObject->objectTranslation[1] ,
			    eyePosition[2] + bodyObject->objectTranslation[2]), // Camera is at DistanceFactor*eyePosition
		  glm::vec3(0,0,eyePosition[2]), // and looks horizontally
		  glm::vec3(0,0,1)  // Head is up (set to 0,0,1)
		  );

  // Model matrix : a varying rotation matrix (around Oz)
  // applies mouse based rotations
  if( drag ) {
    double x = 0;
    double y = 0;
    glfwGetCursorPos (window, &x , &y);
    bodyObject->objectAngle_y += y - mouse_pos_y;
    bodyObject->objectAngle_z += x - mouse_pos_x;
    ballObject->BallobjectAngle_y += y - mouse_pos_y;
    ballObject->BallobjectAngle_z += x - mouse_pos_x;
    mouse_pos_x = x;
    mouse_pos_y = y;
    //printf("drag %.1f %.1f %.1f %.1f\n" , x,y,mouse_pos_x,mouse_pos_y);
  }

/////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////Humain///////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

  // translation of the object, important
  glm::vec3 myTranslation( bodyObject->objectTranslation[0] ,
			   bodyObject->objectTranslation[1] ,
			   bodyObject->objectTranslation[2] );
  // rotation of the object
  glm::vec3 myRotationZAxis( 0.0f , 0.0f , 1.0f);
  glm::vec3 myRotationYAxis( 0.0f , 1.0f , 0.0f);//+ bodyObject->objectTranslation[1]

  // modele matrix calculation, 1. rotation 2.translation 
  modelPerspMatrix
    =  glm::rotate( glm::mat4(1.0f),
		   (float)bodyObject->objectAngle_z/100.f ,
		   myRotationZAxis )
    * glm::rotate( glm::mat4(1.0f),
		   (float)bodyObject->objectAngle_y/100.f ,
		   myRotationYAxis )
    * glm::translate( glm::mat4(1.0f), myTranslation ); //Builds a translation 4 * 4 matrix created from a vector of 3 components.
  // output buffer cleanup 
  glClear (GL_COLOR_BUFFER_BIT | GL_DEPTH_BUFFER_BIT);


/////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////Humain///////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
  // activate shaders and sets uniform variable values
  glUseProgram (bodyShader->shader_programme);

  glBindVertexArray (bodyObject->vaoMesh);

  glUniformMatrix4fv(bodyShader->uniform_object_proj, 1, GL_FALSE,
		     glm::value_ptr(projectionPerspMatrix));
  glUniformMatrix4fv(bodyShader->uniform_object_view, 1, GL_FALSE,
		     glm::value_ptr(viewPerspMatrix));
  glUniformMatrix4fv(bodyShader->uniform_object_model, 1, GL_FALSE,
		     glm::value_ptr(modelPerspMatrix));

/////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// Dessin de la grille////////////////////////////////
    glPushMatrix();
    Draw3DSGrid();
    glPopMatrix();
/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

  glUniform3fv(bodyShader->uniform_object_light, 1, lightPosition);
  glUniform3f(bodyShader->uniform_object_eye,
	      DistanceFactor * eyePosition[0],
	      eyePosition[1],
	      eyePosition[2]);
  glUniform3fv(bodyShader->uniform_object_objectColor,
	       1 , bodyObject->objectColor);

  // draw triangle strips from the currently bound VAO
  // with current in-use shader
  glBindBuffer (GL_ELEMENT_ARRAY_BUFFER, bodyObject->vboMeshIndex);
  glDrawElements(GL_TRIANGLES, bodyObject->NbFaces * 3 ,
		 GL_UNSIGNED_INT, (GLvoid*)0);

/////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////Ballon Transformation////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

    // translation of the object
  glm::vec3 myballTranslation( ballObject->BallTranslation[0] + sphere_x + bodyObject->objectTranslation[0],
			       ballObject->BallTranslation[1] + sphere_y + bodyObject->objectTranslation[1],
			       ballObject->BallTranslation[2] + sphere_z + bodyObject->objectTranslation[2]);

  // rotation of the object, pas besoin de rotation pour le ballon
  //glm::vec3 ballRotationZAxis( 0.0f , 0.0f , 1.0f );
  //glm::vec3 ballRotationYAxis( 0.0f , 1.0f , 0.0f );

  // modele matrix calculation
  // 1. rotation 2.translation 
  ballmodelPerspMatrix
    = 
      glm::rotate( glm::mat4(1.0f),
		   (float)ballObject->BallobjectAngle_z/100.f ,
		   myRotationZAxis )
    * glm::rotate( glm::mat4(1.0f),
		   (float)ballObject->BallobjectAngle_y/100.f ,
		   myRotationYAxis )
    * glm::translate( glm::mat4(1.0f), myballTranslation);
/////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////Ballon Shader Control////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
  // activate shaders and sets uniform variable values for ball
  glUseProgram (bodyShader->shader_programme);

  glBindVertexArray(ballObject->vaoMesh);

  glUniformMatrix4fv(bodyShader->uniform_object_proj, 1, GL_FALSE,
		     glm::value_ptr(projectionPerspMatrix));
  glUniformMatrix4fv(bodyShader->uniform_object_view, 1, GL_FALSE,
		     glm::value_ptr(viewPerspMatrix));
  glUniformMatrix4fv(bodyShader->uniform_object_model, 1, GL_FALSE,
		     glm::value_ptr(ballmodelPerspMatrix));

  glUniform3fv(bodyShader->uniform_object_light, 1, lightPosition);
  glUniform3f(bodyShader->uniform_object_eye,
	      DistanceFactor * eyePosition[0],
	      eyePosition[1],
	      eyePosition[2]);
  glUniform3fv(bodyShader->uniform_object_objectColor,
	       1 , ballObject->objectColor);

/////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////Ballon //////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
 glBindBuffer (GL_ELEMENT_ARRAY_BUFFER, ballObject->vboMeshIndex);
 glDrawElements(GL_TRIANGLES, ballObject->NbFaces * 3 ,
		 GL_UNSIGNED_INT, (GLvoid*)0);


////////////////////////////////////////
  // activate shaders and sets uniform variable values
  // glUseProgram (bodyShader->shader_bone_programme);
  // glUniformMatrix4fv(bodyShader->uniform_bone_proj, 1, GL_FALSE,
  // 		     glm::value_ptr(projectionPerspMatrix));
  // glUniformMatrix4fv(bodyShader->uniform_bone_view, 1, GL_FALSE,
  // 		     glm::value_ptr(viewPerspMatrix));
  // glUniformMatrix4fv(bodyShader->uniform_bone_model, 1, GL_FALSE,
  // 		     glm::value_ptr(modelPerspMatrix));

  // draws bones and updates the model matrix for each bone
  // according to its current transformation
  glDisable (GL_DEPTH_TEST); // enable depth-testing
  render_bones( modelPerspMatrix );
//  render_bones( ballmodelPerspMatrix );
  glBindVertexArray(0); // Disable our Vertex Buffer Object
}

//////////////////////////////////////////////////////////////////
// MAIN
//////////////////////////////////////////////////////////////////

int main(int argc, char **argv) {
  ///////////////////////////////////////////////////////////
  // initial time
  InitialTime = RealTime();//InitialTime est fixe

  ///////////////////////////////////////////////////////////
  // mesh intialization
  bodyObject = new Object;
  bodyObject->init_mesh();

  // ball intialization
  ballObject = new Object;
  ballObject->init_mesh();



  ///////////////////////////////////////////////////////////
  // parses the mesh (obj format)

  if( argc >=2 ) {
    strcpy( bodyObject->MeshFileName , argv[1] );
  }
  else {
    printf( "Mesh file (Porl-3.obj):" );
    fflush( stdin );
    fgets( bodyObject->MeshFileName , STRINGSIZE , stdin );
    if( *(bodyObject->MeshFileName) == '\n' ) {
      strcpy( bodyObject->MeshFileName , "Porl-3.obj" ); ;
    }
    else {
      bodyObject->MeshFileName[ strlen( bodyObject->MeshFileName ) - 1 ] = 0;
    }
  }

  ///////////////////////////////////////////////////////////
  // parses the ball mesh (obj format)
  if( argc >=2 ) {
    strcpy( ballObject->BallMeshFileName , "ball.obj" );
  }
  else {
    printf( "Mesh file (ball.obj):" );
    fflush( stdin );
    fgets( ballObject->BallMeshFileName , STRINGSIZE , stdin );
    if( *(ballObject->BallMeshFileName) == '\n' ) {
      strcpy( ballObject->BallMeshFileName , "ball.obj" ); ;
    }
    else {
      ballObject->BallMeshFileName[ strlen( ballObject->BallMeshFileName ) - 1 ] = 0;
    }
  }
  ///////////////////////////////////////////////////////////

  strcpy( bodyObject->KPFileName , bodyObject->MeshFileName ); ;
  bodyObject->KPFileName[ strlen( bodyObject->KPFileName ) - 4 ] = 0;
  strcat( bodyObject->KPFileName , "_KP.obj" ); //concatener deux string

  printf( "Mesh file (%s)\n" , bodyObject->MeshFileName );
  printf( "KP file (%s)\n" , bodyObject->KPFileName );

  ///////////////////////////////Ballon//////////////////////////////////
  strcpy( ballObject->KPFileName , ballObject->BallMeshFileName ); ;

  printf( "Mesh file (%s)\n" , ballObject->BallMeshFileName );


////////////////////////////////////////////////////////////////////////
  FILE * fileMesh = fopen( bodyObject->MeshFileName , "r" );
  if( !fileMesh ) {
    printf( "File %s not found\n" , bodyObject->MeshFileName );
    exit(0);
  }
  bodyObject->parse_mesh( fileMesh );
  fclose( fileMesh );

  ///////////////////////////////Ballon//////////////////////////////////???
  FILE * BallfileMesh = fopen( ballObject->BallMeshFileName , "r" );
  if( !BallfileMesh ) {
    printf( "File %s not found\n" , ballObject->BallMeshFileName );
    exit(0);
  }
  ballObject->parse_mesh( BallfileMesh );
  fclose( BallfileMesh );

  // checks that the bones in the animation table are found inside the mesh
  for(int ind = 0 ; ind < 14 ; ind++ ) {//14 est le nombre totale de bone
    tab_Bones_indices[ind] = bodyObject->BoneIndex( tab_Bones_ID[ind] );
      //printf("tab_Bones_indices :%d \n",tab_Bones_indices[ind]);
  }

  // initially no animation
  for( int index = 0 ; index < 3 * bodyObject->NbFaces ; index++) {
    bodyObject->TabPoints[index].cur_x = bodyObject->TabPoints[index].x;
    bodyObject->TabPoints[index].cur_y = bodyObject->TabPoints[index].y;
    bodyObject->TabPoints[index].cur_z = bodyObject->TabPoints[index].z;
  }

  ///////////////////////////////Ballon//////////////////////////////////???
  // initially no animation
  for( int index = 0 ; index < 3 * ballObject->NbFaces ; index++) {
    ballObject->TabPoints[index].cur_x = ballObject->TabPoints[index].x;
    ballObject->TabPoints[index].cur_y = ballObject->TabPoints[index].y;
    ballObject->TabPoints[index].cur_z = ballObject->TabPoints[index].z;
  }



  ///////////////////////////////////////////////////////////
  // mesh copy into the buffers
  bodyObject->copy_mesh_points();
  bodyObject->copy_mesh_normals();
  bodyObject->copy_mesh_faces();

  ///////////////////////////////Ballon//////////////////////////////////???
  // mesh copy into the buffers
  ballObject->copy_mesh_points();
  ballObject->copy_mesh_normals();
  ballObject->copy_mesh_faces();

  ///////////////////////////////////////////////////////////
  // parses the keypoints
  FILE * fileKP = fopen( bodyObject->KPFileName , "r" );
  if( !fileKP ) {
    printf( "File %s not found, no keypoint defined for this mesh\n" ,
	    bodyObject->KPFileName );
  }
  else {
    bodyObject->parse_KP_obj( fileKP );
    fclose( fileKP );
  }

  // locates the keypoints in the mesh
  bodyObject->locate_KP_in_mesh();

  // weights the vertices on these keypoints
  bodyObject->weight_points_on_KP_in_mesh( 0.03 , 0 , &linear_weight );

  ///////////////////////////////////////////////////////////
  // start GL context and O/S window using the GLFW helper library
  if (!glfwInit ()) {
    fprintf (stderr, "ERROR: could not start GLFW3\n");
    return 1;
  }

  GLFWwindow* window
    = glfwCreateWindow (width, height, "OpenGL Frame", NULL, NULL);
  if (!window) {
    fprintf (stderr, "ERROR: could not open window with GLFW3\n");
    glfwTerminate();
    return 1;
  }
  glfwMakeContextCurrent (window);

  // Set key callback function
  glfwSetErrorCallback(error_callback);
  glfwSetKeyCallback(window, key_callback);
  glfwSetCharCallback(window, char_callback);
  glfwSetMouseButtonCallback(window, mouse_callback);

  // start GLEW extension handler
  glewExperimental = GL_TRUE;
  glewInit ();

  // get version info
  const GLubyte* renderer = glGetString (GL_RENDERER); // get renderer string
  const GLubyte* version = glGetString (GL_VERSION); // version as a string
  printf ("Renderer: %s\n", renderer);
  printf ("OpenGL version supported %s\n", version);

  ///////////////////////////////////////////////////////////
  // vertex buffer objects and vertex array for the mesh
  bodyObject->init_geometry_buffers();

  ///////////////////////////////Ballon//////////////////////////////////
  ballObject->init_geometry_buffers();

  ///////////////////////////////////////////////////////////
  // shader intialization
  bodyShader = new Shader;
  bodyShader->init_shader( (char *)"src/Mesh-display-VS.glsl" ,
			   (char *)"src/Mesh-display-FS.glsl" ,
			   (char *)"src/Bone-display-VS.glsl" ,
			   (char *)"src/Bone-display-FS.glsl" );

  ///////////////////////////////////////////////////////////
  // keypoint listing
  printf( "Keypoints " );
  for( int ind = 0 ; ind < nombreBone ; ind++ ) {
    printf( "%s " , tab_Bones_ID[ind] );//tab_ID
  }
  printf( "\n" );

  ///////////////////////////////////////////////////////////
  // UDP server initialization
  initUDP();

  ////////////////////////////////////////
  // endless rendering loop

  // the time of the previous frame
  while (!glfwWindowShouldClose (window)) {

    /* Spécification de la routine de fond */

    // draws
    draw(window);

    // updates
    updates();

    // update other events like input handling
    glfwPollEvents ();

    // put the stuff we've been drawing onto the display
    glfwSwapBuffers (window);
  }


  ////////////////////////////////////////
  // close GL context and any other GLFW resources
  glfwDestroyWindow(window);
  glfwTerminate();
  exit(EXIT_SUCCESS);
}
