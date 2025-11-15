<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Forgot Password</title>

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
        
    <?php
     
if(isset($_GET['id']) && !isset($_POST['update']))
    {
        $con = @mysqli_connect('localhost','root','','eva') or die('connection is not estableished' .mysqli_connect_error());
        $id = (int) mysqli_real_escape_string($con,$_GET['id']);
        $query = 'SELECT password FROM users WHERE password = '.$id;
        $result = @mysqli_query($con,$query) or die('There is error in your query'.mysqli_error($con));
        if(mysqli_num_rows($result) == 1)
        {
            $row = mysqli_fetch_array($result,MYSQLI_BOTH);                        
        }        
        @mysqli_free_result($result);
        @mysqli_close($con);
    }
    elseif(isset($_POST['update']))
    {
        $con = @mysqli_connect('localhost','root','','eva') or die('connection is not estableished'.mysqli_connect_error());
        $id = (int) mysqli_real_escape_string($con,$_GET['id']);
        $id = is_numeric($id) ? $id : NULL;
        $errors = array();
        $fn = '';    
        if(empty($_POST['password']))
        {
            $errors[] = 'You forget to enter your first name.';            
        }
        else
        {
            $fn = mysqli_real_escape_string($con,trim($_POST['password']));
        }
        
        if(empty($errors))
        {
            $query = "UPDATE users SET password ='$fn' WHERE Id_users = $id";
            $r= @mysqli_query($con,$query);
            if($r)
            {                
              header( "refresh:0.1;url=forget-password.php" );             
              
            }
            else
            {
                echo '<h1>System Error</h1>
                <p class="error">You could not update due to a system error. We apologize for any inconvenience.</p>';
                echo '<p>'.mysqli_error($con).'<br/><br/>Query:'.$query.'</p>';
            }
            mysqli_close($con);
            exit();
        }
        else
        {
            echo '<h1>Error!</h1>
            <p class="error">The following error(s) occurred:<br/>';
            foreach($errors as $msg)
            {
                echo " - $msg<br/>\n";
            }
            echo '</p><p>Please try again.</p><p>
            <br/></p>';            
        }
    }    
?>
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block "></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                        <p class="mb-4">We get it, stuff happens. Just enter your User name below
                                            and we'll send you a link to reset your password!</p>
                                    </div>
                                    <form class="user">
                                        <div class="form-group">
                                            <input type="submit" name="update" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter a New password..." value="Update"/>
                                        </div>
                                        <a href="loginUser.php" class="btn btn-primary btn-user btn-block">
                                            Reset Password
                                        </a>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="loginUser.php">Already have an account? Login!</a>
                                    </div>
                                </div>
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