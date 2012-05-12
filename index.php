<?php
	// Logged in people must NOT be here

	session_start();
	session_destroy();

    // Load HTML5 Template

    $depth = "aat/"; include_once 'aat/header.php';
?>

<! Login/Register Buttons>

<table align=center>
	<tr>
		<td align="left">
			<button type='button'><a href="users/login.php">Login</a></button>
		</td>
		<td align="right">
			<button type='button'><a href="users/register.php">Register</a></button>
		</td>
	</tr>
</table>

<?php 
    // Load HTML5 Template

    include_once 'aat/footer.php';
?>
