# Blender3D Bones File: Porl-3.bones
transl ROOT_transl
0.0033 0.134 3.5358
rot_quat Body_rot
0.7075 0.7066 -0.0047 0.0062
bone Body
1.755
parent_bone NULL

  transl Body_transl
  0 1.755 0
  rot_quat Head_rot
  0.9998 0.0011 0.017 -0.0132
  bone Head
  1.6235
  parent_bone Body

  bone_end Head

  transl Body_transl
  0 1.755 0
  rot_quat Left_Shoulder_rot
  0.5125 -0.5339 -0.4603 -0.4903
  bone Left_Shoulder
  1.3687
  parent_bone Body

    transl Left_Shoulder_transl
    0 1.3687 0
    rot_quat Left_Upperarm_rot
    0.9975 0.014 -0.0029 -0.0687
    bone Left_Upperarm
    0.7618
    parent_bone Left_Shoulder

      transl Left_Upperarm_transl
      0 0.7618 0
      rot_quat Left_Hand_rot
      0.9999 0.0025 0.0001 0.0153
      bone Left_Hand
      0.8279
      parent_bone Left_Upperarm

      bone_end Left_Hand

    bone_end Left_Upperarm

  bone_end Left_Shoulder

  transl Body_transl
  0 1.755 0
  rot_quat Right_Shoulder_rot
  0.5206 -0.5273 0.4679 0.4817
  bone Right_Shoulder
  1.3803
  parent_bone Body

    transl Right_Shoulder_transl
    0 1.3803 0
    rot_quat Right_Upperarm_rot
    0.9978 0.0116 0.0025 0.0659
    bone Right_Upperarm
    0.7122
    parent_bone Right_Shoulder

      transl Right_Upperarm_transl
      0 0.7122 0
      rot_quat Right_Hand_rot
      0.9999 0.012 0.0 -0.0028
      bone Right_Hand
      0.8102
      parent_bone Right_Upperarm

      bone_end Right_Hand

    bone_end Right_Upperarm

  bone_end Right_Shoulder

bone_end Body

transl ROOT_transl
0.0022 0.1277 3.527
rot_quat Left_Thigh_rot
0.3761 -0.2115 0.5812 -0.69
bone Left_Thigh
1.6357
parent_bone NULL

  transl Left_Thigh_transl
  0 1.6357 0
  rot_quat Left_Shin_rot
  0.9956 -0.0745 0.0515 -0.0235
  bone Left_Shin
  1.7624
  parent_bone Left_Thigh

    transl Left_Shin_transl
    0 1.7624 0
    rot_quat Left_Foot_rot
    0.7407 0.5521 0.1556 -0.3498
    bone Left_Foot
    0.7297
    parent_bone Left_Shin

    bone_end Left_Foot

  bone_end Left_Shin

bone_end Left_Thigh

transl ROOT_transl
-0.0134 0.1277 3.527
rot_quat Right_Thigh_rot
0.3759 -0.2296 -0.581 0.6844
bone Right_Thigh
1.6092
parent_bone NULL

  transl Right_Thigh_transl
  0 1.6092 0
  rot_quat Right_Shin_rot
  0.9859 -0.0801 -0.1455 0.0225
  bone Right_Shin
  1.7219
  parent_bone Right_Thigh

    transl Right_Shin_transl
    0 1.7219 0
    rot_quat Right_Foot_rot
    0.7206 0.6256 -0.1888 0.2317
    bone Right_Foot
    0.7364
    parent_bone Right_Shin

    bone_end Right_Foot

  bone_end Right_Shin

bone_end Right_Thigh

