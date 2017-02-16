# Blender3D Bones File: Anime_Girl_Bones.bones
transl ROOT_transl
0.0083 -0.0105 3.4294
rot_quat Lumbar_rot
0.6383 0.7698 -0.0 -0.0
bone Lumbar
0.7311
parent_bone NULL

  transl Lumbar_transl
  0 0.7311 0
  rot_quat Thoracic_rot
  -0.0 -0.0 0.9794 -0.2019
  bone Thoracic
  0.6935
  parent_bone Lumbar

    transl Thoracic_transl
    0 0.6935 0
    rot_quat Head_rot
    0.9932 -0.1162 0.0 0.0
    bone Head
    0.8554
    parent_bone Thoracic

    bone_end Head

    transl Thoracic_transl
    0 0.6935 0
    rot_quat Shoulder_L_rot
    0.3871 -0.5959 0.5492 0.4398
    bone Shoulder_L
    0.272
    parent_bone Thoracic

      transl Shoulder_L_transl
      0 0.272 0
      rot_quat Humerus_L_rot
      0.9979 0.0458 -0.0458 0.0025
      bone Humerus_L
      0.6876
      parent_bone Shoulder_L

        transl Humerus_L_transl
        0 0.6876 0
        rot_quat Radius_L_rot
        1.0 0.0039 -0.0039 0.0
        bone Radius_L
        0.8391
        parent_bone Humerus_L

          transl Radius_L_transl
          0 0.8391 0
          rot_quat Hand_L_rot
          0.9993 0.0293 -0.0213 -0.0006
          bone Hand_L
          0.6347
          parent_bone Radius_L

          bone_end Hand_L

        bone_end Radius_L

      bone_end Humerus_L

    bone_end Shoulder_L

    transl Thoracic_transl
    0 0.6935 0
    rot_quat Shoulder_R_rot
    0.3871 -0.5959 -0.5492 -0.4398
    bone Shoulder_R
    0.272
    parent_bone Thoracic

      transl Shoulder_R_transl
      0 0.272 0
      rot_quat Humerus_R_rot
      0.9979 0.0458 0.0458 -0.0025
      bone Humerus_R
      0.6876
      parent_bone Shoulder_R

        transl Humerus_R_transl
        0 0.6876 0
        rot_quat Radius_R_rot
        1.0 0.0039 0.0039 -0.0
        bone Radius_R
        0.8391
        parent_bone Humerus_R

          transl Radius_R_transl
          0 0.8391 0
          rot_quat Hand_R_rot
          0.9993 0.0293 0.0213 0.0006
          bone Hand_R
          0.6347
          parent_bone Radius_R

          bone_end Hand_R

        bone_end Radius_R

      bone_end Humerus_R

    bone_end Shoulder_R

  bone_end Thoracic

bone_end Lumbar

transl ROOT_transl
0.0083 -0.0105 3.4294
rot_quat Hip_L_rot
0.7039 -0.0 0.067 -0.7071
bone Hip_L
0.1645
parent_bone NULL

  transl Hip_L_transl
  0 0.1645 0
  rot_quat Femur_L_rot
  0.5748 -0.4518 0.4944 -0.4702
  bone Femur_L
  1.2726
  parent_bone Hip_L

    transl Femur_L_transl
    0 1.2726 0
    rot_quat Tibia_L_rot
    1.0 0.0002 -0.0039 0.0039
    bone Tibia_L
    2.109
    parent_bone Femur_L

    bone_end Tibia_L

  bone_end Femur_L

bone_end Hip_L

transl ROOT_transl
0.0083 -0.0105 3.4294
rot_quat Hip_R_rot
0.7039 -0.0 -0.067 0.7071
bone Hip_R
0.1645
parent_bone NULL

  transl Hip_R_transl
  0 0.1645 0
  rot_quat Femur_R_rot
  0.5748 -0.4518 -0.4944 0.4702
  bone Femur_R
  1.2726
  parent_bone Hip_R

    transl Femur_R_transl
    0 1.2726 0
    rot_quat Tibia_R_rot
    1.0 0.0002 0.0039 -0.0039
    bone Tibia_R
    2.109
    parent_bone Femur_R

    bone_end Tibia_R

  bone_end Femur_R

bone_end Hip_R

