<!doctype html>
<html>
<head>
	<link href="loginform.css" rel="stylesheet">
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
	<div class="login-wrap">
	<div class="login-html">
		<input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign In</label>
		<div class="login-form">
			
<div class="group">
  <label for="idCard" class="label">ID Card (10 digits)</label>
  <input id="idCard" type="text" class="input" pattern="[0-9]{10}" maxlength="10" required>
</div>

			   
	<div class="group">
  <label for="phone" class="label">Phone Number (max 9 digits)</label>
  <input id="phone" type="tel" class="input" data-type="phone" maxlength="9">
</div>


				<div class="group">
					<input id="check" type="checkbox" class="check" checked>
					<label for="check"><span class="icon"></span> Keep me Signed in</label>
				</div>
				<div class="group">
					<input type="submit" class="button" value="Sign In">
				</div>
				
			</div>
		</div>
	</div>
</div>
</body>
</html>