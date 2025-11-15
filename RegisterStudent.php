<?php
    
    if(!isset($_POST['submit']))
    {

    }
    else
    {
        $con = mysqli_connect('localhost','root','','eva') or die('Can\'t connect to mysql server');
        $errors = array();
        $fn ='';
        $ln ='';        
        if(empty($_POST['name_student']))
        {
            $errors[] = 'You forget to enter your lecturer name.';
        }
        else
        {
            $fn = mysqli_real_escape_string($con,trim($_POST['name_student']));
            $ln = mysqli_real_escape_string($con,trim($_POST['phone_no']));
        }        
        if(empty($errors))
        {
            $query = "INSERT INTO student (name_student,phone_no)VALUES('$fn','$ln')";
            $r = @mysqli_query($con,$query);
            if($r)
            {
                
                echo '<h1>Thank you!</h1>
                <p>Inserted!</p><p><br/></p>';
                echo header("refresh:0.1; url=loginform.php");
            }
            else
            {
                echo '<h1>System Error</h1>
                <p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
                echo '<p>'. mysqli_error($con).'<br/><br/>Query: '.$query.'</p>';
            }
            mysqli_close($con);
            exit();
        }
        else
        {
            echo '<h1> Error! </h1><p class="error"> The following error(s) occurred:<br/>';
            foreach($errors as $msg)
            {
                echo " - $msg<br/>\n";
            }
            echo '</p><p>please try again.</p><p><br/></p>';            
        }
        mysqli_close($con);
    } 
    ?>
<!doctype html>
<html>
<head>
	<link href="loginform.css" rel="stylesheet">
<meta charset="utf-8">
<title>Register student</title>
</head>

<body>
	<div class="login-wrap">
	<div class="login-html">
		<input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Create account student</label>
		<div class="login-form">
<form class="" action="" method="post" autocomplete="off">	
<div class="group">
  <label for="idCard" class="label">Name Student</label>
  <input type="text" name="name_student" id="name_student" class="input" maxlength="10">
</div>

			   
	<div class="group">
  <label for="phone_no" class="label">Phone Number (max 9 digits)</label>
  <input id="phone_no" type="text" name="phone_no" class="input" data-type="phone_no" maxlength="9">
</div>
				<div class="group">
					<button type="submit" name="submit" class="button" >Sign In</button>
					</form>				
		</div>
	</div>
</div>
</body>
</html>