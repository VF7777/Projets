<?php
session_start();
$A_name=$_POST['name'];          //接收表单提交的用户名
$A_pwd=$_POST['pwd'];            //接收表单提交的密码

class chkinput{                //定义类
   var $name; 
   var $pwd;

   function chkinput($x,$y){
     $this->name=$x;
     $this->pwd=$y;
    }

   function checkinput(){
     include("config.inc.php");   		  //连接数据源    
     $sql=mysql_query("select * from admin where name='".$this->name."' and pwd='".$this->pwd."'");
     $info=mysql_fetch_array($sql);       //检索管理员名称和密码是否正确
     if($info==false){                    //如果管理员名称或密码不正确，则弹出相关提示信息
          echo "<script language='javascript'>alert('Le nom ou le mot de passe saisi est incorrect！');history.back();</script>";
          exit;
       }
      else{                              //如果管理员名称或密码正确，则弹出相关提示信息
          echo "<script>alert('connecte reussi!');window.location='index.php';</script>";
		 $_SESSION[admin_name]=$info[name];
		 $_SESSION[pwd]=$info[pwd];
   }
 }
}
    $obj=new chkinput(trim($A_name),trim($A_pwd));      //创建对象
    $obj->checkinput();          				    //调用类
?>
