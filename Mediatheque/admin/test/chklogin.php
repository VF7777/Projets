<?php
session_start();
$A_name=$_POST['name'];          //���ձ��ύ���û���
$A_pwd=$_POST['pwd'];            //���ձ��ύ������

class chkinput{                //������
   var $name; 
   var $pwd;

   function chkinput($x,$y){
     $this->name=$x;
     $this->pwd=$y;
    }

   function checkinput(){
     include("config.inc.php");   		  //��������Դ    
     $sql=mysql_query("select * from admin where name='".$this->name."' and pwd='".$this->pwd."'");
     $info=mysql_fetch_array($sql);       //��������Ա���ƺ������Ƿ���ȷ
     if($info==false){                    //�������Ա���ƻ����벻��ȷ���򵯳������ʾ��Ϣ
          echo "<script language='javascript'>alert('Le nom ou le mot de passe saisi est incorrect��');history.back();</script>";
          exit;
       }
      else{                              //�������Ա���ƻ�������ȷ���򵯳������ʾ��Ϣ
          echo "<script>alert('connecte reussi!');window.location='index.php';</script>";
		 $_SESSION[admin_name]=$info[name];
		 $_SESSION[pwd]=$info[pwd];
   }
 }
}
    $obj=new chkinput(trim($A_name),trim($A_pwd));      //��������
    $obj->checkinput();          				    //������
?>
