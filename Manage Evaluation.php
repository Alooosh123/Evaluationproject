<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Evalution System</title>
  <meta content="" name="description">
  <meta content="" name="keywords">


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
</head>
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

<body>

  <!-- ======= Mobile nav toggle button ======= -->
  <i class="bi bi-list mobile-nav-toggle d-xl-none"></i>

  <!-- ======= Header ======= -->
  <header id="header">
  <div class="d-flex flex-column">

      <div class="profile">
        <img src="image/logo2.png" alt="" class="img-fluid rounded-circle">
        <h1 class="text-light"><a href="index.html">Evaluation System</a></h1>
       
      </div> 

      <nav id="navbar" class="nav-menu navbar">
        <ul>
          <li><a href="Home Evaluation System.php" class="nav-link scrollto active"><i class="bx bx-home"></i> <span>Home</span></a></li> 
          <div class="col mr-2">
                                            <div class = "text-xs font-weight-bold text-primary text-uppercase mb-1">
                                               <a href ='EvaluationStudent.php' >Show Evaluation Question</a>
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            
                                            </div>
                                        </div>                 
        </ul>
      </nav><!-- .nav-menu -->
    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex flex-column justify-content-top align-items-center">
    <div class="hero-container" data-aos="fade-in">
      <h1>Result Evaluation</h1>
   <!--  <p>This my <span class="typed" data-typed-items="System"></span></p> -->
    

  <!-------- Result -------->
  <?php
  $con = mysqli_connect('localhost','root','','eva') or die('Can\'t connect to mysql server');
  $query1 = "SELECT * FROM avgrage"; // Existing query for avg table
  $query2 = "SELECT Name_Lecturer FROM lecturer"; // Get lecturer names
  $query3 = "SELECT Name_Course,type_course FROM course"; // Get course names
  $result1 = mysqli_query($con, $query1) or die ('There is an error in the query');
  $result2 = mysqli_query($con, $query2) or die ('There is an error in the query');
  $result3 = mysqli_query($con, $query3) or die ('There is an error in the query');
  if(mysqli_num_rows($result1) > 0) {
    echo '<table id="users">';
    echo '<tr>
            <th>No</th>
            <th>Name Lecturer</th>
            <th>Avg Lecturer</th>
            <th>Name Course</th>
            <th>Type course</th>
            <th>Avg Course</th>
          </tr>';
  
    while ($row1 = mysqli_fetch_assoc($result1)) 
    {
      $row2 = mysqli_fetch_assoc($result2); // Get lecturer name (assuming Id_Avg links to lecturer)
      $row3 = mysqli_fetch_assoc($result3); // Get course name (assuming Id_Avg links to course)
  
      // Combine data from all rows
      echo "<tr>
              <td>$row1[Id_Avg]</td>
              <td>" . (isset($row2['Name_Lecturer']) ? $row2['Name_Lecturer'] : '') . "</td>
              <td>$row1[Avg_lecturer]</td>
              <td>" . (isset($row3['Name_Course']) ? $row3['Name_Course'] : '') . "</td>
              <td>" . (isset($row3['type_course']) ? $row3['type_course'] : '') . "</td>
              <td>$row1[Avg_course]</td>
            </tr>";
    }
    echo '</table>';
  } 
  else
  {
    echo 'There is no information to display!!!';
  }  
  mysqli_close($con);
?>
</div>
  </section><!-- End Hero -->
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
  </footer><!-- End  Footer -->

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