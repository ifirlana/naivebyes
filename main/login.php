<?php	include_once("../template/header.php");?>
	<?php 
		if($_POST){
			include_once("../connect.php");
		//redirect
		//header("Location:home.php");
		$username	=	$_POST['username'];
		$password	=	$_POST['password'];
		
		$select = "select * from user where username = '$username' and password = '$password'";
		$result = mysql_query($select) or die(mysql_error());
		
		$exist = false;
			while($row = mysql_fetch_array($result)){
				$exist	=	true;
				$privillage	= $row['privillage'];
				
				}	
		
		if($exist == false){ //existnya tidak ada
			
			header("Location:../index.php");
			}
			else{//ditemukan
				session_start();//hidupin session
				$_SESSION['username']	=	$username;
				$_SESSION['privillage']		=  $privillage;
				
				if($_SESSION['privillage'] == 1){ //untuk admin
				
					header("Location:home.php");
					}
					else if($_SESSION['privillage'] == 2){ //untuk user
						
						header("Location:../user/home.php");
						}
				}
			}else{?>
	<style>
		#menu-body{
			padding:20px;
			}
		body {
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #eee;
}

.form-signin {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  height: auto;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
		</style>
	<?php //echo date("Y-m-d H:i:s");?>
	<div class="container">

      <form class="form-signin" role="form" method="POST">
        <h2 class="form-signin-heading text-center">Login</h2>
        <input class="form-control" type="text" name="username" placeholder="username">
       <input class="form-control" type="password" name="password" placeholder="password">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->

	<?php }?>
<?php	include_once("../template/footer.php"); ?>