<?php	include_once("../connect.php"); ?>
<?php
	if($_POST){
		$id_kamus_kategori	=	$_POST['id_kamus_kategori'];
		$id_kamus_kata		=	$_POST['id_kamus_kata'];
		$id_kategori				=	$_POST['id_kategori'];
		$sql = "update kamus_kategori set id_kategori='".$id_kategori."', id_kata='".$id_kamus_kata."' where id = '".$id_kamus_kategori."'";
		if(mysql_query($sql)){
			mysql_query($sql);
			$alert	= "berhasil";
			}else{
				$alert = "gagal";
				}
		}
?>
<?php
					$sql = "SELECT kg.id, kk.kamus nama_kata, k.kamus nama_kategori 
						from kamus_kata kk inner join kamus_kategori kg on kk.id = kg.id_kata
						inner join kategori k on k.id = kg.id_kategori where kg.active = 1 order by nama_kategori asc ";
					$result = mysql_query($sql) or die(mysql_error());

					$sql1 = "SELECT * 
						from kamus_kata where kamus_kata.active = 1 order by kamus asc";
					$result1 = mysql_query($sql1) or die(mysql_error());

					$sql2 = "SELECT *
						from kategori where kategori.active = 1 order by kamus asc ";
					$result2 = mysql_query($sql2) or die(mysql_error());					
				?>
			
<?php	include_once("../template/header.php");?>
<?php	include_once("../template/sidebar.php");?>
	 <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
       <div class="jumbotron"> 
		<h1>Update Data</h1>
			
			<table class="table table-bordered">
				<?php include_once("sidebar_updateData.php");?>
				<tr>
					<td colspan="3" >
						<h3>Ubah kata kunci</h3>
						<?php
							if(isset($alert)){
								echo "<h4>".$alert."</h4>";
								}
						?>
						<form method="POST">
						<div class="form-group">
							<select name="id_kamus_kategori" class="form-control">
								<option>-- Pilih kata kunci yang diubah --</option>
								<?php
									if($result){
										while($row = mysql_fetch_array($result)){
											echo "<option value='".$row['id']."'>".$row['nama_kategori']." -- ".$row['nama_kata']."</option>";
											}
									}
								?>
							  </select>
							</div>
						<div class="form-group">
							<select name="id_kamus_kata" class="form-control">
								<option>-- Ubah kata kunci --</option>
								<?php
									if($result1){
										while($row = mysql_fetch_array($result1)){
											echo "<option value='".$row['id']."'>".$row['kamus']."</option>";
											}
									}
								?>
							  </select>
							  </div>
						<div class="form-group">
							<select name="id_kategori" class="form-control">
								<option>-- Ubah kata kategori --</option>
								<?php
									if($result2){
										while($row = mysql_fetch_array($result2)){
											echo "<option value='".$row['id']."'>".$row['kamus']."</option>";
											}
									}
								?>
							  </select>
							 </div>
						<div class="form-group">
							   <button type="submit" class="btn btn-primary">Submit</button>
						</div>
						</form>
					</td>
				</tr>
				
			</table>
			</div>
	</div>
<?php	include_once("../template/footer.php"); ?>
