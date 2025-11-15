<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Evalution System</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style1.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: iPortfolio
  * Updated: Jan 09 2024 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/iportfolio-bootstrap-portfolio-websites-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <style>                              
        #users{
            border-collapse: collapse;
            width: 100%;
        }
        #users td, #users th {
            border: 1px solied #ddd;
            padding: 8px;
       }
    
          
        #users tr:nth-child(odd){background-color: #f2f2f2;}
        #users tr:nth-child(even){background-color: #f2f2f2;}
        #users tr:hover {background-color: #ddd;}
        #users th{
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: Green;
            color: white;
        }
    </style>
</head>

<body>

  <!-- ======= Mobile nav toggle button ======= -->
  <i class="bi bi-list mobile-nav-toggle d-xl-none"></i>

  <!-- ======= Header ======= -->
  <header id="header">
  <div class="d-flex flex-column">

      <div class="profile">
        <img src="image/logo2.png" alt="" class="img-fluid rounded-circle">
        <h1 class="text-light"><a href="Home Evaluation System.php">Evaluation System</a></h1>
       
      </div> 

      <nav id="navbar" class="nav-menu navbar">
        <ul>
          <li><a href="Home Evaluation System.php" class="nav-link scrollto active"><i class="bx bx-home"></i> <span>Home</span></a></li>                  
        </ul>
      </nav><!-- .nav-menu -->
    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex flex-column justify-content-top align-items-center">
    <div class="hero-container" data-aos="fade-in">
      <h1>Manage course</h1>  

    <!-----------------Result----------------------->
<?php
    
    if(!isset($_POST['submit']))
    {
      
    }
    else
    {
        $con = mysqli_connect('localhost', 'root', '', 'eva') or die('Can\'t connect to mysql server: ' . mysqli_connect_error());
  $errors = array();
  $fn = '';
		
		//==========================
		
  $selected_type = '';
		
        if(empty($_POST['name_course']) && empty($_POST['select']))
        {
            $errors[] = 'You forget to enter your course Name.';
            $errors[] = 'You forget to chosse your type_Course.';
        }
        else
        {
            $fn = mysqli_real_escape_string($con,trim($_POST['name_course']));   
             $selected_type= (int) mysqli_real_escape_string($con, $_POST['select']); // Assuming type_ ID is selected from a dropdown
		
        }        
        if(empty($errors))
        {
             if (!empty($selected_type)) {
      // Check if type_ exists
      $query = "SELECT * FROM type_course WHERE Id_type_course = $selected_type";
      $result = mysqli_query($con, $query);
      if (mysqli_num_rows($result) == 0) {
        // type_ doesn't exist, display error message
        echo "<h1>Error!</h1><p class='error'>type_ with ID '" . $selected_type. "' doesn't exist.</p><p>Please try again.</p><p><br/></p>";
      } else {
        // type_ exists, get the type_ ID
        // ... (code remains unchanged: retrieve type_ ID and insert course)
        $query = "INSERT INTO course (name_course, Id_type_course) VALUES ('$fn', '$selected_type')";
        $r = @mysqli_query($con, $query);
        if ($r) {
          echo '<h1>Thank you!</h1>
                <p>Inserted!</p><p><br/></p>';
          header("refresh:0.1; url=Manage Course.php");
        } else {
          echo '<h1>System Error</h1>
                <p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
          echo '<p>' . mysqli_error($con) . '<br/><br/>Query: ' . $query . '</p>';
        }
      }
    }else{
            echo '<h1> Error! </h1><p class="error"> The following error(s) occurred:<br/>';
            foreach($errors as $msg)
            {
                echo " - $msg<br/>\n";
            }
            echo '</p><p>please try again.</p><p><br/></p>';
				 $errors[] = 'type_ name is required.';
        }
        mysqli_free_result($result);
    }else {
    echo '<h1> Error! </h1><p class="error"> The following error(s) occurred:<br/>';
    foreach ($errors as $msg) {
      echo " - $msg<br/>\n";
    }
    echo '</p><p>please try again.</p><p><br/></p>';
  }

  mysqli_close($con);
  exit();
}
		
   //======================= 
        
    if(isset($_GET['id']) && !isset($_POST['update']))
    {
        $con = @mysqli_connect('localhost','root','','eva') or die('connection is not estableished' .mysqli_connect_error());
        $id = (int) mysqli_real_escape_string($con,$_GET['id']);
        $query = 'SELECT * FROM course WHERE Id_course = '.$id;
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
        if(empty($_POST['name_course']))
        {
            $errors[] = 'You forget to enter your first name.';            
        }
        else
        {
            $fn = mysqli_real_escape_string($con,trim($_POST['name_course']));
        }
        
        if(empty($errors))
        {
            $query = "UPDATE course SET name_course='$fn' WHERE Id_course = $id";
            $r= @mysqli_query($con,$query);
            if($r)
            {                
              header( "refresh:0.1;url=Manage course.php" );             
              
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
    
        
    if (isset($_GET['id']) && !isset($_POST['delete']))
    {
        $con = @mysqli_connect("localhost", "root", "", "eva")or die("could not connect to database" . mysqli_connect_error());
        $id = (int) mysqli_real_escape_string($con, $_GET['id']);
        $id = is_numeric($id) ? $id : NULL;
        $query = "SELECT * FROM course WHERE Id_course= $id";
        $result = @mysqli_query($con, $query) or die("query failed " . mysqli_error($con));
        if (mysqli_num_rows($result) == 1) 
        {
            $row = mysqli_fetch_array($result, MYSQLI_BOTH);            
        }
        @mysqli_free_result($result);
        @mysqli_close($con);
    } 
    elseif (isset($_POST['delete'])) 
    {
        $con = @mysqli_connect("localhost", "root", "", "eva")or die("could not connect to database" . mysqli_connect_error());
        $id = (int) mysqli_real_escape_string($con, $_GET['id']);
        $id = is_numeric($id) ? $id : NULL;
        $errors = array();        
              
    
        if (empty($errors)) {
            $query = "DELETE FROM `course` WHERE Id_course = $id";
            $r = @mysqli_query($con, $query);
            if ($r)
            {
                echo "<h1>Thank you!</h1>
                <p>User were deleted!</p><p>
                <br/></p>";
                header("refresh:0.1; url= Manage Course.php");
            }
            else{
                echo '<h1>System error</h1>
                <p class="error">you could not be delete due to a system error we apologize for any incinvenience.</p>';
                echo '<p>' . mysqli_error($con) . '<br/><br/>
                Query: ' . $query . '</p>';
            }
            mysqli_close($con);
            exit();
        }
        else{
            echo '<h1>Error!</h1>
            <p class="error">The following error(s) occurred:<br/>';
            foreach ($errors as $msg) {
                echo " - $msg<br/>\n";
            }
            echo 'Please try again.</p><p>
            <br/></p>';            
        }
    }    
    $con = mysqli_connect('localhost','root','','eva') or die('Can\'t connect to mysql server');
        $query = 'SELECT * FROM course';
        $result = mysqli_query($con,$query) or die ('There is an error in the query');
        if(mysqli_num_rows($result)>0)
        {
            echo '<table id="users">';
            echo '<tr><th>No</th>
                  <th>Name course</th>
                  <th>Name type course</th>
                  <th>Action</th>
                  </tr>';
            while($row = mysqli_fetch_assoc($result))
            {                                
                echo "<tr>  <td>$row[Id_course]</td>
                            <td>$row[name_course]</td>       
                            <td>$row[Id_type_course]</td>                                                  
                            <td><a href='Manage Course.php?id={$row['Id_course']}'title= 'Update'>Select</a>
                            <a href='Manage Course.php?id={$row['Id_course']}'title= 'Delete'></a></th></td>";                         
            }    
            echo '</table>';            
        }
        else
        {
            echo 'There is no information to display!!!';
           
        }        
        mysqli_free_result($result);
        mysqli_close($con);     
    $fn = '';    
    function printForm1($fn='')
    {
        ?>            
            <form action="" method="post">
            <p>Name course: <input type="text" name="name_course" size="15" maxlength="20" value='<?=$fn?>'/></p>
	
				
				<p>Type Course:
              <select name="select">
				          <?php
                  // Connect to database and retrieve type_course data
                  $con = mysqli_connect('localhost', 'root', '', 'eva') or die('Could not connect to MySQL server');
                  $query = "SELECT Id_type_course, type_course FROM type_course";
                  $result = mysqli_query($con, $query) or die('There is an error in the query');

                  while ($row = mysqli_fetch_assoc($result)) {
                    $selected = ($selected_type == $row['Id_type_course']) ? ' selected' : ''; // Check if the current type_ ID matches the selected one
                    echo "<option value='{$row['Id_type_course']}'{$selected}>{$row['type_course']}</option>";
                  }

                  mysqli_free_result($result);
                  mysqli_close($con);
                    ?>
                </p>
                </select>         
                <p><input type="submit" name="submit" value="Insert"/>
                  <input type="submit" name="update" value="Update"/>
                  <input type="submit" name="delete" value="delete" /></p>
            </form>
        <?php
        }    
        echo '<br/>';
        printForm1($fn='')      
        ?>      

		
<!---------------------------------------->

   <!--  <p>This my <span class="typed" data-typed-items="System"></span></p> -->
    </div> S
    </section>
        
  <main id="main">
  

  <!-- ======= Footer =======
  <footer id="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>iPortfolio</span></strong>
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/iportfolio-bootstrap-portfolio-websites-template/
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer>End  Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/typed.js/typed.umd.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

      
    
  </main><!-- End #main -->
</body>

</html>