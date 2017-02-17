// JavaScript Document
//登录页面验证
function check(){
	if(login.username.value==""){
		alert("请输入用户名");
		login.username.focus();
		return false;		
	}
	if(login.pwd.value==""){
		alert("请输入密码");
		login.pwd.focus();
		return false;
	}
}
//left下拉菜单
function clickList() {
  var targetId, srcElement, targetElement;
  srcElement = window.event.srcElement;
  if (srcElement.className == "active") {
     targetId = srcElement.id + "other"; 
     targetElement = document.all(targetId);
     if (targetElement.style.display == "none") {
        targetElement.style.display = "";
     } else {
        targetElement.style.display = "none";
     }
  }
}

//动态下拉菜单
function ShowTR(objImg,objTr)
{
	if(objTr.style.display == "block")
	{
		objTr.style.display = "none";
		objImg.src="../images/jia.gif";
		objImg.alt = "展开";		
	}
	else
	{
		objTr.style.display = "block";
		objImg.src="../images/jian.gif";
		objImg.alt = "折叠";		
	}
}
