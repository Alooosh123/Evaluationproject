<?php
if(!isset($_POST['total']))
    {

    }
    else
    {
        $con = mysqli_connect('localhost','root','','eva') or die('Can\'t connect to mysql server');
        $errors = array();
        $fn ='';
        $ln ='';
        if(empty($_POST['Avg_lecturer']) && empty($_POST['Avg_course']))
        {
            $errors[] = 'You forget click box.';
        }
        else
        {
            $fn = mysqli_real_escape_string($con,trim($_POST['Avg_lecturer']));
            $ln = mysqli_real_escape_string($con,trim($_POST['Avg_course']));
        }        
        if(empty($errors))
        {
            $query = "INSERT INTO avg (Avg_lecturer,Avg_course)VALUES('$fn')";
            $r = @mysqli_query($con,$query);
            if($r)
            {
                
                echo '<h1>Thank you!</h1>
                <p>Inserted!</p><p><br/></p>';
                echo header("refresh:0.1; url=Manage lecturer.php");
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
<?php
    session_start();
    $conn = mysqli_connect('localhost', 'root', '' , 'eva');
    if(!empty($_SESSION['Id_student']))
    {
        $id = $_SESSION['Id_student'];
        $quary = "SELECT * FROM student WHERE Id_student = $id";
        $result = mysqli_query($conn, $quary);
        $row = mysqli_fetch_assoc($result);
    }
    else
    {
        header('location:loginform.php');
    }

?>
<!DOCTYPE html>
<html>
<head>
  <title>Evaluation Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      padding: 20px;
    }

    h1 {
      text-align: center;
    }

    .form-container {
      max-width: 500px;
      margin: 0 auto;
      background-color: #fff;
      padding-top: 50px;
      padding-left: 40px;
      padding-right: 60px;
      padding-bottom: 50px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.8);
    }

    .form-container label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
    }

    .form-container input[type="radio"] {
      margin-right: 5px;
    }

    .form-container input[type="submit"] 
    {
      padding: 10px 20px;
      background-color: #4CAF50;
      border: none;
      color: white;
      cursor: pointer;
      font-size: 16px;
      margin-top: 20px;
      border-radius: 5px;
    }
    .form-container a[type="submit"] 
    {
      padding: 10px 20px;
      background-color: #4CAF50;
      border: none;
      color: white;
      cursor: pointer;
      font-size: 16px;
      margin-top: 20px;
      border-radius: 5px;
      
    }

    .total 
    {
      margin-top: 20px;
      text-align: center;
    }
    #users
    {
      border-collapse: collapse;
       width: 100%;            
    }
        #users td, #users th {
          border: 3px solied #000;
          border-color: #001;
        }
        #users tr:nth-child(odd)
        {
          background-color: #f2f2f2;
          border: 3px solied #ddd;
          border-color: #001;
          box-shadow: 0 2px 5px rgba(0, 0, 0, 0.8);
        }
        #users tr:nth-child(even)
        {
          background-color: #f2f2f2;
          border-color: #001;
          box-shadow: 0 2px 5px rgba(0, 0, 0, 0.8);
        }
        #users tr:hover 
        {
          background-color: #ddd;
          border-color: #001;
          box-shadow: 0 2px 5px rgba(0, 0, 0, 0.8);
        }
        #users th{
            padding-left: 30px;
            padding-right: 50px;
            text-align: center;
            background-color: darkblue;
            color: white;
            border: 3px solied #000;
            border-color: #001;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.8);
        }
        #no th{
            text-align: center;
            background-color: darkblue;
            color: white;
            border: 3px solied #000;
            border-color: #001;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.8);
        }
    </style>
</head>
<body>  
  <div class="form-container">
  <h1>Evaluation Form</h1>
    <form>
    <p>Name Course:
              <select name="select">
				          <?php
                  // Connect to database and retrieve faculty data
                  $con = mysqli_connect('localhost', 'root', '', 'eva') or die('Could not connect to MySQL server');
                  $query = "SELECT * FROM course";
                  $result = mysqli_query($con, $query) or die('There is an error in the query');

                  while ($row = mysqli_fetch_assoc($result)) {
                    $selected = ($selected_faculty == $row['Id_course']) ? ' selected' : ''; // Check if the current faculty ID matches the selected one
                    echo "<option value='{$row['Id_course']}'{$selected}>{$row['name_course']}</option>";                    
                  }

                  mysqli_free_result($result);
                  mysqli_close($con);
                    ?>
                </p>
                </select>
                <p>Type Course:
              <select name="select">
				          <?php
                  // Connect to database and retrieve faculty data
                  $con = mysqli_connect('localhost', 'root', '', 'eva') or die('Could not connect to MySQL server');
                  $query = "SELECT * FROM course";
                  $result = mysqli_query($con, $query) or die('There is an error in the query');

                  while ($row = mysqli_fetch_assoc($result)) {
                    $selected = ($selected_faculty == $row['Id_course']) ? ' selected' : ''; // Check if the current faculty ID matches the selected one
                    echo "<option value='{$row['Id_course']}'{$selected}>{$row['type_course']}</option>";                  }

                  mysqli_free_result($result);
                  mysqli_close($con);
                    ?>
                </p>
                </select>      
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
          if(empty($_POST['Avg_lecturer']) && empty($_POST['Avg_course']))
          {
              $errors[] = 'You forget to enter your course name.';
          }
          else
          {
              $fn = mysqli_real_escape_string($con,trim($_POST['Avg_lecturer']));
              $ln = mysqli_real_escape_string($con,trim($_POST['Avg_course']));
          }        
          if(empty($errors))
          {
              $query = "INSERT INTO course (Avg_lecturer,Avg_course)VALUES('$fn',$ln)";
              $r = @mysqli_query($con,$query);
              if($r)
              {
                  
                  echo '<h1>Thank you!</h1>
                  <p>Inserted!</p><p><br/></p>';
                  echo header("refresh:0.1; url=EvaluationStudent.php");
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
    $con = mysqli_connect('localhost','root','','eva') or die('Can\'t connect to mysql server');
        $query = 'SELECT * FROM question_lecturer';
        $result = mysqli_query($con,$query) or die ('There is an error in the query');
        if(mysqli_num_rows($result)>0)
        {
            echo "<br/><br/>Lecturer Question:";
            echo "<br/>";
            echo '<table id="users" }>';
            echo '<tr><th>No</th>
                  <th id="no">Question lecturer</th>
                  <th>Chosee One</th>';
            while($row = mysqli_fetch_assoc($result))
            {

                echo "<tr>  <td>Q$row[Id_question_lecturer]</td>
                            <td>$row[text_qestion_lecturer]</td>                            
                            <td>1<input type='checkbox' id='Checkbox1' value='1' >2<input type='checkbox' name='q1' value='2'>3<input type='checkbox' name='q1' value='3'>4<input type='checkbox' name='q1' value='4'>5<input type='checkbox' name='q1' value='5'></th></td>";
            }
            echo '</table>';            
        }
        else
        {
            echo 'There is no information to display!!!';
           
        }        
        mysqli_free_result($result);
        mysqli_close($con); 
         
        $con = mysqli_connect('localhost','root','','eva') or die('Can\'t connect to mysql server');
        $query = 'SELECT * FROM question_course';
        $result = mysqli_query($con,$query) or die ('There is an error in the query');
        if(mysqli_num_rows($result)>0)
        {
            echo "<br/>Course Question:";
            echo '<br/><br/><table id="users" }>';
            echo '<tr><th>No</th>
                  <th>Question Course</th>
                  <th>Chosee One</th>';
            while($row = mysqli_fetch_assoc($result))
            {

                echo "<tr>  <td>Q$row[Id_question_course]</td>
                            <td>$row[text_question_course]</td>                            
                            <td>1<input type='checkbox' id='Checkbox1' value='1' >2<input type='checkbox' name='q1' value='2'>3<input type='checkbox' name='q1' value='3'>4<input type='checkbox' name='q1' value='4'>5<input type='checkbox' name='q1' value='5'></th></td>";
            }
            echo '</table>';            
        }
        else
        {
            echo 'There is no information to display!!!';
           
        }        
        mysqli_free_result($result);
        mysqli_close($con); 
        ?>      
            <!-- Repeat the above pattern for the remaining questions -->
      <br>
      <button type="total-score" value="Submit"></button>
      <a type="submit" href="logout2.php">Log out</a>
      </br>
    </form>
  </div>

  <div class="total">
    <span>مجموع الدرجات:</span> <span id="total-score"></span>
  </div>

  <script>
    // Function to calculate and update the total score
    function calculateTotalScore() {
      const totalScoreElement = document.getElementById('total-score');
      const radioButtons = document.querySelectorAll('input[type="checkbox"]:checked');
      let totalScore = 0;

      radioButtons.forEach((radioButton) => {
        totalScore += parseInt(radioButton.value);
      });

      totalScoreElement.textContent = totalScore;
    }

    // Add event listener to recalculate total score when a radio button is clicked
    const radioButtons = document.querySelectorAll('.form-container input[type="checkbox"]');
    radioButtons.forEach((radioButton) => {radioButton.addEventListener('click', calculateTotalScore);});
  </script>  
</body>
</html>