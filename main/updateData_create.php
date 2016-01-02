<?php	include_once("../connect.php"); ?>
<?php
	if($_POST){
		$var_kategori	=	$_POST['kategori']; echo "var_kategori ".$var_kategori."<br />";
		$var_kata			=	$_POST['kata'];	echo "var_kata ".$var_kata;
		
		$sql_insert = "insert into kamus_kata(kamus) values ('".$var_kata."')";
		//echo $sql_insert."<br />";
		mysql_query($sql_insert);
		
		$query	=	mysql_query("select id from kamus_kata order by id desc limit 0,1");
		while($row	=	mysql_fetch_array($query)){
			$id = $row['id'];
			}
		$sql_insert2 = "insert into kamus_kategori (id_kategori,id_kata) values ('".$var_kategori."','".$id."')";
		//echo $sql_insert2."<br />";
		mysql_query($sql_insert2);
		
		}
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
						<form method="POST" action="proses_input_kategori.php">
						<h3>Buat Kegori Baru</h3>
						<div class="form-group">
							<input type="text" name="kategori" class="form-control" placeholder="Masukan kategori"></div>
							<div class="form-group">
								   <button type="submit" name="submit" class="btn btn-primary">Submit</button>
							</div>
						</form>
					</td>
					</tr>
				<?php
					$sql = "SELECT * from kategori where active = 1";
					$result = mysql_query($sql) or die(mysql_error());
					if($result){
						echo "<tr><th colspan='3'>KATEGORI</th></tr>";
						while($row = mysql_fetch_array($result)){
							echo "<tr><td colspan='3'>".$row['kamus']."</td></tr>";
							}
					}
				?>
					<tr>
					<td colspan="3" >
						<form method="POST">
						<h3>Buat Kata Kunci Baru</h3>
						<div class="form-group">
							<input type="text" name="kata" class="form-control" placeholder="Masukan kata kunci"></div>
						<div class="form-group">
							<select name="kategori" class="form-control">
								<option>-- Pilih Kategori --</option>
								<?php
									$sql = "SELECT id, kamus
												from  kategori where active = 1
												order by kamus asc";
									$result = mysql_query($sql) or die(mysql_error());
									if($result){
										
										while($rok = mysql_fetch_array($result)){
											
											echo "<option value='".$rok['id']."'>".$rok['kamus']."</option>";
											}
										}
								?>
							  </select>
							</div>
						<div class="form-group">
							   <button type="submit" name="submit" class="btn btn-primary">Submit</button>
						</div>
						</form>
					</td>
				</tr>
				<?php
					$sql = "SELECT kk.kamus nama_kata, k.kamus nama_kategori 
						from kamus_kata kk inner join kamus_kategori kg on kk.id = kg.id_kata
						inner join kategori k on k.id = kg.id_kategori where kg.active = 1";
					$result = mysql_query($sql) or die(mysql_error());
					if($result){
						echo "<tr><th colspan='2'>KATA</th><th>KATEGORI</th></tr>";
						while($row = mysql_fetch_array($result)){
							echo "<tr><td colspan='2'>".$row['nama_kata']."</td><td>".$row['nama_kategori']."</td></tr>";
							}
					}
				?>
			</table>
		<div>
	</div>
<?php	include_once("../template/footer.php"); ?>
