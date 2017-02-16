////////////////////////////////
// 2008			      //
// TD Animation 3D  //
// Université Paris 11	      //
// Mehdi AMMI - ammi@limsi.fr //
////////////////////////////////

#include"robot.h"
#include<stdio.h>

/* Fonction d'initialisation */
void InitGL(int Width, int Height)
{
    // Couleur d'effacement du buffer de couleur
    glClearColor(0.3f, 0.3f, 0.4f, 0.0f);
    
    // paramètrage du Z-buffer
    glClearDepth(1.0);
    glDepthFunc(GL_LESS);
    glEnable(GL_DEPTH_TEST);
    
    // Activation de l'éclairage
    glEnable(GL_LIGHTING);
    glEnable(GL_LIGHT0);
    glEnable(GL_LIGHT1);
    
    // Paramètrage de l'éclairage
    glLightfv(GL_LIGHT0,GL_DIFFUSE,light_diffuse_1);
    glLightfv(GL_LIGHT0,GL_POSITION,light_position_1);
    
    glLightfv(GL_LIGHT1,GL_DIFFUSE,light_diffuse_2);
    glLightfv(GL_LIGHT1,GL_POSITION,light_position_2);
    
    // Normalisation des normales
    glEnable(GL_NORMALIZE);
    
    // Activation du lissage
    glShadeModel(GL_SMOOTH);
    
    // Projection perceptive
    glMatrixMode(GL_PROJECTION);
    glLoadIdentity();
    //gluPerspective(90.0f,(GLfloat)Width/(GLfloat)Height,200.0f,200.0f);

    glMatrixMode(GL_MODELVIEW);
    
    // Initialisation du système cinématique
    InitBonesystem();
    
    // Intialisation de sequence d'animation
    Init_Keyframing();
    
    
}

/* Fonction de redimensionnement de la fenêtre */
void ReSizeGLScene(int Width, int Height)
{
   // if (Height==0)
     //   Height=1;
    
    glViewport(0, 0, Width, Height);
    
    // Projection perceptive
    glMatrixMode(GL_PROJECTION);
    glLoadIdentity();
    gluPerspective(80.0f,(GLfloat)Width/(GLfloat)Height,0.1f,1000.0f);
    //glOrtho(0.0f,(GLfloat)Width,0.0f,(GLfloat)Height,-25,25); //**

    // Sauvegarde (variables globales) de la taille de la fenêtre
    m_Width = Width;
    m_Height = Height;
    
    glMatrixMode(GL_MODELVIEW);
    
}



/* Fonction de gestion du clavier */
void keyPressed(unsigned char key, int x, int y)
{
    
    if (key == ESCAPE)
    {
        /* Eteindre la fenêtre */
        glutDestroyWindow(window);
        
        /* Sortire du programme */
        exit(0);
    }
}



GLvoid Special_key(int key, int x, int y)
{
    
    switch (key)
    {
        case GLUT_KEY_RIGHT:
            left_right+= 0.03;
            rotate_camera(left_right);
            break;
            
        case GLUT_KEY_LEFT:
            left_right-= 0.03;
            rotate_camera(left_right);
            break;
            
        case GLUT_KEY_UP:
            move_camera(0.02);
            break;
            
        case GLUT_KEY_DOWN:
            move_camera(-0.02);
            break;
        default:
            break;
    }
}

void Keyboard_key(unsigned char key, int x, int y)
{
    
    switch (key)
    {
            
            
            //////////////////////////////////////////////////
            // Navigation avec la caméra
            
            // ..
            
            //////////////////////////////////////////////////
            
        case ESCAPE :
        {
            glutDestroyWindow(window);
            exit(0);
        }
            
        default:
            break;
    }
    
    glutPostRedisplay();
    glutSwapBuffers();
    
}


void ground()
{
    
    glDisable(GL_LIGHTING);
    glColor3f(0.5,0.5,0.0);
    
    
    
    // Draw a 1x1 grid along the X and Z axis'
    float i;
    for( i = -50; i <= 50; i += 5)
    {
        // Start drawing some lines
        glBegin(GL_LINES);
        
        // Do the horizontal lines (along the X)
        glVertex3f(-50, 0, i);
        glVertex3f(50, 0, i);
        
        // Do the vertical lines (along the Z)
        glVertex3f(i, 0, -50);
        glVertex3f(i, 0, 50);
        
        // Stop drawing lines
        glEnd();
    }
    
    glEnable(GL_LIGHTING);
}

void SetMaterial(GLfloat spec[], GLfloat amb[], GLfloat diff[], GLfloat shin[])
{
    glMaterialfv(GL_FRONT, GL_SPECULAR, spec);
    glMaterialfv(GL_FRONT, GL_SHININESS, shin);
    glMaterialfv(GL_FRONT, GL_AMBIENT, amb);
    glMaterialfv(GL_FRONT, GL_DIFFUSE, diff);
}


void draw_body()
{
    //..
    glPushMatrix();
    glScalef(body_length, body_height, body_width);
    glRotatef(90,0.0,1.0,0.0);
    glutSolidCube(1);
    glPopMatrix();
}
void draw_head(){
    glPushMatrix();
    glTranslatef (0.0, (body_height+head_height)/2.0, 0.0);   //It's head
    glRotatef ((GLfloat) head, 0.0, 1.0, 0.0);
    glScalef (0.5,0.6,0.5);
    glutSolidCube (1.0);
    glPopMatrix();
}

void draw_arm(int isLeft){
    //LEFT UP ARM
    glPushMatrix();
    int left = -1;
    if(isLeft){
        glTranslatef(0.0,body_height*0.5-radius,-body_length*0.5-upArm_length*0.25);
        left = 1;
    }
    else
        glTranslatef(0.0,body_height*0.5-radius,body_length*0.5+upArm_length*0.25);
    glRotatef(upLeg.rot.z*left,0.0,0.0,1.0);//Enlever UP ARM
      glPushMatrix();
    //articulation
    
    //glRotatef(90,0.0,1.0,0.0);
    glTranslatef(0.0,0.0,-upArm_length*0.25);
    drawCylinder(radius,upArm_length*0.5);
      glPopMatrix();
    //Right UP ARM
    if(isLeft)
        glTranslatef(0.0,0.0,-upArm_length*0.5-upArm_length*0.25);
    else
        glTranslatef(0.0,0.0,upArm_length*0.5+upArm_length*0.25);
    
    glPushMatrix();
    glTranslatef(0.0,-upArm_height*0.5+radius,0.0);
    
    glScalef(upArm_length,upArm_height,upArm_width);
    glutSolidCube(1.0);
    glPopMatrix();
    
    //LEFT LOW ARM
    glTranslatef(0.0,-upArm_height,0.0);
    glPushMatrix();
    //Articulation

    glRotatef(90.0,0.0,0.0,1.0);
    glTranslatef(0.0,0.0,-upArm_length*0.5);
    drawCylinder(radius,upArm_length);

    glPopMatrix();
    
    //RIGHT LOW ARM

    glRotatef(lowLeg.rot.z*left,0.0,0.0,1.0);///Enlever LOW ARM
    glPushMatrix();
    glRotatef(90,0.0,1.0,0.0);
    glTranslatef(0.0,-lowArm_height*0.5-radius,0.0);
    glScalef(lowArm_length,lowArm_height,lowArm_width);
    glutSolidCube(1.0);
    glPopMatrix();
    
    glPopMatrix();
}

void draw_leg(int isLeft){
    //两个胯的位置
    int left = 1;
    glPushMatrix();
    if(isLeft){
        glTranslatef(0.0,-body_height*0.5-radius,-body_length*0.5+upLeg_length*0.5);
        left = -1;
    }
    else
        glTranslatef(0.0,-body_height*0.5-radius,body_length*0.5-upLeg_length*0.5);
    
    //Articulation
    glPushMatrix();
    //glRotatef(90,0.0,1.0,0.0);
    glTranslatef(0.0,0.0,-upLeg_length*0.5);
    drawCylinder(radius,upLeg_length);
    glPopMatrix();
    
    //upLeg
    glRotatef(upLeg.rot.z*left, 0.0, 0.0, 1.0);//Enlever UP LEG
    glTranslatef(upLeg.trans.x, upLeg.trans.y, upLeg.trans.z);
    
    glPushMatrix();
    glTranslatef(0.0,-upLeg_height*0.5-radius,0.0);
    glRotatef(90.0,0.0,1.0,0.0);
    glScalef(upLeg_length,upLeg_height,upLeg_width);
    glutSolidCube(1.0);
    glPopMatrix();
    
    //les genous
    
    glPushMatrix();
    glTranslatef(0.0, lowLeg.trans.y,0.0);
    //glRotatef(90.0,0.0,1.0,0.0);
    glTranslatef(0.0, 0.0, -upLeg_length*0.5);
    drawCylinder(radius,upLeg_length);
    glPopMatrix();
    
    //glTranslatef(0.0, -radius, 0.0);
    glTranslatef(lowLeg.trans.x, lowLeg.trans.y, lowLeg.trans.z);
    glRotatef(lowLeg.rot.z*left, 0.0, 0.0, 1.0);//Enlever down LEG
    glRotatef(90.0,0.0,1.0,0.0);

    glPushMatrix();
    glTranslatef(0.0,-upLeg_height*0.5-radius,0.0);
    glScalef(lowLeg_length,lowLeg_height,lowLeg_width);
    glutSolidCube(1.0);
    glPopMatrix();
    
    //glTranslatef(0.0, -2*radius, 0.0);
    glTranslatef(Effector.trans.x, Effector.trans.y, Effector.trans.z);
    axis();
    glPopMatrix();
    
    glPopMatrix();
}

void draw_robot(void)
{
    SetMaterial(mat_specularDarkBLUE, mat_ambientDarkBLUE, mat_diffuseDarkBLUE, mat_shininessDarkBLUE);
    glPushMatrix();
    draw_body();
    
    draw_head();
    
    draw_arm(1);//left arm
    draw_arm(0);//right arm
    
    draw_leg(1);
    draw_leg(0);
    
    
    
    glPopMatrix();
    
}
void drawCylinder(float radius,float height)
{
    GLUquadric* quad=gluNewQuadric();
    gluQuadricDrawStyle(quad,GLU_LINE);
    gluCylinder(quad,radius,radius,height,10,10);
}

//animation
int ComputeIK(int x, int y)
{
    // Variables locales
    float ex,ey;// Vecteur déplacement
    float d2;//公式中斜边d的平方
    float sin2,cos2;	// SINE ry COSINE de l'ANGLE 2
    float angle1,angle2;  // ANGLE 1 et 2 en RADIANS弧度
    float tan1;		// TAN de ANGLE 1
    
    // Changement de repère (inversion de l'axe Y)
    y = 765 - y - 1;// 把屏幕坐标系从左上角换到左下角的OPENGL坐标系???
    // Calcul du vecteur de déplacement
    ex = x/70 -  upLeg.trans.x;//m_UpArm.trans.x 是图像原点离opengl坐标系（0，0）点的偏移, trans.x为upLeg的x座标
    ey = y/70 -  upLeg.trans.y;//ex,ey就是poly上的x和y
    //printf("%s", "x:");
    //printf("%d\n", m_Height);
    //printf("%s", "y:");
    //printf("%f\n", ey);
    d2= pow(ex,2) + pow(ey,2);
    // Calcul du COSINE de l'ANGLE 2
    cos2 = ( d2 - pow(upLeg_height+2*radius,2) - pow(lowLeg_height+radius,2) )/ (2*(upLeg_height+2*radius)*(lowLeg_height+radius));
    //printf("%s", "cos1:");
    //printf("%f\n",d2);
    //printf("%s", "cos2:");
    //printf("%f\n", cos2);
    
    //tan输入的是斜边和邻边围成的角度，输出的是对边/邻边。反tan就是输入对边/邻边输出角。
    
    // Test d'accessible de la position spécifiée
    if (cos2 >= -1.0 && cos2 <= 1.0)
    {
        
        // Calcul de l'ANGLE 2
        angle2 = acos (cos2);//求出德尔塔2的角度
        // Application de l'angle à LowArm (conversion en degrée)
        
        lowLeg.rot.z = RADTODEG(angle2);
        
        // Calcul du SINE de l'ANGLE 2
        sin2 = sin (angle2);
        
        // Calcul de la tangente de l'ANGLE 1
        tan1 = ( ( ((upLeg_height+2*radius)+((lowLeg_height+radius) * cos2) )*ey) -((lowLeg_height+radius)*sin2*ex) ) /
        ((lowLeg_height*sin2*ey) + ((upLeg_height+2*radius)+((lowLeg_height+radius)*cos2))*ex);
        //将两个角度带入tan的和差化积公式求出此公式
        
        angle1 = atan (tan1);
        
        upLeg.rot.z = RADTODEG(angle1);//float转换成degree
        
        
        //lowLeg.rot.z = 30;
        
        // upLeg.rot.z = 30;//float转换成degree
        return TRUE;

    }
    else{
        
        return FALSE;//cos函数的范围是[-1,1]
    }
    
}

// Fonction de sauvegarde des états de la souris et du système cinématique au moment du clique
void processMouse(int button, int state, int x, int y)
{
    // Sauvegarde du bouton (droit, gauche, milieu)
    m_boutton = button;
    
    // Sauvegarde de la position de la souris et de l'orientation des segment pour la gestion continue des angles
    m_mousepos_x = x;
    m_Grab_UPArm_Rot_Z = upLeg.rot.z;
    m_Grab_LowArm_Rot_Z = lowLeg.rot.z;
}
// Fonction d'interaction : choix de l'opération à faire (cinématique directe / inverse)
void processMouseActiveMotion(int x, int y)
{
    
    switch (m_boutton)
    {
            
            // Cinématique inverse
        case GLUT_LEFT_BUTTON : // Manipulation par cinématique inverse
            
            if (ComputeIK(x,y))
                DrawGLScene();
            printf("%s", "x:");
            printf("%d\n", x);
            
            printf("%s", "y:");
            printf("%d\n", y);
            break;
            
            // Cinématique directe
        case GLUT_MIDDLE_BUTTON : // Manipulation directe du segment UpArm
            
            upLeg.rot.z = m_Grab_UPArm_Rot_Z + ((float)ROTATE_SPEED * (m_mousepos_x - x ));
            DrawGLScene();
            
            break;
            
        case GLUT_RIGHT_BUTTON : // Manipulation durecte du segment LowArm
            
            lowLeg.rot.z = m_Grab_LowArm_Rot_Z + ((float)ROTATE_SPEED * ( m_mousepos_x - x));
            DrawGLScene();
            /*printf("%s", "m_mousepos_x ");
            printf("%d\n", m_mousepos_x );
            
            printf("%s", "x:");
            printf("%d\n", x);*/
            break;
    }
    
    
}



// Fonction gérant le Keyframing
void Idle()
{
    
    // Incrémentation de la varaible temps (si l'animation et trop rapide diminuer le pas d'incrémentation)
    time+=1.5;
    
    
    // Variables intérmédiares entre la fonction de Keyframing et la fonction de cinématique inverse
    int X,Y,Z;
    //Effector.rot.
    // Intérpolation linéaire
    SolveLinear(time,&X,&Y,&Z);
    
    // Interpolation Hérmité
    //SolveTCB(time,&X,&Y,&Z);
    
    // Fonction de calcul de la cinématique
    ComputeIK(X,Y);
    
    // Dessin de la scène
    DrawGLScene();
}


void Init_Keyframing()
{
    
    
    // vairialbe temps
    time = 0;
    
    // Paramètes de l'interpolation
    float tension = 0.0;
    float continuity = 0.0;
    float bias = 0.0;
    
    // Keyframe 1
    TabKey[0].Pos.x = 50.0;
    TabKey[0].Pos.y = 50.0;
    TabKey[0].Pos.z = 0.0;
    TabKey[0].Time = 0.0;
    TabKey[0].tension = tension;
    TabKey[0].continuity = continuity;
    TabKey[0].bias = bias;
    
    // Keyframe 2
    TabKey[1].Pos.x = 300.0;
    TabKey[1].Pos.y = 70.0;
    TabKey[1].Pos.z = 0.0;
    TabKey[1].Time = 100.0;
    TabKey[1].tension = tension;
    TabKey[1].continuity = continuity;
    TabKey[1].bias = bias;
    
    // Keyframe 3
    TabKey[2].Pos.x = 450.0;
    TabKey[2].Pos.y = 400.0;
    TabKey[2].Pos.z = 0.0;
    TabKey[2].Time = 200.0;
    TabKey[2].tension = tension;
    TabKey[2].continuity = continuity;
    TabKey[2].bias = bias;
    
     // Keyframe 4
    TabKey[3].Pos.x = 50.0;
    TabKey[3].Pos.y = 250.0;
    TabKey[3].Pos.z = 0.0;
    TabKey[3].Time = 400.0;
    TabKey[3].tension = tension;
    TabKey[3].continuity = continuity;
    TabKey[3].bias = bias;
    
    // Keyframe 5
    TabKey[4].Pos.x = 50.0;
    TabKey[4].Pos.y = 50.0;
    TabKey[4].Pos.z = 0.0;
    TabKey[4].Time = 500.0;
    TabKey[4].tension = tension;
    TabKey[4].continuity = continuity;
    TabKey[4].bias = bias;
    
   
     // Keyframe 6
     TabKey[5].Pos.x = 200.0;
     TabKey[5].Pos.y = 50.0;
     TabKey[5].Pos.z = 0.0;
     TabKey[5].Time = 550.0;
     TabKey[5].tension = tension;
     TabKey[5].continuity = continuity;
     TabKey[5].bias = bias;
     
}

/* Focntion de dessin */
void DrawGLScene()
{
    // Effacement du buffer de couleur et de profondeur
    glClear(GL_COLOR_BUFFER_BIT | GL_DEPTH_BUFFER_BIT);
    glLoadIdentity();
    
    
    //////////////////////////////////////////////////
    // La camera
    // Navigation
    //...
    cam_pos_y = radius + upLeg_height + radius*2 + lowLeg_height ;
    //cam_pos_y = 0;
    cam_pos_x = 45;
    cam_pos_z =20;
    gluLookAt(cam_pos_x, cam_pos_y ,cam_pos_z,cam_look_x,5.0,cam_look_z,0.0,1.0,0.0);
    
    //////////////////////////////////////////////////
    // Le sol
    
    glPushMatrix();
    ground();
    glPopMatrix();
    
    /////////////////////////////d/////////////////////
    // Le robot
    glPushMatrix();
	   robot_height = body_height/2.0 + upLeg_height  + lowLeg_height + 4*radius;
    
	   glTranslatef(0, robot_height , 0);
    
	   glRotatef(0,0,1,0);
    
	   draw_robot();
    glPopMatrix();
    
    
    // Permutation des buffers et rafréchissement de l'image
    glutSwapBuffers();
    glutPostRedisplay();
    
   /* printf("%s", "x:");
    printf("%f\n", upLeg.rot.x);
    
    printf("%s", "y:");
    printf("%f\n", upLeg.rot.y);
    
    printf("%s", "z:");
    printf("%f\n", upLeg.rot.z);*/
    
}
// Fonction d'intérpolation linéaire
void SolveLinear(float t, int *x, int *y, int *z)
{
    
    // Déclaration des Keyframes utilisés
    Key* CurKey, *NextKey;
    
    // Varaible d'incrémentation
    int i ;
    
    // Taille du tableau de Keyframe
    const int NumKeys = ((double)sizeof(TabKey))/((double)sizeof(Key));//TabKey.Count();
    const int NumKeysMinusOne = NumKeys-1;
    //printf("test");
    
    // Boucle de parcours des Keyframes
    for ( i = 0 ; i <  NumKeys ; i++ )
    {
        //Obtention de la prochaine clé : NextKey
        NextKey =  &TabKey[i];
        
        if ( t <  NextKey-> Time )
        {
            //Obtention de la clé actuelle : CurKey
            // Cas où i = 0
            if ( i == 0 )
                CurKey = &TabKey[NumKeysMinusOne];
            else
                // Cas géneral
                CurKey = &TabKey[i-1];
            
            // Variable d'interpolation
            const float Coeff = ( t - CurKey->Time) / ( NextKey->Time - CurKey->Time );
            
            // Calcul de l'intérpolation via l'équation globale
            *x = CurKey->Pos.x + Coeff * ( NextKey->Pos.x - CurKey->Pos.x );
            *y = CurKey->Pos.y + Coeff * ( NextKey->Pos.y - CurKey->Pos.y );
            *z = CurKey->Pos.z + Coeff * ( NextKey->Pos.z - CurKey->Pos.z );
            break;
        }
        
    }
    
}

void axis(){
    glPushMatrix();
    //glTranslatef(0.0,0.0,1.0);
    glScalef(200.0,200.0,200.0);
    
    glBegin(GL_LINES);
    glColor3f(1.0f, 0.0f, 0.0f);
    glVertex3f(-0.2f,  0.0f, 0.0f);
    glVertex3f( 0.2f,  0.0f, 0.0f);
    glVertex3f( 0.2f,  0.0f, 0.0f);
    glVertex3f( 0.15f,  0.04f, 0.0f);
    glVertex3f( 0.2f,  0.0f, 0.0f);
    glVertex3f( 0.15f, -0.04f, 0.0f);
    glColor3f(0.0f, 1.0f, 0.0f);
    glVertex3f( 0.0f,  0.2f, 0.0f);
    glVertex3f( 0.0f, -0.2f, 0.0f);
    glVertex3f( 0.0f,  0.2f, 0.0f);
    glVertex3f( 0.04f,  0.15f, 0.0f);
    glVertex3f( 0.0f,  0.2f, 0.0f);
    glVertex3f( -0.04f,  0.15f, 0.0f);
    glColor3f(0.0f, 0.0f, 1.0f);
    glVertex3f( 0.0f,  0.0f,  0.2f);
    glVertex3f( 0.0f,  0.0f, -0.2f);
    glVertex3f( 0.0f,  0.0f, 0.2f);
    glVertex3f( 0.0f,  0.04f, 0.15f);
    glVertex3f( 0.0f, 0.0f, 0.2f);
    glVertex3f( 0.0f, -0.04f, 0.15f);
    glEnd();
    glPopMatrix();
}

// Fonction d'initilisation du système cinématique
void ResetBone(t_Bone *bone, float ox, float oy, float oz, float tx, float ty, float tz)
{
    
    // Initilisation de l'orientation
    bone->rot.x = ox;
    bone->rot.y = oy;
    bone->rot.z = oz;
    
    // Initialisation de la position
    bone->trans.x = tx;
    bone->trans.y = ty;
    bone->trans.z = tz;
}


// Initilisation du système cinématique
void InitBonesystem()
{
    //float upleg = radius + upLeg_height + radius*2 + lowLeg_height;
    
    // Initilisation de upLeg
    ResetBone(&upLeg, 0,0.0,0.0, 0.0, 0.0 ,0.0);
    //ResetBone(&upLeg_right, 0,0.0,0.0, 0.0, 0.0 ,0.0);
    
    // Initilisation lowLeg
    ResetBone(&lowLeg, 0 ,0.0,0.0, 0.0 ,-upLeg_height-2*radius,0.0);
    //ResetBone(&lowLeg_right, 0,0.0,0.0, 0.0 ,-upLeg_height,0.0);
    // Initilisation de Effector
    ResetBone(&Effector,0.0,0.0,0.0, 0.0, -lowLeg_height-radius, 0.0);
    //ResetBone(&Effector_right,0.0,0.0,0.0, 0.0, -lowLeg_height, 0.0);
}

//*************navigation du caméra
// change la position et le vecteur vision
void move_camera(double speed)
{
    vect_x = cam_look_x - cam_pos_x;
    vect_z = cam_look_z - cam_pos_z;
    
    cam_pos_x += vect_x * speed;
    cam_pos_z += vect_z * speed;
    
    cam_look_x += vect_x * speed;
    cam_look_z += vect_z * speed;
}


// change le vecteur vision
void rotate_camera(double speed)
{
    vect_x = cam_look_x - cam_pos_x;
    vect_z = cam_look_z - cam_pos_z;
    
    // Calculate the sine and cosine of the angle once
    float cosTheta = (float)cos(speed);
    float sinTheta = (float)sin(speed);
    
    double new_x = sqrt(pow(vect_x,2) + pow(vect_z,2)) * cosTheta;
    double new_z = sqrt(pow(vect_x,2) + pow(vect_z,2)) * sinTheta;
    
    cam_look_x = cam_pos_x + new_x;
    cam_look_z = cam_pos_z + new_z;
}




int main(int argc, char **argv)
{
    // Pointeurs vers l'application
    glutInit(&argc, argv);
    
    /*  Activation des buffers :
     Double buffer
     RGBA color
     Alpha
     Depth buffer */
    glutInitDisplayMode(GLUT_RGBA | GLUT_DOUBLE | GLUT_ALPHA | GLUT_DEPTH);
    
    /* Création de la fenêtre */
    glutInitWindowSize(1024, 765);
    
    /* Positionnement de la fenêtre */
    glutInitWindowPosition(200, 200);
    
    /* Ouverture de la fenêtre */
    window = glutCreateWindow("TD Animation 3D");
    
    /* Spécification de la fontion de dessin */
    glutDisplayFunc(DrawGLScene);
    
    /* Spécification de la routine de fond */
    
    //glutIdleFunc(idle_function);
    
    /* Spécification de la fontion de redimensionnement */
    glutReshapeFunc(ReSizeGLScene);
    
    /* Spécification de la fontion de de gestion du clavier */
    glutKeyboardFunc(Keyboard_key);
    
    /* Spécification de la fontion de la souris : boutons appuyés */
    glutMouseFunc(processMouse);
    
    /* Spécification de la fontion de la souris : boutons appuyés avec mouvement */
    glutMotionFunc(processMouseActiveMotion);
    
    /* Spécification de la fontion special de gestion du clavier */
    
    glutSpecialFunc(Special_key);
    
    /* Spécification de la fontion gestion de l'animation */
    //glutIdleFunc(Idle);
    
    /* Intitialisation des paramètres de l'affichage et de la fenêtre */
    InitGL(640, 480);
    
    
    /* Lancement de la boucle OpenGL */
    glutMainLoop();
    
    return 1;
}

