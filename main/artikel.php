<?php	
	include_once("../connect.php");
	if($_GET){
		$select = "update artikel set active = 0 where id = '".$_GET['id']."'";
		
		$result = mysql_query($select) or die(mysql_error());
		if($result){
		
			$alert =  "Proses berhasil click <a href='artikel.php'>disini</a>";
			}else{
				
				$alert =  "Error click <a href='artikel.php'>disini</a>";
				}					
		}
	
	include_once("../template/header.php");
	include_once("../template/sidebar.php");?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
   <div class="jumbotron">
	 <h1>Artikel</h1>
	<?php
		$sql	=	"select artikel.*, kategori.kamus kamus_kategori, reg_artikel.total_kata 
						from (select * from artikel where active = 1) artikel left join kategori on artikel.id_kategori = kategori.id 
						left join reg_artikel on artikel.id = reg_artikel.id_artikel
						order by date_time desc";
	?>
		<?php if(isset($alert)){ echo "<h3 class=\"bg-info\">".$alert."</h3>";  }?>
		<?php
			$query	=	mysql_query($sql);
			$hasil	=	mysql_num_rows($query);
			if($hasil > 0){
				?>
				<table class="table table-bordered">
					<tr>
						<th>&nbsp;</th>
						<th>Artikel</th>
						<th>Kategori</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						</tr>
					<?php
						while($row =	mysql_fetch_array($query)){
						?>
						<form method="POST" action="proses_stemming_reg.php">

						<?php
							echo "<tr>
								<td><input type='checkbox' name='artikel[]' value='".$row['id']."'></td>
								<td>".$row['artikel']."</td>
								<td>".$row['kamus_kategori']."</td>
								<td width='30%'>".$row['result']."</td>
								<td><a href='artikel.php?id=".$row['id']."' class='btn btn-danger'>Delete</a></td>";
						if(!isset($row['total_kata']) or $row['total_kata'] == "" ){
						?>
						
								<td><button type="submit" class="btn btn-warning">REG</button></td>
						<?php
								}
							else{
								echo "<td>SUDAH TERDAFTAR</td>";
								}								
								echo "</tr>";
								?>								
						</form>
								<?php
							}
						?>	
				</table>
				<?php
				}
			?>
		</div>
	</div>
</div>
<?php	
	include_once("../template/footer.php");
	 ?>	