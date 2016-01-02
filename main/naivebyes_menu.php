<?php	include_once("../connect.php"); ?>
<?php
	$sql	=	"select reg_artikel.id, kategori.kamus, artikel.artikel, artikel.id_kategori, total_kata 
					from reg_artikel left join kategori on reg_artikel.id_category = kategori.id  
					left join artikel on reg_artikel.id_artikel = artikel.id";
?>
<?php	include_once("../template/header.php");?>
<?php	include_once("../template/sidebar.php");?>
	 <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div class='jumbotron'>	
			<h1>Naive Byes</h1>
			<p><small>Data Latih</small></p>
			<table class="table table-bordered">
			<tr>
				<th> |W| </th>
				<td>Kategori</td>
				<td>Kata</td>
				<td>Kategori</td>
				<td>Artikel</td>
				<td>&nbsp;</td>
			</tr>
			<?php
				$total_kata = 0;
				$query	=	mysql_query($sql);
				while($row = mysql_fetch_array($query)){
					echo "<tr>";
					echo "<td>".$row['total_kata']."</td>";
					echo "<td>".$row['kamus']."</td>";
					$sql1	=	"select kamus_kata.* 
										from 
										kamus_kategori 
										inner join kamus_kata on kamus_kategori.id_kata = kamus_kata.id 
										where kamus_kategori.id_kategori = '".$row['id_kategori']."'";
					$query1	=	mysql_query($sql1);
					echo "<td>";
					while($row1 = mysql_fetch_array($query1)){
						echo "".$row1['kamus'].", ";
						}
					echo "</td>";
					echo "<td>".$row['kamus']."</td>";
					
					echo "<td>".substr($row['artikel'], 0, 100)."</td>";
					echo "<td><a href='delete_reg_artikel.php?id=".$row['id']."' class='btn btn-danger'>Delete</a></td>";
					echo "</tr>";
			
				$total_kata = $total_kata + $row['total_kata'];
				}
			?>
			<tr>
				<th>f(ci)</th>
				<td colspan="4"><?php echo $total_kata;?></td>
			</tr>
			
			</table>
			</div>
		<div class="jumbotron">
			<?php
		$sql	=	"select artikel.*, kategori.kamus kamus_kategori, reg_artikel.total_kata 
						from (select * from artikel where active = 1 and (result = '' or result is null)) artikel left join kategori on artikel.id_kategori = kategori.id 
						left join reg_artikel on artikel.id = reg_artikel.id_artikel
						order by date_time desc";
	?>
		<?php if(isset($alert)){ echo "<h3 class=\"bg-info\">".$alert."</h3>";  }?>
		<?php
			$query	=	mysql_query($sql);
			$hasil	=	mysql_num_rows($query);
			if($hasil > 0){
				?>
				<p><small>Data Uji</small></p>
				<table class="table table-bordered">
					<tr>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						</tr>
					<?php
						while($row =	mysql_fetch_array($query)){
						?>
						<form method="POST" action="proses_naivebyes_stemming(2).php">
						<input type="hidden" name="id_artikel" value="<?php echo "".$row['id']."";?>">
						<input type="hidden" name="artikel" value="<?php echo "".$row['artikel']."";?>">
						<?php
							echo "<tr>
								<td>".$row['artikel']."</td>
								<td>".$row['kamus_kategori']."</td>";
						if(!isset($row['total_kata']) or $row['total_kata'] == "" ){
						?>
						
								<td><button type="submit" class="btn btn-warning">Pengujian</button></td>
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
<?php	include_once("../template/footer.php"); ?>
