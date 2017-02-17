<?php 
session_start();
    include('config.inc.php');
/*    checkLogin();
    database_connect();*/
$action=$_GET['action'];
$row='';
$do = 'add';
if($action=='rediger')
{
//	echo "<script>   b();   </script>";
	$id = $_GET['id'];//valeur id viens de book_admin.php
	$result = mysql_query("select * from ressource where IDR=".$id);
	$row = mysql_fetch_array($result);
	$do = 'mettreajour&id='.$id;
	
		
	          $idR=$row[IDR];
	          $query=mysql_query("select * from exemplaire where IDR=$idR");
	          $nombreR=intval(mysql_num_rows($query)); 
	          
	          	        
	          $query1=mysql_query("select * from livre,music where IDL=$idR or IDM=$idR");
             $result_query1=mysql_fetch_array($query1);
	        
	        	  
	          $query2=mysql_query("select * from DVD where IDd=$idR");
             $result_query2=mysql_fetch_array($query2);
	           
}
//$do passe la valeur pour db_book.php
else if($action=='consulter')
{

	$id = $_GET['id'];
	$result = mysql_query("select * from ressource where IDR=".$id);
	$row = mysql_fetch_array($result);
	$do = '';
	
	          $idR=$row[IDR];
	          $query=mysql_query("select * from exemplaire where IDR=$idR");
	          $nombreR=intval(mysql_num_rows($query)); 
	          
	          	        
	          $query1=mysql_query("select * from livre,music where IDL=$idR or IDM=$idR");
             $result_query1=mysql_fetch_array($query1);
	        
	        	  
	          $query2=mysql_query("select * from DVD where IDd=$idR");
             $result_query2=mysql_fetch_array($query2);
}
//$state = array("丢失","在库","预定","借出");
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gestion d'administrateur</title>
<link href="css/style.css" rel="stylesheet" />
<script src="js/admin_js.js"></script>
<script language="javascript">

  function a(elem){
 
   if(elem.value == 'livre'){
      document.getElementById('table1').style.display = "block";
      document.getElementById('table2').style.display = "block";
      document.getElementById('table3').style.display = "block";
      
      document.getElementById('table4').style.display = "none";
      document.getElementById('table5').style.display = "none";
      document.getElementById('table6').style.display = "none";
      document.getElementById('table7').style.display = "none";
      document.getElementById('table8').style.display = "none";
      document.getElementById('table9').style.display = "none";
      document.getElementById('table10').style.display = "none";
      document.getElementById('table11').style.display = "none";
               
}else if(elem.value == 'music'){
	   document.getElementById('table3').style.display = "block";
      document.getElementById('table4').style.display = "block";
      document.getElementById('table5').style.display = "block";
      document.getElementById('table6').style.display = "block";

      
      document.getElementById('table1').style.display = "none";
      document.getElementById('table2').style.display = "none";
      document.getElementById('table7').style.display = "none";
      document.getElementById('table8').style.display = "none";
      document.getElementById('table9').style.display = "none";
      document.getElementById('table10').style.display = "none";
      document.getElementById('table11').style.display = "none";
}else if (elem.value == 'dvd') {
	      document.getElementById('table7').style.display = "block";
	      document.getElementById('table8').style.display = "block";
	      document.getElementById('table9').style.display = "block";
	      document.getElementById('table10').style.display = "block";
	      document.getElementById('table11').style.display = "block";

         
         document.getElementById('table1').style.display = "none";
         document.getElementById('table2').style.display = "none";
         document.getElementById('table3').style.display = "none";
         document.getElementById('table4').style.display = "none";
         document.getElementById('table5').style.display = "none";
         document.getElementById('table6').style.display = "none";
	       
}

}

//  function b(){
//  	
//        document.getElementById('table6').style.display = "none";
//         document.getElementById('table12').style.display = "none";
//	}
 
</script>
</head>
	
<table width="780" height="450" border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #9CBED6; margin-top:15px;">
	<tr>
		<td align="center" valign="top">
		<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC" align="center">

<tr bgcolor="#E7E7E7">
	<td height="28"  align="center">
	<b>Ajouter ressource</b>
	</td>
</tr>
<tr align="center" bgcolor="#FAFAF1" height="22">
	<td width="100%" colspan="">

	<form name="form1" action="db_book.php?action=<?php echo $do;?>" enctype="multipart/form-data" method="post" >
	<input type="hidden" name="dopost" value="save" />
	<input type="hidden" name="channelid" value="1" />
	<input type="hidden" name="id" value="2" />
	
	  <table width="98%"  border="0" align="center" cellpadding="2" cellspacing="2" id="needset">
	  	    		    	   	    	        				  <!--*************************Titre**********************-->
	    <tr>
	      <td height="24" class="bline">
	      <table width="100%" border="0" cellspacing="0" cellpadding="0">
	        <tr>
	          <td width="90">&nbsp;Titre：</td>
	          <td>
	          	<input name="titre" type="text" id="titre" value="<?php echo $row['Titre'];?>" style="width:388px">
	          </td>
	          <td width="90"></td>
	          <td></td>
	        </tr>
	      </table></td>
	    </tr>
	    	    		    	   	    	        				  <!--*************************Annee**********************-->
	    <tr>
	      <td height="24" class="bline"> 
	      <table width="100%" border="0" cellspacing="0" cellpadding="0">

	          <tr>
	            <td width="90">&nbsp;Année：</td>
	            <td>
	              <input name="annee" type="text" id="annee" style="width:160px" value="<?php echo $row['AnneeSortie'];?>" size="16"></td>
	            <td width="90"></td>
	            <td></td>
	          </tr>
	        </table>
	
	        </td>
	    </tr>
	    		    	   	    	        				  <!--*************************Empalcement**********************-->
	    <tr>
	      <td height="24" class="bline"> 
	      <table width="100%" border="0" cellspacing="0" cellpadding="0">

	          <tr>
	            <td width="90">&nbsp;Emplacement：</td>
	            <td>
	              <input name="emplacement" type="text" id="emplacement" style="width:160px" value="<?php echo $row['Emplacement'];?>" size="16"></td>
	            <td width="90"></td>
	            <td></td>
	          </tr>
	        </table>
	
	        </td>
	    </tr>
	    	    	   	    	        				  <!--*************************Image**********************-->
	     <tr>
	      <td height="24" class="bline"> 
	      <table name='table12' id='table12' width="100%" border="0" cellspacing="0" cellpadding="0" style="display: block;">
	
	          <tr>
	            <td width="90">&nbsp;Image：</td>
	            <td>
	            			<input type="file" name="image">
	            			
	            <td width="90"></td>
	            <td></td>
	          </tr>
	        </table>
	
	        </td>
	    </tr>
	    
	    	    	   	    	        				  <!--*************************Nombre**********************-->
	    <tr>
	      <td height="24" class="bline"> 
	      <table width="100%" border="0" cellspacing="0" cellpadding="0">
	
	          <tr>
	            <td width="90">&nbsp;Nombre：</td>
	            <td>

	              <input name="nombre" type="text" id="nombre" style="width:160px" value="<?php echo $nombreR;?>" size="16"></td>
	            <td width="90"></td>
	            <td></td>
	          </tr>
	  
	        </table>
	
	        </td>
	    </tr>
	    	   	    	        				  <!--*************************Prix**********************-->
	     <tr>
	      <td height="24" class="bline"> 
	      <table width="100%" border="0" cellspacing="0" cellpadding="0">
	
	          <tr>
	            <td width="90">&nbsp;Prix：</td>
	            <td>
	              <input name="prix" type="text" id="prix" style="width:160px" value="<?php echo $row['Prix'];?>" size="16"></td>
	            <td width="90"></td>
	            <td></td>
	          </tr>
	        </table>
	
	        </td>
	    </tr>
	    
	    <!--*************************la liste menu de Type principale**********************-->
	    <tr>
	      <td height="24" class="bline">
	      	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	          <tr>
	            <td width="90">&nbsp;Type：</td>
	            <td>
	            
<!--	appler la fonction pour afficher les options cachées-->
	      <select name='type' class='type' id='type' style='width:160px'	onchange="a(this)"  >
	      <option selected="selected">--Select Type--</option>

	<?php 
	
	$result_type1 = mysql_query("select DISTINCT TYPE1 from ressourcetype");
	while($r=mysql_fetch_array($result_type1))
	{$TYPE1=$r['TYPE1'];		?>
	             	<option value="<?php echo $TYPE1;?>" ><?php echo $TYPE1;?></option>
	<?php 
	
	}
	?>
			</select>
				</td>
			</tr>
	      </table></td>
	      	  
	          
	    </tr>
	  <!--*************************les attributs pour livre**********************-->
	  
	  
	   <!--*************************Type Livre**********************-->
     <tr>
	      <td height="24" class="bline"> 
	      <table name='table1' id='table1' width="100%" border="0" cellspacing="0" cellpadding="0" style="display: none;" >
	
	          <tr>
	            <td width="90">&nbsp;TypeLivre：</td>
	            <td>
	     <select name='typelivre' id='typelivre' class="class" style='width:160px' >	
	     <option selected="selected">--Select Sous-Type Livre--</option>
	<?php 
	
	$result_type2 = mysql_query("select DISTINCT TYPE2 from ressourcetype where TYPE1='livre'");
	while($r2=mysql_fetch_array($result_type2))
	{?>
	             	<option value="<?php echo $r2['TYPE2'];?>" ><?php echo $r2['TYPE2'];;?></option>
	<?php 
	
	}
	?>
	     </select>
	          </td>
	          
	         
	          </tr>
	        </table>
	
	        </td>
	    </tr>
	    	<!--*************************Auteur**********************-->
	      <tr>
	      <td height="24" class="bline"> 
	      <table name='table2' id='table2' width="100%" border="0" cellspacing="0" cellpadding="0" style="display: none;">
	
	          <tr>
	            <td width="90">&nbsp;Auteur：</td>
	            <td>

	              <input name="auteur" type="text" id="auteur" style="width:160px" value="<?php echo  $result_query1['Auteur'];?>" size="16"></td>
	            <td width="90"></td>
	            <td></td>
	          </tr>
	  
	        </table>
	
	        </td>
	    </tr>
	   	   	    	        				  <!--*************************Editeur**********************-->
	      <tr>
	      <td height="24" class="bline"> 
	      <table name='table3' id='table3' width="100%" border="0" cellspacing="0" cellpadding="0" style="display: none;">
	
	          <tr>
	            <td width="90">&nbsp;Editeur：</td>
	            <td>
	              <input name="editeur" type="text" id="editeur" style="width:160px" value="<?php echo $result_query1['EditeurL'];echo $result_query1['EditeurM'];?>" size="16"></td>
	            <td width="90"></td>
	            <td></td>
	          </tr>
	  
	        </table>
	
	        </td>
	    </tr>
	    
	    <!--*************************les attributs pour music**********************-->
	   	    	        				  <!--*************************type Music**********************-->
     <tr>
	      <td height="24" class="bline"> 
	      <table name='table4' id='table4' width="100%" border="0" cellspacing="0" cellpadding="0" style="display: none;" >
	
	          <tr>
	            <td width="90">&nbsp;TypeMusic：</td>
	            <td>
	     <select name='typemusic' id='typemusic' class="class" style='width:160px' >	
	     <option selected="selected">--Select Sous-Type Livre--</option>
	<?php 
	
	$result_type3 = mysql_query("select DISTINCT TYPE2 from ressourcetype where TYPE1='music'");
	while($r3=mysql_fetch_array($result_type3))
	{?>
	             	<option value="<?php echo $r3['TYPE2'];?>" ><?php echo $r3['TYPE2'];;?></option>
	<?php 
	
	}
	?>
	     </select>
	          </td>
	          </tr>
	        </table>
	
	        </td>
	    </tr>
	    	   	    	        				  <!--*************************Artiste**********************-->
	      <tr>
	      <td height="24" class="bline"> 
	      <table name='table5' id='table5' width="100%" border="0" cellspacing="0" cellpadding="0" style="display: none;">

	          <tr>
	            <td width="90">&nbsp;Artiste：</td>
	            <td>
	              <input name="artiste" type="text" id="artiste" style="width:160px" value="<?php echo $result_query1['Artiste'];?>" size="16"></td>
	            <td width="90"></td>
	            <td></td>
	          </tr>
	  
	        </table>
	
	        </td>
	    </tr>
	    
	   	    	        				  <!--*************************FichierMusique**********************-->
	      <tr>
	      <td height="24" class="bline"> 
	      <table name='table6' id='table6' width="100%" border="0" cellspacing="0" cellpadding="0" style="display: none;">
	
	          <tr>
	            <td width="90">&nbsp;FichierMusique：</td>
	            <td>
	              <input name="music" type="file" id="music" style="width:160px" size="16"></td>
	            <td width="90"></td>
	            <td></td>
	          </tr>
	  
	        </table>
	
	        </td>
	    </tr>

	    <!--*************************les attributs pour dvd**********************-->
	    
	    
<!--*************************la liste menu de TypeDVD**********************-->
     	      <tr>
     <td height="24" class="bline"> 
	      <table name='table7' id='table7' width="100%" border="0" cellspacing="0" cellpadding="0" style="display: none;" >
	
	          <tr>
	            <td width="90">&nbsp;TypeDVD：</td>
	            <td>
	     <select name='typedvd' id='typedvd' class="class" style='width:160px' >	
	     <option selected="selected">--Select Sous-Type DVD--</option>
	<?php 
	
	$result_type4 = mysql_query("select DISTINCT TYPE2 from ressourcetype where TYPE1='dvd'");
	while($r4=mysql_fetch_array($result_type4))
	{?>
	             	<option value="<?php echo $r4['TYPE2'];?>" ><?php echo $r4['TYPE2'];;?></option>
	<?php 
	
	}
	?>
	     </select>
	          </td>
	          </tr>
	        </table>
	
	        </td>
	        	      </tr>
	        				  <!--*************************la fin de la liste menu de TypeDVD**********************-->
	        				  <!--*************************Réalisateur**********************-->
	       <tr>
	       <td height="24" class="bline"> 
	       <table name='table8' id='table8' width="100%" border="0" cellspacing="0" cellpadding="0" style="display: none;">

	          <tr>
	            <td width="90">&nbsp;Réalisateur：</td>
	            <td>
	              <input name="realisateur" type="text" id="realisateur" style="width:160px" value="<?php echo $result_query2['Realisateur'];?>" size="16"></td>
	            <td width="90"></td>
	            <td></td>
	          </tr>
	  
	        </table>
	
	        </td>
	    
	    </tr>
	    	        				  <!--*************************la fin de Réalisateur**********************-->
	    	        				  
	    	        				   <!--*************************Acteur**********************-->
	       <tr>
	       <td height="24" class="bline"> 
	       <table name='table9' id='table9' width="100%" border="0" cellspacing="0" cellpadding="0" style="display: none;">
	
	          <tr>
	            <td width="90">&nbsp;Acteur：</td>
	            <td>
	              <input name="acteur" type="text" id="acteur" style="width:160px" value="<?php echo $result_query2['Acteur'];?>" size="16"></td>
	            <td width="90"></td>
	            <td></td>
	          </tr>
	  
	        </table>
	
	        </td>
	    
	    </tr>
	    	        				  <!--*************************la fin de acteur**********************-->
	    	        				  <!--*************************Duree**********************-->
	       <tr>
	       <td height="24" class="bline"> 
	       <table name='table10' id='table10' width="100%" border="0" cellspacing="0" cellpadding="0" style="display: none;">
	
	          <tr>
	            <td width="90">&nbsp;Durée：</td>
	            <td>
	              <input name="duree" type="text" id="duree" style="width:160px" value="<?php echo $result_query2['Duree'];?>" size="16"></td>
	            <td width="90"></td>
	            <td></td>
	          </tr>
	  
	        </table>
	
	        </td>
	    
	    </tr>

	    	        				  <!--*************************Video**********************-->
	       <tr>
	       <td height="24" class="bline"> 
	       <table name='table11' id='table11' width="100%" border="0" cellspacing="0" cellpadding="0" style="display: none;">
	
	          <tr>
	            <td width="90">&nbsp;Vidéo(lien youtube)：</td>
	            <td>
	              <input name="video" type="text" id="video" style="width:388px" value="<?php echo $result_query2['Ressource'];?>" size="16"></td>
	            <td width="90"></td>
	            <td></td>
	          </tr>
	  
	        </table>
	
	        </td>
	    
	    </tr>

	    <!--****************************Description*******************************-->
	    <tr>
	      <td height="24" bgcolor="#F1F5F2">&nbsp;Description：</td>
	    </tr>
	    <tr>
	      <td  align="center"><textarea name="description" cols="80"
				rows="10"><?php echo $row['Description'];?></textarea>
	
				    </td>
	    </tr>
	      </table>
	<?php if($action!='consulter'){?>
	<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr>
	      <td width="45%" align="right"><input type="reset" value="Reset"></td>
	      <td width="5%" ></td>
	      <td width="45%" align="left"><input type="submit" value="Upload"></td>
	  </tr>
	
	</table>
	<?php }?>

	</form>
	</td>
</tr>
</table> 

		</td>
	</tr>
</table>