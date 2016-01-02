<?php
$jey =	include_once("../connect.php");
	if($_POST){
		$temp = "";
		$name	=	$_POST['name'];
		$id	=	$_POST['id'];
		$username	=	$_POST['username'];
		$email	=	$_POST['email'];
		$password	=	$_POST['password'];
		
		$password_lagi	=	$_POST['password_lagi'];
		$verify			=	$_POST['verify'];
		
		$sql_n = "select * from user where id = '$id' and password='$password'" ;
		$query_n = mysql_query($sql_n);
		while($rok = mysql_fetch_array($query_n)){
		
			if($password_lagi == $verify){
			
				$temp .= ",password='$password_lagi'";
				
			$location			=	$_POST['location'];
			$email	=	$_POST['email'];
			$sql = "update user set name='$name', email = '$email', location='$location'".$temp.", username = '$username' where privillage=1 and id = $id";
			
			if(mysql_query($sql)){
				$alert =	"berhasil";
				}
			}else{
				$alert = "password tidak sama";
				}
			}
		}
?>

<?php	include_once("../template/header.php");?>
<?php	include_once("../template/sidebar.php");?>
<?php
	$sql_select = "select * from user where privillage = 1";
	$query = mysql_query($sql_select);
	while($row = mysql_fetch_array($query)){
		
		$id	=	$row['id'];
		$name	=	$row['name'];
		$email	=	$row['email'];
		$username	=	$row['username'];
		$password	=	$row['password'];
		$password_lagi	=	$row['password'];
		$verify			=	$row['password'];
		$location			=	$row['location'];
		
?>
	 <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<form method="POST"  class='jumbotron'>
        <input type="hidden" name="id"  value="<?php echo $id?>">
        	<?php /*
			<h1>Profile</h1>
			<p>
			<?php if(isset($alert)){echo "<span class='label label-info'>".$alert."</span>";}?>
			 <div class="form-group">
				<label for="name">NAME</label>
				<input type="text"  class="form-control" id="name" name="name" placeholder="Name" value="<?php echo $name;?>">
			</div>
			<div class="form-group">
				<label for="username">USERNAME</label>
				<input type="text"  class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $username;?>">
			</div>
			<div class="form-group">
				<label for="email">EMAIL</label>
				<input type="text"  class="form-control" name="email" placeholder="Email" value="<?php echo $email;?>">
			</div>
			<div class="form-group">
				<label for="password">CURRENT PASSWORD</label>
				<input type="password"  class="form-control" name="password" placeholder="Current Password" value="<?php echo $password;?>">
			</div>
			<div class="form-group">
				<label for="password_lagi">PASSWORD</label>
				<input type="password"  class="form-control" id="password_lagi" name="password_lagi" placeholder="New Password" value="<?php echo $password;?>">
			</div>
			<div class="form-group">
				<label for="verify">PASSWORD AGAIN</label>
				<input type="password"  class="form-control" id="verify" name="verify" placeholder="Verify Password" value="<?php echo $password;?>">
			</div>
			<div class="form-group">
				<label for="location">LOCATION</label>
				<input type="text"  class="form-control" id="location" name="location" placeholder="Location" value="<?php echo $location;?>">
			</div>
			<div class="form-group">
				<input type="submit"  class="form-control btn-info" name="submit" value="submit">
			</div>
			</p>
			*/?>
			<table class="table">
				<h1>Profile</h1>
				<?php if(isset($alert)){echo "<span class='label label-info'>".$alert."</span>";}?>
					
					<tr><td  class="col-md-4">NAME</td><td  class="col-md-8"><input type="text"  class="form-control" id="name" name="name" placeholder="Name" value="<?php echo $name;?>"></td></tr>
					
					<tr><td class="col-md-4">USERNAME</td><td class="col-md-8"><input type="text"  class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $username;?>"></td></tr>
					
					<tr><td class="col-md-4">EMAIL</td><td class="col-md-8"><input type="text"  class="form-control" name="email" placeholder="Email" value="<?php echo $email;?>"></td></tr>
					
					<tr><td class="col-md-4">CURRENT PASSWORD</td><td class="col-md-8"><input type="password"  class="form-control" name="password" placeholder="Current Password" value="<?php echo $password;?>"></td></tr>
					
					<tr><td class="col-md-4">PASSWORD</td><td class="col-md-8"><input type="password"  class="form-control" id="password_lagi" name="password_lagi" placeholder="New Password" value="<?php echo $password;?>"></td></tr>
					
					<tr><td class="col-md-4">PASSWORD AGAIN</td><td class="col-md-8"><input type="password"  class="form-control" id="verify" name="verify" placeholder="Verify Password" value="<?php echo $password;?>"></td></tr>
					
					<tr><td class="col-md-4">LOCATION</td><td class="col-md-8" ><input type="text"  class="form-control" id="location" name="location" placeholder="Location" value="<?php echo $location;?>"></td></tr>
					<tr><td class="col-md-4">&nbsp;</td><td class="col-md-8"><input type="submit"  class="form-control btn-info" name="submit" value="submit"></td></tr>
					
			</table>
			</form>
		</div>
<?php	
			}
include_once("../template/footer.php"); ?>
