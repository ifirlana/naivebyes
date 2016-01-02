
<?php
include_once("../connect.php");
		
	if($_POST){
		$teksAsli	=	$_POST['artikel'];
		$judul_artikel	=	$_POST['judul_artikel'];
		$sumber = $teksAsli;
		/* $sql_insert = "insert into artikel (id, artikel, date_time, id_kategori,result,active,date_modified) values('','".$teksAsli."','".date("Y-m-d H:i:s")."','0','0','1','0000-00-00 00:00:00')";
		 */
		 
		// $teksAsli = str_replace("\"",$teksAsli," ");
		
		
		$sumber = mb_ereg_replace("\"","&quot;", $sumber);
		$sumber = mb_ereg_replace("'","&acute;", $sumber);
		
		if(str_replace(",", "", $teksAsli)){
		
			$teksAsli = str_replace(",", "", $teksAsli);
			}
			
		if(str_replace(".", "", $teksAsli)){
			
			$teksAsli = str_replace(".", "", $teksAsli);
			}
		
		if(str_replace("'", "", $teksAsli)){
			
			$teksAsli = str_replace("'", "", $teksAsli);
			}
		
		if(str_replace("\"", "", $teksAsli)){
			
			$teksAsli = str_replace("\"", "", $teksAsli);
			}
		$sql_insert = "insert into artikel (artikel,artikel_sumber,date_time,judul_artikel) values(\"".$teksAsli."\",'".$sumber."','".date('Y-m-d H:i:s')."','".$judul_artikel."')";
		 if(mysql_query($sql_insert)){
			
			$alert	=	"Berhasil di Input";
			}
			else{
				
				$alert	=	"Gagal penginputan".$sql_insert;
				}
		}
?>
<?php	include_once("../template/header.php");?>
<?php	include_once("../template/sidebar.php");?>

	 <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<div class="jumbotron">
     
		<h1>News Upload</h1>
			 <form method="POST">
			<?php
				if(isset($alert)){
					
					echo "<h4>".$alert."</h4>";
					}
				?>
			<div class="form-group">
				<label class="control-label" >Judul artikel</label>
				<input type="text" class="form-control" maxlength="254" name="judul_artikel" placeholder="paste judul artikel here"></textarea>
			</div>
			<div class="form-group">
				<label class="control-label" >upload artikel</label>
				<textarea rows="10" class="form-control" name="artikel" placeholder="paste artikel here"></textarea>
			</div>
				<div class="form-group">
				   <button type="submit" class="btn btn-primary">Submit</button>
				</div>

			 </form>	
			</div>
	</div>
<?php	include_once("../template/footer.php"); ?>
