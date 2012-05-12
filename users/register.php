<?php
	// Logged in people must NOT be here

	session_start();
	session_destroy();

    // Load HTML5 Template

    $depth = "../aat/"; include_once '../aat/header.php';
?>

<! Register Form>

<form id='register' action='register_do.php' method='post' accept-charset='UTF-8'>
	<fieldset>
		<legend>Register</legend>
		<label for='email'>Email:</label>
		<input type='text' name='email' id='email' maxlength="50" required/><br/>
		<label for='pwd1'>Password:</label>
		<input type='password' name='pwd1' id='pwd1' maxlength="50" required/><br/>
		<label for='pwd2'>Repeat Password:</label>
		<input type='password' name='pwd2' id='pwd2' maxlength="50" required/><br/>
		<input type='submit' name='Submit' value='Submit'/>
		<button type='button'><a href="../index.php">Cancel</a></button>
	</fieldset>
</form>

<?php 
    // Load HTML5 Template

    include_once '../aat/footer.php';
?>

