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
        if(empty($_POST['user_name']))
        {
            $errors[] = 'You forget to enter your lecturer name.';
        }
        else
        {
            $fn = mysqli_real_escape_string($con,trim($_POST['user_name']));
            $ln = mysqli_real_escape_string($con,trim($_POST['password']));
        }        
        if(empty($errors))
        {
            $query = "INSERT INTO users (user_name,password)VALUES('$fn','$ln')";
            $r = @mysqli_query($con,$query);
            if($r)
            {
                
                echo '<h1>Thank you!</h1>
                <p>Inserted!</p><p><br/></p>';
                echo header("refresh:0.1; url=loginUser.php");
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
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register User</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    
    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <?php
                            $fn = '';
                            $ln = '';
                            ?>
                            <form action="" method="post">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">                                                                            
                                        <p>Username: <input type="text" name="user_name" class="form-control form-control-user" id="exampleFirstName"
                                           placeholder="User Name" value='<?=$fn?>'/></p>                                            
                                    </div>     
                                </div>                               
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <p>Password:<input type="password" name="password" class="form-control form-control-user"
                                            id="passsword" placeholder="Password" value='<?=$ln?>'/></p>
                                    </div>                                    
                                </div>                                                              
                                <button type="submit" name="submit" class="btn btn-primary btn-user btn-block" value="Insert">Log in</button>                             
                            </form>
                            <hr>                            
                            <div class="text-center">
                                <a class="small" href="loginUser.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>    
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
