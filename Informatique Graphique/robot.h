////////////////////////////////
// 2008			      //
// TD Animation 3D            //
// Université Paris 11	      //
// Mehdi AMMI - ammi@limsi.fr //
////////////////////////////////

#include <GLUT/glut.h>    // Header pour GLUT
#include <OPENGL/gl.h>	// Header pour OpenGL
#include <OPENGL/glu.h>	// Header pour GLu
#include <stdlib.h>     // Heard  Utilitaire général
#include <stdio.h>      // Header pour les fonctions entrées/sorties
#include <math.h>       // Header pour les fonctions mathèmatiques#include <math.h>       // Header fonctions mathématiques

/* Postion de la source de lumière */

GLfloat light_position_1[] = {0.0f,20.0f,-15.0f, 0.0f};
GLfloat light_diffuse_1[] = {1.0, 1.0, 1.0, 0.0};

GLfloat light_position_2[] = {0.0f,30.0f,30.0f, 0.0f};
GLfloat light_diffuse_2[] = {1.0, 1.0, 1.0, 0.0};

/* Definition matériaux */

GLfloat mat_specularBLUE[] ={0.05,0.05,0.75,1.0};
GLfloat mat_ambientBLUE[] ={0,0,1,1.0};
GLfloat mat_diffuseBLUE[] ={0.50,0.50,0.50,1.0};
GLfloat mat_shininessBLUE[] ={128.0};

GLfloat mat_specularDarkBLUE[] ={0.05,0.05,0.75,1.0};
GLfloat mat_ambientDarkBLUE[] ={0,0,1,1.0};
GLfloat mat_diffuseDarkBLUE[] ={0.40,0.40,0.40,1.0};
GLfloat mat_shininessDarkBLUE[] ={128.0};

GLfloat mat_specularLightBLUE[] ={0.05,0.05,0.75,1.0};
GLfloat mat_ambientLightBLUE[] ={0,0,1,1.0};
GLfloat mat_diffuseLightBLUE[] ={0.90,0.90,0.90,1.0};
GLfloat mat_shininessLightBLUE[] ={128.0};


GLfloat mat_specularGREEN[] ={0.633, 0.727811, 0.633,1.0};
GLfloat mat_ambientGREEN[] ={0.1215, 0.2745, 0.1215,1.0};
GLfloat mat_diffuseGREEN[] ={0.27568, 0.31424, 0.27568,1.0};
GLfloat mat_shininessGREEN[] ={128.0};

GLfloat mat_specularYELLOW[] ={0.0,0.0,0.0,1.0};
GLfloat mat_ambientYELLOW[] ={1,0.7,0.,1.0};
GLfloat mat_diffuseYELLOW[] ={0.50,0.50,0.50,1.0};
GLfloat mat_shininessYELLOW[] ={128.0};

GLfloat mat_specularRED[] ={0.75,0.75,0.75,1.0};
GLfloat mat_ambientRED[] ={1.0,0.0,0.0,1.0};
GLfloat mat_diffuseRED[] ={0.8,0.50,0.50,1.0};
GLfloat mat_shininessRED[] ={128.0};

GLfloat mat_specularORANGE[] ={0.75,0.75,0.75,1.0};
GLfloat mat_ambientORANGE[] ={0.8,0.5,0.0,1.0};
GLfloat mat_diffuseORANGE[] ={1.0,0.5,0.0,1.0};
GLfloat mat_shininessORANGE[] ={128.0};

/* Paramètres des articulations DDL*/
static float foot=0, leg = 0, head=0;
float radius = 1;

/*Paramètres du robot*/

float body_length = 8, body_width = 5, body_height = 10;
float head_length = 2.5, head_height = 2.5, head_width = 2.5;
float upArm_length = 2.5, upArm_height = 7, upArm_width = 2.5;
float lowArm_length = 2.5 , lowArm_height = 4, lowArm_width = 1;
float upLeg_length = 3.5, upLeg_height = 7, upLeg_width = 1.5;
float lowLeg_length = 3.5, lowLeg_height = 7, lowLeg_width = 1.5;
float robot_height;




/* Paramètres caméra de navigation */

float up_down = 0.0, left_right = -1.57;

float cam_pos_x;
float cam_pos_y;

float cam_pos_z;
float cam_look_x = 0.0;
float cam_look_z = 0.0;
float vect_x = 0.0;
float vect_z = 0.0;


/* code ASCII pour la touche escape*/

#define ESCAPE 27
#define SPACE 32

/* Idantifiant de la fenêtre GLUT */

int window;


/* Headers */

void Special_key(int key, int x, int y);
void Keyboard_key(unsigned char key, int x, int y);
void ground();
void SetMaterial(GLfloat spec[], GLfloat amb[], GLfloat diff[], GLfloat shin[]);
void axis();
void draw_robot();
void drawCylinder(float radius,float height);
void draw_head();
void draw_body();
void draw_arm(int isLeft);
void draw_leg(int isLeft);

void move_camera(double speed);
void rotate_camera(double speed);

#define TRUE 1
#define FALSE 0


// Facteur permetttant de la manipulation de la vitesse de rotation
#define ROTATE_SPEED		1.0		// SPEED OF ROTATION

// Transfomation Degrée <-> Radian
#define DEGTORAD(A)	((A * M_PI) / 180.0f)
#define RADTODEG(A)	((A * 180.0f) / M_PI)

// Structure du vecteur
typedef struct
{
    float x,y,z;
} tVector;


// Structure des segments
typedef struct
{	// Orientation du segment
    tVector	rot;
    // Position du segment
    tVector	trans;
} t_Bone;


// Structure pour les Keyframes
typedef struct
{
    tVector Pos; //Vecteur 3D
    float Time; //Temps de la clé
    float tension;
    float continuity;
    float bias;
}Key;



// Varialbes


// Déclaration des segments de la structure cinématique
t_Bone upLeg, lowLeg, Effector;
//t_Bone upLeg_left, lowLeg_left, Effector_left;
//t_Bone upLeg_right, lowLeg_right, Effector_right;

// Sauvegardes
float m_Grab_UPArm_Rot_Z, m_Grab_LowArm_Rot_Z;
float m_ModelScale;
int m_Width,m_Height;
int m_boutton = 0;
int m_mousepos_x = 0;


// Variables pour l'animation par Keyframing
Key TabKey[5];
tVector Pos;
float time = 0.02;
int v = 0;
// Entêtes des fonctions
void InitGL(int Width, int Height)	;
void ReSizeGLScene(int Width, int Height);
void DrawGLScene();
void keyPressed(unsigned char key, int x, int y) ;
void processMouse(int button, int state, int x, int y);
void processMouseActiveMotion(int x, int y);
void Idle();
void ResetBone(t_Bone *bone, float ox, float oy, float oz, float tx, float ty, float tz);
void InitBonesystem();
void Objects_List();

void Draw_animation_sequence();
void Init_Keyframing();
void SolveLinear(float t, int *x, int *y, int *z);
float H0(float t);
float H1(float t);
float H2(float t);
float H3(float t);
void SolveTCB ( float t, int *x, int *y, int *z);

