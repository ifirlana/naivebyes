<?php	include_once("../connect.php"); ?>
<?php
	$sql	=	"select kategori.* from kategori where kategori.active = 1 group by kategori.id order by kamus desc";
?>
<?php	include_once("../template/header.php");?>
<?php	include_once("../template/sidebar_user.php");?>
	 <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div class='jumbotron'>	
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
			</div>
		</div>
<?php	include_once("../template/footer.php"); ?>
