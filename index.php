<?php
	// Logged in people must NOT be here

	session_start();
	session_destroy();
?>

<?php include 'aat/header.php';?>

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

<?php include 'aat/footer.php';?>
