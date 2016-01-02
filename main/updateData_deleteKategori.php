<?php	
	include_once("../connect.php");
	if($_GET){
		$select = "update kategori set active = 0 where id = '".$_GET['id']."'";
		
		$result = mysql_query($select) or die(mysql_error());
		if($result){
		
			$alert =  "berhasil click <a href='updateData_deleteKategori.php'>disini</a>";
			}else{
				
				$alert =  "Error click <a href='updateData_delete.php'>disini</a>";
				}					
		}
	
	include_once("../template/header.php");
	include_once("../template/sidebar.php");
	
	?>
	
	 <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<div class="jumbotron">
		<h1>Delete Kategori</h1>
		<?php if(isset($alert)){ echo "<h3 class=\"bg-info\">".$alert."</h3>";  }?>
		
			<table class="table table-bordered">
				<?php include_once("sidebar_updateData.php");?>
				<tr>
					<td colspan="3" >
						<?php
							$select		=	"select * from kategori where kategori.active = 1";
							$result = mysql_query($select) or die(mysql_error());
							echo "<table class='table'>";
							while($row =	mysql_fetch_array($result)){
								echo "<tr><td>".$row['kamus']."</td><td><a href='updateData_deleteKategori.php?id=".$row['id']."' class='btn btn-danger'>Delete</a></td></tr>";
								}
							echo "</table>";
							?>
					</td>
				</tr>
			</table>
	</div>
	</div>
<?php	
	include_once("../template/footer.php"); 
	
	?>
