<?php	include_once("../template/header.php");?>
<?php	include_once("../template/sidebar.php");?>
	 <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div class="jumbotron">	<h1>Update Data</h1>
			<table class="table table-bordered">
				<?php include_once("sidebar_updateData.php");?>
				<tr>
					<td colspan="3" >
						<h3>Ubah kata kunci</h3>
						<div class="form-group">
							   <a type="submit" class="btn btn-primary" href="updateData_deleteKunci.php">Hapus Kata Kunci</a>
						</div>
						<div class="form-group">
							   <a type="submit" class="btn btn-primary" href="updateData_deleteKategori.php">Hapus Kategori</a>
						</div>
						<div class="form-group">
							   <a type="submit" class="btn btn-primary" href="updateData_deleteKamus_kata.php">Hapus Kamus Kata</a>
						</div>
					</td>
				</tr>
			</table>
	</div>
	</div>
	</div>
<?php	include_once("../template/footer.php"); ?>
