<?php session_start();
$db=mysqli_connect('localhost','root','','registration_db');
?>
<!DOCTYPE html>
<html>
<head>
	<title>library registration system</title>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
  <style type="text/css">
    .error{color: red;}
  </style>
</head>
<body>
<div class="header">
	<h2>REGISTER</h2>
	<body bgcolor="#99FFFF">
	<bg color="#550CC0"></bg>
</div>
<?php
  $name=$email=$password_1=$password_2=$feedback=$feedback2=$match= "";
  $name_error=$email_error=$password_1_error=$password_2_error=$password_error=$check_error=$limit1=$limit2="";
  
  if ($_SERVER["REQUEST_METHOD"]=='POST') {
    // checking the names presence
      if (empty($_POST['NAME'])) {
        $name_error="Name Required";
        }
        else
          $match=!preg_match("/^[a-zA-Z ]*$/",$_POST['NAME']);
          if ($match) {
            $name_error = "Only letters and white space allowed"; 
          }
          else 
            $name=test_input($_POST['NAME']);
           
      // checking for the validity of the email
        if (empty($_POST['EMAIL'])) {
        $email_error="email Required";
        }
        else
        {
          $email=test_input($_POST['EMAIL']);
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_error="Invalid Email Format";
        }
      }
      // testing password 1
        if (empty($_POST['password_1'])) {
        $password_1_error="Password cant be left empty";
      }
        else{
          $limit1=strlen($_POST['password_1'])>3;
      if (!$limit1) {
      $password_1_error="Enter atleast 4 characters for the password";
      }
      else{
      $password_1=test_input($_POST['password_1']);
    }
  }
      // testing password 2
        if (empty($_POST['password_2'])) {
        $password_2_error="Password cant be left empty";
      }
        else{
          // testing if password is <4 chracters
          $limit2=strlen($_POST['password_2'])> 3;
          if (!$limit2) {
            $password_2_error="Enter atleast 4 characters for the password";
          }
          else{
          $password_2=test_input($_POST['password_2']);
          }
        } 
      // testing both passwords similarity 
      if ($password_1!=$password_2) {
        $password_error=("passwords do not match");
      }
  }
   function test_input($ray)
      {
        $ray=htmlspecialchars($ray);
        $ray=trim($ray);
        $ray=stripcslashes($ray);
        return $ray;
      }
?>
<!-- insertion of data into a table in a database -->
<?php
 if (isset($_POST["submit"])) {
  $name=$_POST['NAME'];
  $email=$_POST['EMAIL'];
  $password_1=$_POST['password_1'];
  $password_2=$_POST['password_2'];
  if ($password_1!=$password_2) {
        $password_error=("passwords do not match");
      }
    else{
      if (!empty($name&&$email&&$password_1&&$password_2)&&(filter_var($email, FILTER_VALIDATE_EMAIL))&&$limit1&&$limit2&&!$match) {
      $sql="INSERT INTO students (NAME,EMAIL,PASSWORD)
            VALUES('$name','$email','$password_1')";
      $result=mysqli_query($db,$sql);
      
      if ($result) {
          // sleep(2);
        $feedback="Data has been successfully sent";
        sleep(3);
        header('location:login.php?login');
      }
      else
        $feedback2="The user with such email already exists";
    }
   }
  }
mysqli_close($db);
?>
<!-- form  -->
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<div class="input-group">
  		<label>NAME</label> 
    	<input type="text" name="NAME" placeholder="username" value="<?php if(isset($_POST['NAME'])){echo $_POST['NAME'];}?>" /><br><SPAN class="error"><?php echo $name_error;?></SPAN>
    </div>
    <div class="input-group">
  		<label>EMAIL</label> 
    	<input type="text" name="EMAIL" placeholder="@email.com" value="<?php if(isset($_POST['EMAIL'])){echo $_POST['EMAIL'];}?>" /><SPAN class="error"><?php echo $email_error;?></SPAN><span class="error"><?php echo $check_error;?></span><br>
    </div>
    <div class="input-group">
  		<label>PASSWORD</label> 
    	<input type="password" name="password_1" placeholder="password"  /><SPAN class="error"><?php echo $password_1_error;?></SPAN>
    </div>
    
    <div class="input-group">
  		<label>CONFIRM PASSSWORD</label> 
    	<input type="password" name="password_2"  placeholder="password" /><SPAN class="error"><?php echo $password_2_error;?></SPAN>
    </div>
    <div class="input-group">
  		<button type="submit" name="submit" class="btn">REGISTER</button><br>
      <SPAN class="error"><?php echo $password_error;?></SPAN>
  	</div>
    <SPAN class="error"><?php echo $feedback;?></SPAN>
    <SPAN class="error"><?php echo $feedback2;?></SPAN><br>
    Already have an account? <a href="login.php">sign in</a>
</form>
	<?php
session_destroy();
  ?>
</body>
</html>