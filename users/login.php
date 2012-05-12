<?php
	// Logged in people must NOT be here
    
	session_start();
	session_destroy();
    
    // Load HTML5 Template
    
    $depth = "../aat/"; include_once '../aat/header.php';
?>

<! Login Form>

<form id='login' action="login_do.php" method="post" accept-charset='UTF-8'>
	<fieldset>
		<legend>Login</legend>
		<label for='email'>Email:</label>
		<input type="text" id="email" name="email" maxlength="50" required/><br/>
		<label for='password'>Password:</label>
		<input type="password" id="password" name="password" maxlength="50" required/><br/>
		<input type="submit" value="Login"/>
		<button type='button'><a href="../index.php">Cancel</a></button>
	</fieldset>
</form>

<?php 
    // Load HTML5 Template

    include_once '../aat/footer.php';
?>