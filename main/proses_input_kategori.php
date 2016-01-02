<?php	include_once("../connect.php"); ?>
<?php
	if($_POST){
		$kategori	=	$_POST['kategori'];
		
		$sql_insert2 = "insert into kategori (kamus) values ('".$kategori."')";
		//echo $sql_insert2."<br />";
		mysql_query($sql_insert2);
		
		header("Location:updateData_create.php");	
		}
?>
