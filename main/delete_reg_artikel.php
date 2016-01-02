<?php	include_once("../connect.php"); ?>
<?php
	$id	=	$_GET['id'];
	$sql_delete = "delete from reg_artikel where id = ".$id."";
	if(mysql_query($sql_delete)){
		header("Location:naivebyes_menu.php");
		}
		else{
			echo $sql_delete."<br / >";
			}
?>