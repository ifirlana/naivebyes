<?php	
		include_once("../connect.php");
		if($_GET){
		$select = "update kamus_kategori set active = 0 where id = '".$_GET['id']."'";
		
		$result = mysql_query($select) or die(mysql_error());
		if($result){
		
			$alert = "Proses berhasil click <a href='updateData_deleteKunci.php'>disini</a>";
			}else{
				
				$alert = "Error click <a href='updateData_delete.php'>disini</a>";
				}					
		}
		include_once("../template/header.php");?>
<?php	
		include_once("../template/sidebar.php");?>
	 <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        	<div class="jumbotron")
			<h1>Delete Kunci</h1>
			<?php if(isset($alert)){ echo "<h3 class=\"bg-info\">".$alert."</h3>";  }?>
			<table class="table table-bordered">
				<?php include_once("sidebar_updateData.php");?>
				<tr>
					<td colspan="3" >
						<?php
							$select		=	"select 
								id,
								(select kamus from kategori where kategori.id = kamus_kategori.id_kategori) nama_kategori, 
								(select kamus from kamus_kata where kamus_kata.id = kamus_kategori.id_kata) nama_kata 
								from kamus_kategori where kamus_kategori.active = 1";
							$result = mysql_query($select) or die(mysql_error());
							echo "<table class='table'>";
							while($row =	mysql_fetch_array($result)){
								echo "<tr><td>".$row['nama_kategori']." ~ ".$row['nama_kata']."</td><td><a href='updateData_deletekunci.php?id=".$row['id']."' class='btn btn-danger'>Delete</a></td></tr>";
								}
							echo "</table>";
							?>
					
					</td>
				</tr>
			</table>
	</div>
	</div>
<?php	include_once("../template/footer.php"); ?>
