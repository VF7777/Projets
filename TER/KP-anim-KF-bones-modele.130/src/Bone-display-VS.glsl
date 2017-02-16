/*****************************************************************************
File: Mesh-display-VS.glsl

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
#version 130

// input varyings
in vec3 vp;

// uniforms
uniform mat4x4 modelMatrix;
uniform mat4x4 viewMatrix;
uniform mat4x4 projectionMatrix;

// outputs

void main () {
  // position in projection coordintates calculation for rasterizer
  gl_Position = projectionMatrix * viewMatrix * modelMatrix 
    * vec4 (vp, 1.0);
}
