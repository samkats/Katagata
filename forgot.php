<?php
session_start();
$db=mysqli_connect('localhost','root','','registration_db') or die('couldn\'t estabblish connection ');
$email=$password_1=$success="";
$email_error=$password_1_error=$notsuccess=$error="";
	if ($_SERVER['REQUEST_METHOD']=="POST") {
	if (empty($_POST['EMAIL'])) {
		$email_error="your email is needed to login";
	}
	else{
		$email=test_input($_POST['EMAIL']);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$email_error="Invalid email format";
		}
	}
}
function test_input($data){
 $data=trim($data);
 $data=stripcslashes($data);
 $data=htmlspecialchars($data);
}
?>
<?php
if (isset($_POST['forgot'])) {
	
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>FORGOT PASSWOR</title>
	<!-- <link rel="stylesheet" type="text/css" href="style-all.css"> -->
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<h3 align="center"><br><br>please provide the emial address you used to create an account</h3>
	<form class="" role="form" method="POST" action="">
		<div class="input-group">
			<input type="text" name="EMAIL" placeholder="@email.com" value="<?php if(isset($_POST['EMAIL'])){echo $_POST['EMAIL'];}?>" /><br><SPAN class="error"><?php echo $email_error;?></SPAN><span class="error"><br>
			<div class="input-group">
			<button class="btn" type="submit" name="forgot">SEND</button>
			</div>
		</div>
	</form>
</body>
</html>