<?php
    session_start();
    $conn = mysqli_connect('localhost', 'root', '' , 'eva');
    if(!empty($_SESSION['Id_users']))
    {
        $id = $_SESSION['Id_users'];
        $quary = "SELECT * FROM users WHERE Id_users = $id";
        $result = mysqli_query($conn, $quary);
        $row = mysqli_fetch_assoc($result);
    }
    else
    {
        header('location:loginUser.php');
    }

?>

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
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: iPortfolio
  * Updated: Jan 09 2024 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/iportfolio-bootstrap-portfolio-websites-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Mobile nav toggle button ======= -->
 <i class="bi bi-list mobile-nav-toggle d-xl-none"></i>

  <!-- ======= Header ======= -->
  <header id="header">
    <div class="d-flex flex-column">

      <div class="profile">
        <img src="image/logo2.png" alt="" class="img-fluid rounded-circle">
        <h1 class="text-light">Evaluation System</h1>        
      </div>

      <nav id="navbar" class="nav-menu navbar">
        <ul>
          <li><a href="#hero" class="nav-link scrollto active"><i class="bx bx-home"></i> <span>Home</span></a></li>        
          <li><a href="Manage Evaluation.php" class="nav-link scrollto"><i class="bx bx-file-blank"></i> <span>Evaluation</span></a></li>
          <li><a href="Manage lecturer.php" class="nav-link scrollto"><i class="bx bx-user"></i> <span>Manage lecturer</span></a></li>
          <li><a href="Manage Course.php" class="nav-link scrollto"><i class="bx bx-book"></i> <span>Manag Course</span></a></li>
          <li><a href="Manage Major.php" class="nav-link scrollto"><i class="bx bx-building"></i> <span>Manage Major</span></a></li>
			    <li><a href="#about" class="nav-link scrollto"><i class="bx bx-user"></i> <span>About</span></a></li>
          <li><a href="logout1.php" class="nav-link scrollto"><i class="bx bx-user"></i> <span>Log out</span></a></li>
        </ul>
      </nav><!-- .nav-menu -->
    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex flex-column justify-content-center align-items-center">
  <div class="hero-container" data-aos="fade-in">
      <h1>Evaluation System</h1>
      <p>This my <span class="typed" data-typed-items="System"></span></p>
  </div>
          <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                               Student Evaluation</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php
                                            $con = mysqli_connect('localhost', 'root', '', 'eva') or die('Can\'t connect to mysql server');

                                            $query = 'SELECT COUNT(*) AS Id_student FROM student';
                                            $result = mysqli_query($con, $query) or die('There is an error in the query');

                                            if (mysqli_num_rows($result) > 0) {
                                            $row = mysqli_fetch_assoc($result); 

                                            $totalStudents = $row['Id_student'];
                                            echo "$totalStudents";

                                            } else {
                                            echo 'There are no students in the database.';
                                            }

                                            mysqli_free_result($result); 
                                            mysqli_close($con);

                                            ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Evaluation Lecturer</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php
                                            $con = mysqli_connect('localhost', 'root', '', 'eva') or die('Can\'t connect to mysql server');

                                            $query = 'SELECT COUNT(*) AS Id_lecturer FROM result';
                                            $result = mysqli_query($con, $query) or die('There is an error in the query');

                                            if (mysqli_num_rows($result) > 0) {
                                            $row = mysqli_fetch_assoc($result); 

                                            $totalStudents = $row['Id_lecturer'];
                                            echo "$totalStudents";

                                            } else {
                                            echo 'There are no students in the database.';
                                            }

                                            mysqli_free_result($result); 
                                            mysqli_close($con);

                                            ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Evaluation Course
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                    <?php
                                                    $con = mysqli_connect('localhost', 'root', '', 'eva') or die('Can\'t connect to mysql server');

                                                    $query = 'SELECT COUNT(*) AS Id_course FROM result';
                                                    $result = mysqli_query($con, $query) or die('There is an error in the query');

                                                    if (mysqli_num_rows($result) > 0) {
                                                    $row = mysqli_fetch_assoc($result); 

                                                    $totalStudents = $row['Id_course'];
                                                    echo "$totalStudents";

                                                    } else {
                                                    echo 'There are no students in the database.';
                                                    }

                                                    mysqli_free_result($result); 
                                                    mysqli_close($con);

                                                    ?>
                                                    </div>
                                                </div>                                                
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Result</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php
                                                    $con = mysqli_connect('localhost', 'root', '', 'eva') or die('Can\'t connect to mysql server');

                                                    $query = 'SELECT COUNT(*) AS Id_result FROM result';
                                                    $result = mysqli_query($con, $query) or die('There is an error in the query');

                                                    if (mysqli_num_rows($result) > 0) {
                                                    $row = mysqli_fetch_assoc($result); 

                                                    $totalStudents = $row['Id_result'];
                                                    echo "$totalStudents";

                                                    } else {
                                                    echo 'There are no students in the database.';
                                                    }

                                                    mysqli_free_result($result); 
                                                    mysqli_close($con);

                                                    ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>    
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="section-title">
          <h2>About</h2>
          <p>By providing students with a structured and confidential platform to offer feedback on their learning experiences, we aim to empower them to contribute to the quality of teaching and, ultimately, their own academic success.</p>
          <h7>Welcome</h7>
        </div>

  <!-- ======= Footer ======= -->
 <!-- <footer id="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>3AGO</span></strong>
      </div>
      <div class="credits">
        <!- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/iportfolio-bootstrap-portfolio-websites-template/ 
        Designed by <a>3AGO</a>
      </div>
    </div>
  </footer><!- End  Footer -->

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

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->
</body>

</html>
