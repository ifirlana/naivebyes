<?php	include_once("../connect.php"); ?>
<?php	include_once("../template/header.php");?>
<?php	include_once("../template/sidebar.php");?>
	 <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div  class='jumbotron'>	
			<h1>HOME</h1>
			<p><b>Artikel Terbaru</b></p>
			<p  class='jumbotron'><table class="table table-bordered"><?php 
						$sql	=	"select * from artikel order by id limit 0,2"; 
						$db = mysql_query($sql);
						while($row = mysql_fetch_array($db)){
							echo "<tr><td>".$row['artikel']."</td></tr>";
							}
						?></table></p>
			<?php ?>
			</div>
	</div>
<?php	include_once("../template/footer.php"); ?>
