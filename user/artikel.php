<?php
	if($_GET){
	?>
		<?php	include_once("../connect.php"); ?>
<?php
	$sql	=	"select kategori.* from kategori inner join artikel on kategori.id = artikel.id_kategori  where kategori.active = 1 group by kategori.id order by kamus desc";
	
?>
<?php	include_once("../template/header.php");?>
<?php	include_once("../template/sidebar_user.php");?>
<?php
		$id = $_GET['id'];
		$sql1 = "select * from artikel where id_kategori = '".$id."'";
		$query1 	=	mysql_query($sql1);
		?>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<div class="jumbotron">
	<h1>Home</h1>
			<p class="alert alert-info">Artikel</p>
			<table class="table table-bordered">
			<?php
				$query	=	mysql_query($sql);
				echo "<tr>";
				while($row = mysql_fetch_array($query)){
					echo "<td><a class='btn btn-primary' href='artikel.php?id=".$row['id']."'>".$row['kamus']."</a></td>";
					}
				echo "</tr>";
			?>
			</table>
		<table class="table table-bordered">
		<?php
		while($rok = mysql_fetch_array($query1)){
			echo "<tr><td>".$rok['artikel_sumber']."<br />".$rok['date_time']."</td></tr>";
			}
	?>
		</table>
		
		</div>
<?php	include_once("../template/footer.php"); 		
		}
		else{
			
			header("Location:home.php");
			}
?>