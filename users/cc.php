<script language="javascript" src="js/cc.js">
</script>

<?php
	// Load files

	require_once '../include/config.php';

    // Load HTML5 Template

    $depth = "../aat/"; include_once '../aat/header.php';

	// Get races list

	$query = "SELECT name,showname FROM races";
	$result = mysql_query($query) or die(mysql_error());

	// Characer Creation Form

	echo '<form id="cc" name="cc" action="cc_do.php" method="post" accept-charset="UTF-8">
		<fieldset>
		<legend>Character Creation</legend>
		<label for="name">Name:</label>
		<input type="text" id="name" name="name" maxlength="50" required/><br/>
		<label for="race">Race:</label>
		<select name="race" onChange="changePicture()" required>
		<option value="">Please select a race</option>';

	// Fill selection with available races

	while($row = mysql_fetch_array($result)) {
		echo '<option value="'.$row[0].'">'.$row[1].'</option>';
	}

	// Character Creation Form continues

	echo '</select></br>
		<input type="submit" value="Create"/>
		<button type="button"><a href="../index.php">Cancel</a></button>
		</fieldset>
		</form>';
?>

<img name="pic" src="images/blank.png" border="0">

<?php 
    // Load HTML5 Template

    include_once '../aat/footer.php';
?>