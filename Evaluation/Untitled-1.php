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
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .form-container label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
    }

    .form-container input[type="radio"] {
      margin-right: 5px;
    }

    .form-container input[type="submit"] {
      padding: 10px 20px;
      background-color: #4CAF50;
      border: none;
      color: white;
      cursor: pointer;
      font-size: 16px;
      margin-top: 20px;
      border-radius: 5px;
    }

    .total {
      margin-top: 20px;
      text-align: center;
    }
  </style>
</head>
<body>
  <h1>Evaluation Form</h1>
  <div class="form-container">
    <form>
      <label for="q1">q1</label>
      <input type="radio" name="q1" value="1"> 1
      <input type="radio" name="q1" value="2"> 2
      <input type="radio" name="q1" value="3"> 3
      <input type="radio" name="q1" value="4"> 4
      <input type="radio" name="q1" value="5"> 5

      <label for="q2">q2</label>
      <input type="radio" name="q2" value="1"> 1
      <input type="radio" name="q2" value="2"> 2
      <input type="radio" name="q2" value="3"> 3
      <input type="radio" name="q2" value="4"> 4
      <input type="radio" name="q2" value="5"> 5

      <label for="q3">q3</label>
      <input type="radio" name="q3" value="1"> 1
      <input type="radio" name="q3" value="2"> 2
      <input type="radio" name="q3" value="3"> 3
      <input type="radio" name="q3" value="4"> 4
      <input type="radio" name="q3" value="5"> 5
		
	  <label for="q4">q4</label>
      <input type="radio" name="q4" value="1"> 1
      <input type="radio" name="q4" value="2"> 2
      <input type="radio" name="q4" value="3"> 3
      <input type="radio" name="q4" value="4"> 4
      <input type="radio" name="q4" value="5"> 5
		
	  <label for="q5">q5</label>
      <input type="radio" name="q5" value="1"> 1
      <input type="radio" name="q5" value="2"> 2
      <input type="radio" name="q5" value="3"> 3
      <input type="radio" name="q5" value="4"> 4
      <input type="radio" name="q5" value="5"> 5
		
		      <label for="q3">q6</label>
      <input type="radio" name="q6" value="1"> 1
      <input type="radio" name="q6" value="2"> 2
      <input type="radio" name="q6" value="3"> 3
      <input type="radio" name="q6" value="4"> 4
      <input type="radio" name="q6" value="5"> 5
		
		      <label for="q7">q7</label>
      <input type="radio" name="q7" value="1"> 1
      <input type="radio" name="q7" value="2"> 2
      <input type="radio" name="q7" value="3"> 3
      <input type="radio" name="q7" value="4"> 4
      <input type="radio" name="q7" value="5"> 5
		
		      <label for="q8">q8</label>
      <input type="radio" name="q8" value="1"> 1
      <input type="radio" name="q8" value="2"> 2
      <input type="radio" name="q8" value="3"> 3
      <input type="radio" name="q8" value="4"> 4
      <input type="radio" name="q8" value="5"> 5
		
		      <label for="q9">q9</label>
      <input type="radio" name="q9" value="1"> 1
      <input type="radio" name="q9" value="2"> 2
      <input type="radio" name="q9" value="3"> 3
      <input type="radio" name="q9" value="4"> 4
      <input type="radio" name="q9" value="5"> 5
		
		      <label for="q10">q10</label>
      <input type="radio" name="q10" value="1"> 1
      <input type="radio" name="q10" value="2"> 2
      <input type="radio" name="q10" value="3"> 3
      <input type="radio" name="q10" value="4"> 4
      <input type="radio" name="q10" value="5"> 5
		
		      <label for="q11">q11</label>
      <input type="radio" name="q11" value="1"> 1
      <input type="radio" name="q11" value="2"> 2
      <input type="radio" name="q11" value="3"> 3
      <input type="radio" name="q11" value="4"> 4
      <input type="radio" name="q11" value="5"> 5
		
		      <label for="q12">q12</label>
      <input type="radio" name="q12" value="1"> 1
      <input type="radio" name="q12" value="2"> 2
      <input type="radio" name="q12" value="3"> 3
      <input type="radio" name="q12" value="4"> 4
      <input type="radio" name="q12" value="5"> 5
		
		      <label for="q13">q13</label>
      <input type="radio" name="q13" value="1"> 1
      <input type="radio" name="q13" value="2"> 2
      <input type="radio" name="q13" value="3"> 3
      <input type="radio" name="q13" value="4"> 4
      <input type="radio" name="q13" value="5"> 5
		
		      <label for="q14">q14</label>
      <input type="radio" name="q14" value="1"> 1
      <input type="radio" name="q14" value="2"> 2
      <input type="radio" name="q14" value="3"> 3
      <input type="radio" name="q14" value="4"> 4
      <input type="radio" name="q14" value="5"> 5
		

      <!-- Repeat the above pattern for the remaining questions -->
      <br>
      <input type="submit" value="Submit">
      </br>
    </form>
  </div>

  <div class="total">
    <span>مجموع الدرجات:</span> <span id="total-score">0</span>
  </div>

  <script>
    // Function to calculate and update the total score
    function calculateTotalScore() {
      const totalScoreElement = document.getElementById('total-score');
      const radioButtons = document.querySelectorAll('input[type="radio"]:checked');
      let totalScore = 0;

      radioButtons.forEach((radioButton) => {
        totalScore += parseInt(radioButton.value);
      });

      totalScoreElement.textContent = totalScore;
    }

    // Add event listener to recalculate total score when a radio button is clicked
    const radioButtons = document.querySelectorAll('.form-container input[type="radio"]');
    radioButtons.forEach((radioButton) => {
      radioButton.addEventListener('click', calculateTotalScore);
    });
  </script>
</body>
</html>