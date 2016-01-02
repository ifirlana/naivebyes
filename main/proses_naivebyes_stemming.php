<?php	include_once("../connect.php"); 
	
	//load data kamus untuk melakukan perbandingan
	function load_kamus(){
		$temp = "";
		$sql = "SELECT 
					reg_artikel.id_category,
					reg_artikel.id_artikel,
					reg_artikel.total_kata,
					kamus_kata.*
					from 
					reg_artikel inner join kamus_kategori 
					on reg_artikel.id_category = kamus_kategori.id_kategori
					inner join kamus_kata on kamus_kategori.id_kata = kamus_kata.id 
					where 
						kamus_kata.active = 1
					order by id_category asc";
		$result = mysql_query($sql) or die(mysql_error());
		if(mysql_num_rows($result)==0){
		
			
			$temp[] = array(
									'kata'	=>	"",
									'id_kategori'	=>	"",
									'id_artikel'	=>	"",
									'id'	=>	"",
									'fci'	=>	"",
									'total'	=> 0,
									);
			}else{
				while($row = mysql_fetch_array($result)){
			
			$temp[] = array(
									'kata'	=>	$row['kamus'],
									'id_kategori'	=>	$row['id_category'],
									'id_artikel'		=>	$row['id_artikel'],
									'id'	=>	$row['id'],
									'fci'	=>	$row['total_kata'],
									'total'	=> 0,
									);
			}
				}		
			
		if($temp == ""){	//load kategori
			
			return false;
			}
			else{
			
				return $temp;
				}
		}
	
	//logic perbandingan kata		
	function check_perbandingan_kata($kata, $kamus, $temp, $id_artikel_naivebyes){ //inputan dari load_kamus
		
		$array_string = "";
		
		
		for($i=0; $i < count($kamus);$i++){
			
			if(strtoupper($kamus[$i]['kata']) == strtoupper($kata)){
				
				// 
				$kamus[$i]['total'] = $kamus[$i]['total'] + 1;
				
				$sql_insert	=	"insert into katakunci_artikel (id_artikel, kata_kunci, id_kata, id_artikel_naivebyes) values (".$kamus[$i]['id_artikel'].", '".$kamus[$i]['kata']."', ".$kamus[$i]['id'].", ".$id_artikel_naivebyes.")";
				//echo $sql_insert."<br />";
				if(mysql_query($sql_insert)){
					//echo "berhasil<br />";
					}
				}
			}
		
		$temp['array_string'] = $array_string;			
		return $kamus;
		}
		
	function cekKamus($kata){
		// cari di database
		$sql = "SELECT * from kamus_kata where kamus ='$kata' LIMIT 1";
		//echo $sql.'<br/>';
		$result = mysql_query($sql) or die(mysql_error());
		if(mysql_num_rows($result)==1){
		
			return true; // True jika ada
			}else{
				
				return false; // jika tidak ada FALSE
				}
		}
	
	//hapus tanda - tanda tidak perlu		
	function Del_Character($kata){
		
		/* 2. Buang Infection suffixes (\-lah”, \-kah”, \-ku”, \-mu”, atau \-nya”) */
		
		$kataAsal = $kata;
		if(eregi('([,]|[.]|[\"]|[\'])$',$kata)){ // Cek Inflection Suffixes
			
			$__kata = ereg_replace('([,]|[.]|[\"]|[\'])$','',$kata);
			return $__kata;
			}
			else{
				
				return $kataAsal;
				}
		}
	
	
	function Del_Inflection_Suffixes($kata){
		
		/* 2. Buang Infection suffixes (\-lah”, \-kah”, \-ku”, \-mu”, atau \-nya”) */
		
		$kataAsal = $kata;
		if(eregi('([km]u|nya|[kl]ah|pun|,|[.])$',$kata)){ // Cek Inflection Suffixes
			
			$__kata = ereg_replace('([km]u|nya|[kl]ah|pun|,|[.])$','',$kata);
			return $__kata;
			}
			else{
				
				return $kataAsal;
				}
		}
	
	// Cek Prefix Disallowed Sufixes (Kombinasi Awalan dan Akhiran yang tidak diizinkan)
	function Cek_Prefix_Disallowed_Sufixes($kata){
		if(eregi('^(be)[[:alpha:]]+(i)$',$kata)){ // be- dan -i
			
			return true;
			}	
		if(eregi('^(se)[[:alpha:]]+(i|kan)$',$kata)){ // se- dan -i,-kan
			
			return true;
			
			}
			return false;
		}
	
	// Hapus Derivation Suffixes (“-i”, “-an” atau “-kan”)
	function Del_Derivation_Suffixes($kata){
		$kataAsal = $kata;
		if(eregi('(i|an)$',$kata)){ // Cek Suffixes
			
			$__kata = ereg_replace('(i|an)$','',$kata);
			if(cekKamus($__kata)){ // Cek Kamus
			
				return $__kata;
				}
			/*– Jika Tidak ditemukan di kamus –*/
			}
			return $kataAsal;
		}
	// Hapus Derivation Prefix (“di-”, “ke-”, “se-”, “te-”, “be-”, “me-”, atau “pe-”)
	function Del_Derivation_Prefix($kata){
		$kataAsal = $kata;

		/* —— Tentukan Tipe Awalan ————*/
		if(eregi('^(di|[ks]e)',$kata)){ // Jika di-,ke-,se-
			
			$__kata = ereg_replace('^(di|[ks]e)','',$kata);
			if(cekKamus($__kata)){
				
				return $__kata; // Jika ada balik
				}
			$__kata__ = Del_Derivation_Suffixes($__kata);
			if(cekKamus($__kata__)){
				
				return $__kata__;
				}
			/*————end “diper-”, ———————————————*/
			if(eregi('^(diper)',$kata)){
			
				$__kata = ereg_replace('^(diper)','',$kata);
				if(cekKamus($__kata)){
					
					return $__kata; // Jika ada balik
					}
				}
			/*————end “diper-”, ———————————————*/
			}
		if(eregi('^([tmbp]e)',$kata)){ //Jika awalannya adalah “te-”, “me-”, “be-”, atau “pe-”
			
			}
		/* — Cek Ada Tidaknya Prefik/Awalan (“di-”, “ke-”, “se-”, “te-”, “be-”, “me-”, atau “pe-”) ——*/
		if(eregi('^(di|[kstbmp]e)',$kata) == FALSE){
			
			return $kataAsal;
			}

		return $kataAsal;
		}

	function ARIFIN($katakata){

		$katakataAsal = $katakata;

		/* 0. Hapus karakter-karakter */
		$katakata = Del_Character($katakata);
		
		/* 1. Cek Kata di Kamus jika Ada SELESAI */
		
		if(cekKamus($katakata)){ // Cek Kamus
		
			return $katakata; // Jika Ada kembalikan
			}
			else{ //kalau bukan

				/* 2. Buang Infection suffixes (\-lah”, \-kah”, \-ku”, \-mu”, atau \-nya”) */
				$katakata = Del_Inflection_Suffixes($katakata);
				
				/* 3. Buang Derivation suffix (\-i” or \-an”) */
				$katakata = Del_Derivation_Suffixes($katakata);

				/* 4. Buang Derivation prefix */
				$katakata = Del_Derivation_Prefix($katakata);

				return $katakata;
			}
		}	
	
	function pvj($kamus, $fci, $W, $id_naivebyes, $jumlah_artikel){
		
		for($i=0;$i<count($kamus);$i++){
			
			//cari total kata W
			$total_kata = 0;
			for($j = 0;$j<count($W);$j++){
				if($W[$j]['id_artikel'] == $kamus[$i]['id_artikel']){
					$total_kata = $W[$j]['total_kata'];
					}
				}
			//end
			
			$f_wkjci_plus1 = $kamus[$i]['total'] + 1;
			$f_ci_plus_W = $total_kata + $fci;
			$id_artikel  	=	$kamus[$i]['id_artikel'];
			$id_kata	 	=	$kamus[$i]['id'];
			$id_naivebyes  	=	$id_naivebyes;
			
			$pci = 1/floatval($jumlah_artikel);
			
			$insert = "insert into detail_naivebyes(id_naivebyes, id_artikel, pci, f_wkjci_plus1, f_ci_plus_W,id_kata) values (".$id_naivebyes.",".$id_artikel.", ".$pci.", ".$f_wkjci_plus1.",".$f_ci_plus_W.",".$id_kata.")";
			echo "pvj ".$insert."<br />";
			if(mysql_query($insert)){
				//echo "berhasil<br />";
				}			
			}
		}
?>

<?php 
	if($_POST){
		
		$W		 		= array();
		$fci				=	0;
		$pci				=	0;
		$jumlah_artikel	=	0;
		$katakunci	= array();
		
		$id_artikel		=	$_POST['id_artikel'];
		$artikel			=	$_POST['artikel'];
		
		$sql_load_naivebyes	=	"select 
												id,
												id_artikel, 
												id_category, 
												total_kata 
											from reg_artikel";
		
		$query	=	mysql_query($sql_load_naivebyes);
		while($row = mysql_fetch_array($query)){
				$W[] 	=	array(
								"total_kata"	=> $row['total_kata'],
								"id_artikel"	=> $row['id_artikel'],
								"id_category"	=> $row['id_category'],
								"id"	=> $row['id'],
					);
			
			$fci = $fci + $row['total_kata']; //
			$jumlah_artikel = $jumlah_artikel + 1;
			}
		
		/** 
		//cek W
		for($i=0;$i<count($W);$i++){
			
			echo "::".$W[$i]['total_kata']." => ".$W[$i]['id'].", ".$W[$i]['id_artikel'].", ".$W[$i]['id_category']." <br />";
			}
		//end	
		*/
		
		$length = strlen($artikel);
			
		$pattern = '[A-Za-z]';
		$kata ='';
		
		$temp = array();//tampung dulu
		$parts = explode(' ', $artikel); //pecahkan kedalam array
		
		//$array_string .= "parts {".serialize($parts)."}, ";
		
		//load kamus 
		$kamus	=	load_kamus();
		
		//$array_string .= "kamus {".serialize($kamus)."}, ";
		
		
		//set pencarian
		$temp_pencarian = array();
		
		//susun ulang logika hilangin yang kosong dan kata-kata d
		//ditambahan
		$k = 0;
		for($i=0;count($parts) > $i;$i++){
			
			$check = ARIFIN($parts[$i]);
			
			if(strlen($check) > 1){
				
				echo $k++." ".$check."<br />"; //lihat hasil ARIFIN
				$kamus		=	check_perbandingan_kata($check, $kamus, $temp_pencarian,$id_artikel);
				
				
				$temp[] = $check;
				}
			}
		
		$total_artikel = count($temp);	
		
		$sql	=	"insert into naivebyes (id_artikel,total_kata) values (".$id_artikel.",".$total_artikel.") ";
		echo $sql."<br />";
		
		$hasil = array();
		$max	=	array(
								"nilai" => 0,
								"id_kategori" => 0,
								);
		
		if(mysql_query($sql)){
			
			$sql_select	=	"select id from naivebyes where id_artikel = $id_artikel limit 0,1";
			echo $sql_select."<br />";
			if(mysql_query($sql_select)){
				$query = mysql_query($sql_select);
				while($row	=	mysql_fetch_array($query)){
					
					$id_naivebyes = $row['id'];
					}
				}
			
			//echo $id_naivebyes."<br />";
			pvj($kamus, $fci, $W,$id_naivebyes, $jumlah_artikel);
			
			//load process C*  
			$hasil = array();
			
			$sql_c	=	"select 
								artikel.id_kategori,
								katakunci_artikel.id_artikel,
								katakunci_artikel.kata_kunci,
								detail_naivebyes.pci,
								detail_naivebyes.f_wkjci_plus1,
								detail_naivebyes.f_ci_plus_W
							from 
								katakunci_artikel, 
								artikel,
								detail_naivebyes,
								naivebyes
							where 
								naivebyes.id = detail_naivebyes.id_naivebyes
								and katakunci_artikel.id_artikel = detail_naivebyes.id_artikel
								and katakunci_artikel.id_kata = detail_naivebyes.id_kata
								and artikel.id = katakunci_artikel.id_artikel
								and naivebyes.id_artikel = $id_artikel 
								and artikel.active = 1
								group by detail_naivebyes.id_artikel, detail_naivebyes.id_kata";
			$db 	=	mysql_query($sql_c);
			while($rok =	mysql_fetch_array($db)){
				
				//script ini tidak digunakan lagi
				$hasil[] = array(
									"total" => $rok['f_wkjci_plus1'] / $rok['f_ci_plus_W'],
									"kata_kunci" => $rok['kata_kunci'],
									"pci" => $rok['pci'],
									"id_kategori" => $rok['id_kategori'],
									"id_artikel" => $rok['id_artikel'],
									);
				//end..
				echo "id_artikel ".$rok['id_artikel']."<br />";					
 				}
			}
			
			// Proses Probabilitas
				//code here..
				/**/
				//load katakunci dahulu
				//masukin array abis tu cocokin ama artikel pendukunya
				$sql_katakunci = "select  * from 
											detail_naivebyes inner join naivebyes on detail_naivebyes.id_naivebyes = naivebyes.id,
											katakunci_artikel
											where
												naivebyes.id_artikel = katakunci_artikel.id_artikel_naivebyes
												and detail_naivebyes.id_artikel = katakunci_artikel.id_artikel
												and detail_naivebyes.id_kata = katakunci_artikel.id_kata
												";
				
				
				$hitung = array();
				$total_p = 0;
				$sql_search = "select  
							reg_artikel.id_artikel,
							artikel.id_kategori,
							detail_naivebyes.pci
							from 
								reg_artikel inner join detail_naivebyes on reg_artikel.id_artikel = detail_naivebyes.id_artikel
								inner join naivebyes on detail_naivebyes.id_naivebyes = naivebyes.id 
								inner join artikel on artikel.id = reg_artikel.id_artikel
							where
								naivebyes.id_artikel = $id_artikel
								and artikel.active = 1
								group by reg_artikel.id_artikel";
				$db0 = mysql_query($sql_search);
				while($row = mysql_fetch_array($db0)){
				
					$id_artikel_p = $row['id_artikel'];
					$id_kategori = $row['id_kategori'];
					$tampung = array();
					$total_p = $row['pci'];
					
					//proses perhitungan
					/**
					echo "total pci : ".$total_p."<br />";
					$sql_now = "select  detail_naivebyes.f_wkjci_plus1,f_ci_plus_W from 
											detail_naivebyes inner join naivebyes on detail_naivebyes.id_naivebyes = naivebyes.id,
											katakunci_artikel
											where
												naivebyes.id_artikel = katakunci_artikel.id_artikel_naivebyes
												and detail_naivebyes.id_artikel = katakunci_artikel.id_artikel
												and detail_naivebyes.id_kata = katakunci_artikel.id_kata
												and detail_naivebyes.id_artikel = ".$row['id_artikel']."";					
					$db = mysql_query($sql_now);
					if(mysql_num_rows($db) > 0){
						echo $sql_now."<br />";
						while($rok =	mysql_fetch_array($db)){
									$total_p =  $total_p + $rok['f_wkjci_plus1'] / $rok['f_ci_plus_W'];
									echo ">> (pci)".$total_p." * (f_wkjci_plus1) ".$rok['f_wkjci_plus1']." / (f_ci_plus_W) ".$rok['f_ci_plus_W']."<br />";
							}
						}
						*/
						//end
					
						$insert = "insert into kategori_hitung_p (id_artikel, id_artikel_naivebyes, total_p) values (".$id_artikel_p.", ".$id_artikel.", ".$total_p.")";
						
						$hitung[] = array(
									"total" => $total_p,
									"id_kategori" => $id_kategori,
									);
						$db_insert = mysql_query($insert);
					}
				/**/
			// end.	
			
			//sorting maximum lama
			/*
			for($i=0;$i<count($hasil);$i++){
				echo "total ".$hasil[$i]['total'] .", kata kunci ".$hasil[$i]['kata_kunci']."<br />";
				if($max['nilai'] < $hasil[$i]['total']){
					$max['id_kategori']	=	$hasil[$i]['id_kategori'];
					}
				}
				*/
			//end sorting
			
			
			//sorting maximum 
			for($i=0;$i<count($hitung);$i++){
				echo "total ".$hitung[$i]['total'] .", kategori".$hitung[$i]['id_kategori']."<br />";
				if($max['nilai'] < $hitung[$i]['total']){
					$max['id_kategori']	=	$hitung[$i]['id_kategori'];
					$max['nilai']	=	$hitung[$i]['total'];
					}
				}
			//end sorting
			$sql_update_artikel = "update artikel set id_kategori = ".$max['id_kategori'].", result = 'naivebyes' where id = ".$id_artikel."";
			echo $sql_update_artikel."<br />";
			if(mysql_query($sql_update_artikel)){
				
				//header("Location:naivebyes_menu.php");	
				echo "<a href='naivebyes_menu.php'>CLICK DISINI</a>";
				}
		}
?>