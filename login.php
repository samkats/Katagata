<?php
session_start();
$db=mysqli_connect('localhost','root','','registration_db');
if ($db) {
	// echo "db found proceed to submit data";
}
else
	// die("your connection couldnt be placed");
?>
<!DOCTYPE html>
<html>
<head>
	<title>library registration system</title>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<!-- <link rel="stylesheet" type="text/css" href="styles/style_all.css"> -->
  <style type="text/css">
    .error{color: red; background-color: ; }
  </style>
</head>
<body>
<div class="header">
	<h2>LOGIN</h2>
	<body bgcolor="#99FFFF">
	<bg color="#550CC0"></bg>
</div>
<?php
$email=$password_1=$success="";
$email_error=$password_1_error=$notsuccess=$error="";
if ($_SERVER['REQUEST_METHOD']=="POST") {
	if (empty($_POST['EMAIL'])) {
		$email_error="your email is needed to login";
	}
	else{
		$email=test_input($_POST['EMAIL']);
		// if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		// 	$email_error="such    Email";
		// }
	}
	if (empty($_POST['password_1'])) {
		$password_1_error="Password is required";
	}
		else{
			$password_1=test_input($_POST['password_1']);
		}
}

function test_input($data){
 $data=trim($data);
 $data=stripcslashes($data);
 $data=htmlspecialchars($data);
}
?>
<!-- sessions -->
<?php
if ($_SERVER["REQUEST_METHOD"]=="POST") {
	if (isset($_POST["submitlogin"])) {	
	$email=mysqli_real_escape_string($db, $_POST['EMAIL']);
	// $name=mysqli_real_escape_string($db, $_POST['NAME']);
	$password=mysqli_real_escape_string($db, $_POST['password_1']);
	$sql="SELECT * FROM students WHERE (EMAIL='$email') AND PASSWORD='$password'";
	// if ($sql) {
		// echo "weldone";
	// }
	$query=mysqli_query($db,$sql);
	$result=mysqli_fetch_assoc($query);
	$row=mysqli_num_rows($query);
	if($row==1){
	
		// else{
		// session_register("EMAIL");
	    $_SESSION["EMAIL"] = $email;
	    $authentication=($row['EMAIL']==$_POST['EMAIL'])&&($row['PASSWORD']==$_POST['password_1']);
			if ($authentication) {
			echo "succes";		
				
			}
			else{
			$error=("Your Login Name or password is incorrect");
			header("location:welcome.php");
				}
			}
	else{
		$error="Your Login Name or password is incorrect";
	}
}
	// }
}
?>
<form method="POST" action="<?php #if($row){echo ('welcome.php');} #echo htmlspecialchars($_POST['PHP_SELF']); ?>" enctype="multipart">
	  <div class="input-group">
	  	<span class="error"><?php echo $error;?></span>
	  	<span class="error"><?php echo $notsuccess;?></span>
  		<label>EMAIL</label> 
    	<input type="text" name="EMAIL" placeholder="@email.com" value="<?php if(isset($_POST['EMAIL'])){echo $_POST['EMAIL'];}?>" /><br><SPAN class="error"><?php echo $email_error;?></SPAN><span class="error"><br>
    </div>
    <div class="input-group">
  		<label>PASSWORD</label> 
    	<input type="password" name="password_1" placeholder="password"  /><SPAN class="error"><?php echo $password_1_error;?></SPAN>
    </div>
    <div class="input-group">
  		<button type="submit" name="submitlogin" class="btn">LOGIN</button>
  		<a class="text" href="forgot.php"><?php  echo "Forgot Password?";?></a><br><br>
  		Don't have an account yet? <a href="index.php">Create Account</a>
	</div>
</form>
<?php
session_unset();
?>
</body>
</html>