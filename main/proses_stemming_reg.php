<?php
	if($_POST){
		
		include_once "../connect.php";
		
		//load data kamus untuk melakukan perbandingan
		function load_kamus(){
			$temp = "";
			$sql = "SELECT kk.kamus nama_kata, k.kamus nama_kategori, kg.id_kategori
						from kamus_kata kk inner join kamus_kategori kg on kk.id = kg.id_kata
						inner join kategori k on k.id = kg.id_kategori where kg.active = 1 and k.active = 1";
			$result = mysql_query($sql) or die(mysql_error());
			if(mysql_num_rows($result)==0){
			
				
				$temp[] = array(
										'kata'	=>	"",
										'kategori'	=>	"",
										'id'	=>	"",
										'total'	=> 0,
										);
				}else{
					while($row = mysql_fetch_array($result)){
				
				$temp[] = array(
										'kata'	=>	$row['nama_kata'],
										'kategori'	=>	$row['nama_kategori'],
										'id'	=>	$row['id_kategori'],
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
		
		//logic perbandingan		
		function check_perbandingan($kata, $kamus, $temp){ //inputan dari load_kamus
			
			$array_string = "";
			
			
			for($i=0; $i < count($kamus);$i++){
				
				if(strtoupper($kamus[$i]['kata']) == strtoupper($kata)){
					
					$array_string .= $i." { =  : true ,";
					
					
					echo "";
					if(isset($temp[$kamus[$i]['kategori']]['total'])){
						
						$temp[$kamus[$i]['kategori']]['total'] = $temp[$kamus[$i]['kategori']]['total'] + 1;
						$temp[$kamus[$i]['kategori']]['id'] = $kamus[$i]['id'];
						
						$array_string .=  "total : ".$temp[$kamus[$i]['kategori']]['total'].", id : ".$kamus[$i]['id'].", ";
						
						
						}else{
							
							$temp[$kamus[$i]['kategori']]['total']	= 1;
							$temp[$kamus[$i]['kategori']]['id'] 		= $kamus[$i]['id'];
							
							$array_string .=  "total : ".$temp[$kamus[$i]['kategori']]['total'].", id : ".$kamus[$i]['id'].", ";
						
							
							}	
					
					$array_string .= strtoupper($kamus[$i]['kata'])." : ".strtoupper($kata)." }, ";
					}
				}
			
			$temp['array_string'] = $array_string;			
			return $temp;
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
		
		$artikel	=	$_POST['artikel'];
		$array_string = "";
						
		for($i=0;$i<count($artikel);$i++){//di load idnya
		
			$id = $artikel[$i];
			$result = mysql_query("select * from artikel where id='".$id."'");
			while($row = mysql_fetch_array($result)){
				
				$teksAsli = $row['artikel'];
				$artikel_sumber = $row['artikel_sumber'];
				$date_time = $row['date_time'];
				
				}
			
			$length = strlen($teksAsli);
			
			$pattern = '[A-Za-z]';
			$kata ='';
			
			$temp = array();//tampung dulu
			$parts = explode(' ', $teksAsli); //pecahkan kedalam array
			
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
					$temp_pencarian	=	check_perbandingan($check, $kamus, $temp_pencarian);
					$array_string .= $temp_pencarian['array_string'];
					
					
					$temp[] = $check;
					}
				}
			
			$total = count($temp);	
			
			$array_string .= " ";
			
			foreach($temp_pencarian as $key => $value){
				
						$temp_pencarian[$key]['hasil'] = $temp_pencarian[$key]['total'] / $total * 100; //mencari persentase
						$array_string .= $key." { hasil => ".  $temp_pencarian[$key]['hasil'] .", total_kata => ".$temp_pencarian[$key]['total']." }, "; //tampung untuk hasil result
						}
			
			$max = array("maximum" => 0, "key" => "", "id" => 0); //mencari nilai maksimum
			$array_string .= "NaiveByes { "; 	
			$i = 1;			
			foreach($temp_pencarian as $key => $value){
				
						/* hitung data mining */
						$temp_pencarian[$key]['hasil'] = $temp_pencarian[$key]['total'] / $total * 100; //mencari persentase
						
						//mencari nilai maksimum
						if($max['maximum'] < $temp_pencarian[$key]['hasil']){ //perbandingan
											
							$max['maximum'] = $temp_pencarian[$key]['hasil'];
							$max['id'] = $temp_pencarian[$key]['id'];
							$max['key']			 = $key;						
							}
						
						$array_string .= "[".$i++."] ( maksimum : ".$max['maximum']." , key : ".$max['key'].", id : ".$max['id']."), ";
						}
			
			$array_string .= "}, ";
			
			$array_string .= "{ jumlah_kata => ".$total." } ";			
			
			///
			$sql_insert = "insert into artikel (id, artikel,artikel_sumber, date_time,id_kategori,result) values('','".$teksAsli."','".$artikel_sumber."','".$date_time."','".$max['id']."','".$array_string."')";
			
			if(mysql_query($sql_insert)){
				
				$alert	=	"Berhasil di Input";
				}
				else{
					
					$alert	=	"Gagal penginputan";
					}
					
			//get max id
			$sql = "SELECT max(id) id from artikel";
			$result = mysql_query($sql) or die(mysql_error());
			while($row = mysql_fetch_array($result)){
				$id_reg = $row['id'];
				}
			
			
			///proses reg artikel ke data latih
			$sql_reg = "insert into reg_artikel (id_category, total_kata, id_artikel) values('".$max['id']."','".$total."','".$id_reg."')";
			
			if(mysql_query($sql_reg)){
				
				$alert_reg	=	"Berhasil di Input";
				}
				else{
					
					$alert_reg	=	"Gagal penginputan";
					}
					
			///
			$sql_update = "update artikel set active='0' where id='".$id."'";
			
			if(mysql_query($sql_update)){
				
				$alert	=	"Berhasil di Input";
				}
				else{
					
					$alert	=	"Gagal penginputan";
					}
			
			}
		header("Location:artikel.php");	
		}
?>